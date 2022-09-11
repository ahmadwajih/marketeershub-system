<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\PivotReportExport;
use App\Facades\SallaFacade;
use App\Http\Controllers\Controller;
use App\Jobs\UpdateUsersPassword;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\LoginUser;
use App\Models\Offer;
use App\Models\Order;
use App\Models\PivotReport;
use App\Models\PublisherCategory;
use App\Models\Role;
use App\Models\SallaInfo;
use App\Models\User;
use App\Models\UserActivity;
use App\Notifications\NewAssigenCoupon;
use App\Notifications\NewOffer;
use App\Notifications\UpdateValidation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PDO;

class DashboardController extends Controller
{
    public function index(){

        $this->authorize('view_dashboard');

        // Get all offers that have coupons and report
        $offers  = Offer::whereHas('report')->with(['report'])->get(); 

        // Get all  account managers 
        $accountManagers = User::where('position', 'account_manager')->with('users')->has('users')->orderBy('team')->get();
    
        // Team Performance data 
        $teamPerformance  = DB::table('pivot_reports')
        ->select(
                DB::raw('pivot_reports.orders as orders'), 
                DB::raw('pivot_reports.revenue as revenue'),
                'pivot_reports.date as date',
                'users.team as team',
            )
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->orderBy('orders',  'DESC')
            ->groupBy('team', 'date')
            ->having('orders', '>', 0)
            ->get();

        return view('admin.index', [
            'offers' => $offers,
            'accountManagers' => $accountManagers,
            'totalNumbers' => totalNumbers(),
            'totalInfluencerNumbers' => totalNumbersForSeparateTeam('influencer'),
            'totalAffiliateNumbers' => totalNumbersForSeparateTeam('affiliate'),
            'totalMediaBuyingNumbers' => totalNumbersForSeparateTeam('media_buying'),
            'teamPerformance' => $teamPerformance->groupBy('date')->first()
        ]);

        return view('admin.index');
    }


    public function changeLang($lang){
        session(['lang' => $lang]);
        return redirect()->back();
    }

    // Charts
    public function chartGmVPo()
    {
        $series = [];
        $offers  = Offer::whereHas('report')->with(['report'])->orderBy('id', 'desc')->get();
        $totalNumbers  = totalNumbers();
        $totalGrossMargin = $totalNumbers->revenue - $totalNumbers->payout;
        $orders = DB::table('pivot_reports')
        ->select(
            DB::raw('TRUNCATE(SUM(pivot_reports.orders),2) as orders'), 
            DB::raw('TRUNCATE(SUM(pivot_reports.sales) ,2) as sales'), 
            DB::raw('TRUNCATE(SUM(pivot_reports.revenue) ,2) as revenue'),  
            DB::raw('TRUNCATE(SUM(pivot_reports.payout) ,2) as payout'),
            DB::raw('TRUNCATE(SUM(pivot_reports.revenue) - SUM(pivot_reports.payout) ,2) as grossmargin')
        )
        ->join('offers', 'pivot_reports.offer_id', '=', 'offers.id')
        ->orderBy('offers.id', 'desc')
        ->groupBy('offers.id')
        ->get();
    
        $data = [
            'orders' => [
                'series' => [
                    [
                        'name' => 'Orders',
                        'data' => $orders->pluck('orders')->toArray(),
                    ],
                    [
                        'name' => 'Revenue',
                        'data' => $orders->pluck('revenue')->toArray(),
                    ],
                    [
                        'name' => 'Gros Margin',
                        'data' => $orders->pluck('grossmargin')->toArray(),
                    ],
                    [
                        'name' => 'Payout',
                        'data' => $orders->pluck('payout')->toArray(),
                    ],
                ],

                'chartOptions' => [
                    'chart' => [
                        'height' => 100,
                        'type' => 'bar',
                    ],
                    'legend' => [
                        'position' => 'top'
                    ],
                    'plotOptions' => [
                        'bar' => [
                            'horizontal' => false,
                            'columnWidth' => '55%',
                            'endingShape' => 'rounded'
                        ],
                    ],
                    'dataLabels' => [
                        'enabled' => false
                    ],
                    'stroke' => [
                        'show' => true,
                        'width' => 2,
                        'colors' => ['transparent']
                    ],
                    'xaxis' => [
                        'categories' => $offers->pluck('name')->toArray(),
                    ],
                ],
            ]
            ];
        return response()->json($data, 200);
    }

    public function chartOffersAnalytics()
    {
        $offers  = Offer::whereHas('report')->with(['report'])->orderBy('id', 'desc')->get();
        $totalNumbers  = totalNumbers();
        $totalGrossMargin = $totalNumbers->revenue - $totalNumbers->payout;
        $orders = DB::table('pivot_reports')
        ->select(
            DB::raw('TRUNCATE(SUM(pivot_reports.orders) / '.$totalNumbers->orders.' * 100 ,2) as orders'), 
            DB::raw('TRUNCATE(SUM(pivot_reports.sales) / '.$totalNumbers->sales.' * 100 ,2) as sales'), 
            DB::raw('TRUNCATE(SUM(pivot_reports.revenue) / '.$totalNumbers->revenue.' * 100 ,2) as revenue'),  
            DB::raw('TRUNCATE(SUM(pivot_reports.payout) / '.$totalNumbers->payout.' * 100 ,2) as payout'),
            DB::raw('TRUNCATE((SUM(pivot_reports.revenue) - SUM(pivot_reports.payout))  / '.$totalGrossMargin.' * 100 ,2) as grossmargin')
        )
        ->join('offers', 'pivot_reports.offer_id', '=', 'offers.id')
        ->orderBy('offers.id', 'desc')
        ->groupBy('offers.id')
        ->get();

        $data = [
            'orders' => [
                'series' => $orders->pluck('orders')->toArray(),
                'chartOptions' => [
                    'labels' => $offers->pluck('name')->toArray(),
                    'chart' => [
                        'width' => 680,
                        'type' => 'pie',
                    ],
                    'legend' => [
                        'position' => 'bottom'
                    ],
                    'stroke' => [
                        'show' => false,
                    ],
                ],
            ],

            'revenue' => [
                'series' => $orders->pluck('revenue')->toArray(),
                'chartOptions' => [
                    'labels' => $offers->pluck('name')->toArray(),
                    'chart' => [
                        'width' => 680,
                        'type' => 'pie',
                    ],
                    'legend' => [
                        'position' => 'bottom'
                    ],
                    'stroke' => [
                        'show' => false,
                    ],
                ],
            ],

            'grossmargin' => [
                'series' => $orders->pluck('grossmargin')->toArray(),
                'chartOptions' => [
                    'labels' => $offers->pluck('name')->toArray(),
                    'chart' => [
                        'width' => 680,
                        'type' => 'pie',
                    ],
                    'legend' => [
                        'position' => 'bottom'
                    ],
                    'stroke' => [
                        'show' => false,
                    ],
                ],
            ],

            'payout' => [
                'series' => $orders->pluck('payout')->toArray(),
                'chartOptions' => [
                    'labels' => $offers->pluck('name')->toArray(),
                    'chart' => [
                        'width' => 680,
                        'type' => 'pie',
                    ],
                    'legend' => [
                        'position' => 'bottom'
                    ],
                    'stroke' => [
                        'show' => false,
                    ],
                ],
            ],

        ];
        return response()->json($data);
    }


    public function loginUsers(Request $request){

        if ($request->ajax()){
            $users = getModelData('LoginUser' , $request);
            return response()->json($users);
        }
        return view('admin.login-users');

    }
    
    public function test(Request $request)
    {
        $ids = [
            'inf-1052',
            'inf-4007',
            'inf-1428',
            'inf-1181',
            'inf-1185',
            'inf-1321',
            'inf-1000',
            'inf-5678',
            'inf-1095',
            'inf-1180',
            'inf-1443',
            'inf-1454',
            'inf-1463',
            'inf-4487',
            'inf-1508',
            'inf-1016',
            'inf-1308',
            'inf-5543',
            'inf-1314',
            'inf-1195',
            'inf-5856',
            'inf-5912',
            'inf-3287',
            'inf-1388',
            'inf-1178',
            'inf-1177',
            'inf-1047',
            'inf-1275',
            'inf-1224',
            'inf-5553',
            'inf-5603',
            'inf-3693',
            'inf-1082',
            'inf-1048',
            'inf-1297',
            'inf-1199',
            'inf-5531',
            'inf-1380',
            'inf-2168',
            'inf-3421',
            'inf-4302',
            'inf-1573',
            'inf-5687',
            'inf-5702',
            'inf-1289',
            'inf-4145',
            'inf-5588',
            'inf-5580',
            'inf-3940',
            'inf-3204',
            'inf-3798',
            'inf-4337',
            'inf-4139',
            'inf-4551',
            'inf-3672',
            'inf-1388',
            'inf-2221',
            'inf-5771',
            'inf-1476',
            'inf-5697',
            'inf-5886',
            'inf-4030',
            'inf-4564',
            'inf-1318',
            'inf-3701',
            'inf-1051',
            'inf-1467',
            'inf-1818',
            'inf-1230',
            'inf-4337',
            'inf-1162',
            'inf-1036',
            'inf-2801',
            'inf-1279',
            'inf-5897',
            'inf-3823',
            'inf-3742',
            'inf-1456',
            'inf-4946',
            'inf-4875',
            'inf-3650',
            'inf-1287',
            'inf-1117',
            'inf-4456',
            'inf-1259',
            'inf-1249',
            'inf-4099',
            'inf-3867',
            'inf-1000',
            'inf-4337',
            'inf-3720',
            'inf-4337',
            'inf-1891',
            'inf-3229',
            'inf-5945',
            'inf-1221',
            'inf-5749',
            'inf-3149',
            'inf-1269',
            'inf-3787',
            'inf-4420',
            'inf-2801',
            'inf-1205',
            'inf-4254',
            'inf-5790',
            'inf-6086',
            'inf-1288',
            'inf-1188',
            'inf-1080',
            'inf-6169',
            'inf-1984',
            'inf-4360',
            'inf-4491',
            'inf-1451',
            'inf-1854',
            'inf-1173',
            'inf-1477',
            'inf-6042',
            'inf-1005',
            'inf-1440',
            'inf-2679',
            'inf-1265',
            'inf-1000',
            'inf-6008',
            'inf-1045',
            'inf-2702',
            'inf-1823',
            'inf-1547',
            'inf-1267',
            'inf-1124',
            'inf-1850',
            'inf-1787',
            'inf-1389',
            'inf-1136',
            'inf-2881',
            'inf-4071',
            'inf-1217',
            'inf-1400',
            'inf-1573',
            'inf-1362',
            'inf-1394',
            'inf-3864',
            'inf-4038',
            'inf-1728',
            'inf-1129',
            'inf-3453',
            'inf-1071',
            'inf-2990',
            'inf-1250',
            'inf-1296',
            'inf-1889',
            'inf-1526',
            'inf-2084',
            'inf-4034',
            'inf-1000',
            'inf-1075',
            'inf-5004',
            'inf-1053',
            'inf-2630',
            'inf-4438',
            'inf-2911',
            'inf-1243',
            'inf-1533',
            'inf-1347',
            'inf-4534',
            'inf-1113',
            'inf-1421',
            'inf-1456',
            'inf-1179',
            'inf-1378',
            'inf-3628',
            'inf-1000',
            'inf-4459',
            'inf-3594',
            'inf-4311',
            'inf-1150',
            'inf-1549',
            'inf-1071',
            'inf-3864',
            'inf-3973',
            'inf-4572',
            'inf-3864',
            'inf-3154',
            'inf-2128',
            'inf-2975',
            'inf-3937',
            'inf-4159',
            'inf-1000',
            'inf-1571',
            'inf-1169',
            'inf-4921',
            'inf-1658',
            'inf-2163',
            'inf-3798',
            'inf-2660',
            'inf-3733',
            'inf-3979',
            'inf-1203',
            'inf-3971',
            'inf-1011',
            'inf-1000',
            'inf-2593',
            'inf-2697',
            'inf-1169',
            'inf-3146',
            'inf-3866',
            'inf-3379',
            'inf-4559',
            'inf-4914',
            'inf-1071',
            'inf-1329',
            'inf-999',
            'inf-999',
            'inf-999',
            'inf-999',
            'inf-2650'
        ];
        
        $ids = array_unique($ids);
        $affiliates = User::wherePosition('publisher')->whereTeam('influencer')->whereIn('ho_id', $ids)->pluck('ho_id')->toArray();
        $dif = array_diff($ids , $affiliates);

        dd([
            'ids' => count($ids),
            'diff' => $dif,
            'influencers' => count($affiliates),
        ]);

        // $coupons = Coupon::where('offer_id', 20)->where('user_id', 2)->where('created_at', '>=', '2022-09-08')->get();
        // foreach($coupons as $coupon){
        //     $coupon->forceDelete();
        // }
        // dd($coupons);
        // $repoorts = PivotReport::get();
        // foreach($repoorts as $report){
        //     $report->forceDelete();
        // }
        // dd($repoorts);
        // dd($coupons);
        // $users = User::all();
        // dd(count($users->where('parent_id', '!=', null)));
        // dd(count($users));
    }

}

