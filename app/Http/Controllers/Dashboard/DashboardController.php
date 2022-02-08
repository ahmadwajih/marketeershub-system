<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\SallaFacade;
use App\Http\Controllers\Controller;
use App\Jobs\UpdateUsersPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Offer;
use App\Models\Order;
use App\Models\PivotReport;
use App\Models\PublisherCategory;
use App\Models\SallaInfo;
use App\Models\User;
use App\Notifications\NewOffer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index(){

        $this->authorize('view_dashboard');

        // Get all offers that have coupons and report
        $offers  = Offer::whereHas('report')->with(['report'])->get(); 

        // Team Performance data 
        $teamPerformance  = DB::table('pivot_reports')
        ->select(
                DB::raw('TRUNCATE(SUM(pivot_reports.orders),2) as orders'), 
                DB::raw('TRUNCATE(SUM(pivot_reports.revenue) ,2) as revenue'),
                'pivot_reports.date as date',
                'users.team as team',
            )
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->orderBy('orders',  'DESC')
            ->groupBy('team', 'date')
            ->having('orders', '>', 0)
            ->get();

            // dd(publisherPerformanceBasedOnTeam('affiliate')->groupBy('user'));
            foreach(publisherPerformanceBasedOnTeam('affiliate')->groupBy('user') as $pub){
                // dd($pub->first());
            }
        

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


    public function test(Request $request){


        $response = Http::withHeaders([
            'Authorization' => 'Bearer 8ro2tEOyeFDA1A0fOjzKf4-est68U6WLXB-2vVF5JUk.9qwfh2lTuwFVyxCwAh8eaHsFcad76GXsWFeQ51M8HQ4',
            'Content-Type' => 'application/json',
            'CF-Access-Client-Id' => env('SALLA_CLIENT_ID'),
            'CF-Access-Client-Secret' => env('SALLA_CLIENT_SECRET'),
        ])->post('https://api.salla.dev/admin/v2/affiliates', [
            'marketer_name' => 'Marketeers Hub',
            'marketer_city' => 'Riyadh',
            'commission_type' => 'fixed',
            'amount' => '10',
            'apply_to' => 'first_order',
            'notes' => 'notes',
        ]);

        dd($response->json());
        
        $data = $response->json();


    }
}

