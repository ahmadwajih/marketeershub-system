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

class DashboardController extends Controller
{
    public function index(){

        $this->authorize('view_dashboard');

        // Get all offers that have coupons and report
        $offers  = Offer::whereHas('report')->with(['report'])->get(); 

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
        

        $id = 7807;
        $request->validate([
            'from' => "nullable|before:to",
            'to' => "nullable|after:from",
        ]);
        $userId = ($id == null) ? auth()->user()->id : $id;
        $publisher = ($id == null) ? auth()->user() : User::findOrFail($id);
        
        $childrens = userChildrens($publisher);
        // $childrens = userChildrens($id) ?? [0=>0];
        // $childrens = $publisher->childrens()->pluck('id')->toArray();
        array_push($childrens, $userId);
        // dd($childrens);
        
        // Chaeck if login user team and check publisher team to make sure there is in the same team
        if(isset($id) && in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
            if(auth()->user()->team == $publisher->team){
                if(!in_array($id, userChildrens())){
                    abort(401);
                }
            }else{
                abort(401);
            }
        }
      

        $startDate = Carbon::now(); //returns current day
        $firstDay = $startDate->firstOfMonth()->format('Y-m-d');
        $lastDay = $startDate->lastOfMonth()->format('Y-m-d');
        // Date 
        $where = [
            ['pivot_reports.date', '>=', $firstDay],
            ['pivot_reports.date', '<=', $lastDay]
        ];

        if(isset($request->from) && $request->from != null && isset($request->to) && $request->to != null){
            $where[0] = ['pivot_reports.date', '>=', $request->from];
            $where[1] = ['pivot_reports.date', '<=', $request->to];
        }

        
        $offers = Offer::whereHas('coupons', function($q) use($childrens) {
            $q->whereIn('user_id', $childrens);
        })->with(['users' => function($q) use($childrens){
            $q->whereIn('users.id', $childrens);
        },
        'coupons' => function($q) use($childrens){
            $q->whereIn('coupons.user_id', $childrens);
        }])->get();


        $activeOffers = DB::table('pivot_reports')
        ->select(
                DB::raw('TRUNCATE(SUM(pivot_reports.orders),2) as orders'), 
                DB::raw('TRUNCATE(SUM(pivot_reports.sales) ,2) as sales'),
                DB::raw('TRUNCATE(SUM(pivot_reports.revenue) ,2) as revenue'),
                'offers.id as offer_id',
                'offers.name_en as offer_name',
                'offers.status as offer_status',
                'offers.thumbnail as thumbnail',
                // 'offers.description_en as description',
                'pivot_reports.date as date',
                DB::raw('COUNT(coupons.id) as coupons')
            )
            ->join('offers', 'pivot_reports.offer_id', '=', 'offers.id')
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->whereIn('coupons.user_id', $childrens)
            ->where($where)
            ->orderBy('date',  'DESC')
            ->groupBy('offer_name', 'date')
            ->get();
        
            $totalNumbers = DB::table('pivot_reports')
            ->select(DB::raw('SUM(orders) as orders'), DB::raw('SUM(sales) as sales'), DB::raw('SUM(revenue) as revenue'))
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->whereIn('coupons.user_id', $childrens)
            ->where($where)
            ->orderBy('date',  'DESC')
            ->groupBy('date')
            ->first();
            
        return view('admin.publishers.profile', [
            'publisher' => $publisher,
            'offers' => $offers,
            'activeOffers' => $activeOffers->groupBy('date')->first(), 
            'totalNumbers' => $totalNumbers
        ]);
        





















        $reports = PivotReport::where('date', '2022-05-25')->get();
        // return Excel::download(new PivotReportExport, 'report.csv');

        return view('admin.test', ['reports' => $reports]);
    }

}

