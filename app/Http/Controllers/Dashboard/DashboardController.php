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
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PDO;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Expr\FuncCall;
use PHPUnit\Framework\Constraint\Count;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_dashboard');
        if ($request->from_date && $request->to_date) {
            session()->put('from_date', $request->from_date);
            session()->put('to_date', $request->to_date);
        }else{
            session()->put('from_date', now()->startOfYear()->format('Y-m-d'));
            session()->put('to_date', now()->endOfYear()->format('Y-m-d'));
        }
        $from = session('from_date');
        $to = session('to_date');


        $offersTotals = DB::table('pivot_reports')
            ->select(
                DB::raw('SUM(pivot_reports.orders) as orders'),
                DB::raw('SUM(pivot_reports.sales) as sales'),
                DB::raw('SUM(pivot_reports.revenue) as revenue'),
                DB::raw('SUM(pivot_reports.payout) as payout'),
                'pivot_reports.date as date',
                'offers.id  as offer_id',
                'offers.name_en  as offer_name',
                'offers.name_en  as offer_name',
                'offers.thumbnail  as thumbnail',
            )
            ->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:29'])
            ->join('offers', 'pivot_reports.offer_id', 'offers.id')
            ->join('coupons', 'pivot_reports.coupon_id', 'coupons.id')
            ->join('users', 'coupons.user_id', 'users.id')
            ->groupBy('offer_id')
            ->get();

        $map = [];
        foreach ($offersTotals as $index => $offerTeams) {
            $offerDetils = Offer::findOrFail($offerTeams->offer_id);
            // Offer
            $map[$index]['offer']['name'] = $offerDetils->name;
            $map[$index]['offer']['thumbnail'] = $offerDetils->thumbnail;
            $map[$index]['offer']['id'] = $offerDetils->id;
            $map[$index]['offer']['orders'] = $offerDetils->prvotReports()->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:29'])->sum('orders');
            $map[$index]['offer']['sales'] = $offerDetils->prvotReports()->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:29'])->sum('sales');
            $map[$index]['offer']['revenue'] = $offerDetils->prvotReports()->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:29'])->sum('revenue');
            $map[$index]['offer']['payout'] = $offerDetils->prvotReports()->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:29'])->sum('payout');
            $map[$index]['offer']['gross_margin'] = $offerDetils->prvotReports()->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:29'])->sum('revenue') - $offerDetils->prvotReports()->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:29'])->sum('payout');

            // Teams
            $temsTotal =  DB::table('pivot_reports')
            ->select(
                DB::raw('SUM(pivot_reports.orders) as orders'),
                DB::raw('SUM(pivot_reports.sales) as sales'),
                DB::raw('SUM(pivot_reports.revenue) as revenue'),
                DB::raw('SUM(pivot_reports.payout) as payout'),
                'pivot_reports.date as date',
                'offers.id  as offer_id',
                'offers.name_en  as offer_name',
                'offers.name_en  as offer_name',
                'offers.thumbnail  as thumbnail',
                'users.team  as team',
            )
            ->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:29'])
            ->where('offers.id', $offerTeams->offer_id)
            ->join('offers', 'pivot_reports.offer_id', 'offers.id')
            ->join('coupons', 'pivot_reports.coupon_id', 'coupons.id')
            ->join('users', 'coupons.user_id', 'users.id')
            ->groupBy('team')
            ->get();
                // dd($temsTotal);
            foreach ($temsTotal as $team) {
                // dd($team);
                $map[$index]['team'][$team->team]['orders'] =  $team->orders;
                $map[$index]['team'][$team->team]['sales'] =  $team->sales;
                $map[$index]['team'][$team->team]['revenue'] =  $team->revenue;
                $map[$index]['team'][$team->team]['payout'] =  $team->payout;
                $map[$index]['team'][$team->team]['gross_margin'] =  $team->revenue - $team->payout;
            }
        }


        // Totals 
      
        Cache::remember('total_users', 60*60*60*24, function () {
            $data = [];
            $allusers =  User::with('roles');

            $data['heads'] = $allusers->whereHas('roles', function($query){
                $query->where('label','head');
            })->count();
            $allusers =  User::with('roles');

            $allusers =  User::with('roles');

            $data['publishers'] = $allusers->whereHas('roles', function($query){
                $query->where('label','publisher');
            })->count();
            $allusers =  User::with('roles');

            $data['account_managers'] = $allusers->whereHas('roles', function($query){
                $query->where('label','account_manager');
            })->count();
            $allusers =  User::with('roles');

            $data['affiliates'] = $allusers->where('team', 'affiliate')->whereHas('roles', function($query){
                $query->where('label','publisher');
            })->count();
            $allusers =  User::with('roles');

            $data['influencers'] = $allusers->where('team', 'influencer')->whereHas('roles', function($query){
                $query->where('label','publisher');
            })->count();
            $allusers =  User::with('roles');

            $data['affiliates_account_managers'] = $allusers->where('team', 'affiliate')->whereHas('roles', function($query){
                $query->where('label','account_manager');
            })->count();
            $allusers =  User::with('roles');

            $data['influencers_account_managers'] = $allusers->where('team', 'influencer')->whereHas('roles', function($query){
                $query->where('label','account_manager');
            })->count();
            $allusers =  User::with('roles');

            $data['affiliates_heads'] = $allusers->where('team', 'affiliate')->whereHas('roles', function($query){
                $query->where('label','head');
            })->count();
            $allusers =  User::with('roles');

            $data['influencers_heads'] = $allusers->where('team', 'influencer')->whereHas('roles', function($query){
                $query->where('label','head');
            })->count();

            return $data;
        });

        $totals = DB::table('pivot_reports')
            ->select(
                DB::raw('SUM(pivot_reports.orders) as orders'),
                DB::raw('SUM(pivot_reports.sales) as sales'),
                DB::raw('SUM(pivot_reports.revenue) as revenue'),
                DB::raw('SUM(pivot_reports.payout) as payout'),
                'pivot_reports.date as date',
            )
            ->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:29'])
            ->first();

        $teamsTotals = DB::table('pivot_reports')
            ->select(
                DB::raw('SUM(pivot_reports.orders) as orders'),
                DB::raw('SUM(pivot_reports.sales) as sales'),
                DB::raw('SUM(pivot_reports.revenue) as revenue'),
                DB::raw('SUM(pivot_reports.payout) as payout'),
                'pivot_reports.date as date',
                'users.team as team'
            )
            ->whereBetween('date', [$from . ' 00:00:00', $to . ' 23:59:29'])
            ->join('coupons', 'pivot_reports.coupon_id', 'coupons.id')
            ->join('users', 'coupons.user_id', 'users.id')
            ->groupBy('team')
            ->get();

                

        return view('new_admin.index', [
            'maps' => $map,
            'totalNumbers' => $totals,
            'totalInfluencerNumbers' => $teamsTotals->where('team', 'influencer')->first(),
            'totalAffiliateNumbers' => $teamsTotals->where('team', 'affiliate')->first(),
            'totalMediaBuyingNumbers' => $teamsTotals->where('team', 'media_buying')->first(),
            'totalUsers' => Cache::get('total_users')
        ]);

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

        return view('new_admin.index', [
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



    public function changeLang($lang)
    {
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
                DB::raw('TRUNCATE(SUM(pivot_reports.orders) / ' . $totalNumbers->orders . ' * 100 ,2) as orders'),
                DB::raw('TRUNCATE(SUM(pivot_reports.sales) / ' . $totalNumbers->sales . ' * 100 ,2) as sales'),
                DB::raw('TRUNCATE(SUM(pivot_reports.revenue) / ' . $totalNumbers->revenue . ' * 100 ,2) as revenue'),
                DB::raw('TRUNCATE(SUM(pivot_reports.payout) / ' . $totalNumbers->payout . ' * 100 ,2) as payout'),
                DB::raw('TRUNCATE((SUM(pivot_reports.revenue) - SUM(pivot_reports.payout))  / ' . $totalGrossMargin . ' * 100 ,2) as grossmargin')
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


    public function loginUsers(Request $request)
    {

        if ($request->ajax()) {
            $users = getModelData('LoginUser', $request);
            return response()->json($users);
        }
        return view('admin.login-users');
    }

    public function test(Request $request)
    {

        $jobs = DB::table('jobs')->get();
        if($jobs){

        }

        
        foreach($jobs as $job){
            dd($job);
        }

        
        $data = [
            'old_coupons_count' =>  session('upload_coupon_report')['total_coupons'],
            'upload_coupons_count' =>  session('upload_coupon_report')['total_uploaded_coupons'],
            'current_coupons_count' => Coupon::count(),
        ];
        dd($data);

        abort(404);
        //Marketeers Hub
        // $user = User::create([
        //     'name'                  => 'Marketeers Hub',
        //     'password'              => Hash::make('JGKJSK#@#@#dsfsdfFFSFsgd4545'),
        //     'ho_id'   => '1000',
        //     'years_of_experience'   => '5',
        //     'gender'                => 'male',
        //     'team'                  => 'media_buying',
        //     'position'              => 'publisher',
        //     'email'                 => 'info@marketeershub.com',
        //     'phone'                 => '123456789',
        //     'traffic_sources'       => 'traffic sources',
        //     'affiliate_networks'    => 'media buying networks',
        //     'owened_digital_assets' => 'owened digital assets',
        //     'account_title'         => 'account_title',
        //     'bank_name'             => 'bank_name',
        //     'bank_branch_code'      => 'bank_branch_code',
        //     'swift_code'            => 'swift_code',
        //     'iban'                  => 'iban',
        //     'currency_id'           => 1,
        //     'status'                => 'active'
        // ]);
        // $user->assignRole(Role::whereLabel('publisher')->first());
        // dd($user);
    }
}
