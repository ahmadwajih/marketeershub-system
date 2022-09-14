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

class DashboardController extends Controller
{
    public function index()
    {

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

        $coupons = [
            'MH19',
            'RA',
            'HB18',
            'JOD',
            'Chic1',
            'yosha',
            'Sarah',
            'FOFA',
            'Habah',
            'De22',
            'LDY',
            'wafaa',
            'Fa10',
            'Fun80',
            'Zahrty',
            'Danh30',
            'Shaden',
            'Shosho',
            'Lyn',
            'ST1',
            'Saw',
            'Rahf',
            'Bea',
            'RRR',
            'S28',
            'MF9',
            'MH12',
            'MH13',
            'MH14',
            'MH15',
            'MH16',
            'MH18',
            'MH20',
            'MH21',
            'MH22',
            'MH23',
            'MH24',
            'MH25',
            'MH26',
            'MH27',
            'MH28',
            'MH29',
            'MH30',
            'MH33',
            'MH34',
            'MH35',
            'MH37',
            'MH38',
            'MH39',
            'MH42',
            'MH43',
            'MH68',
            'MH70',
            'MH73',
            'MH74',
            'MH76',
            'MH80',
            'MH81',
            'MH82',
            'MH86',
            'MH88',
            'MH91',
            'MH92',
            'MH93',
            'MH95',
            'MH98',
            'MH99',
            'MH100',
            'MH102',
            'MH104',
            'MH105',
            'MH106',
            'MH107',
            'MH108',
            'MH109',
            'MH113',
            'MH115',
            'MH116',
            'MH121',
            'MH122',
            'MH124',
            'MH135',
            'MH151',
            'MH152',
            'MH153',
            'MH156',
            'MH69',
            'AN',
            'M5',
            'M6',
            'M8',
            'M9',
            'M10',
            'M11',
            'M12',
            'M13',
            'M14',
            'M15',
            'M16',
            'M17',
            'M18',
            'M19',
            'M20',
            'M21',
            'M22',
            'M23',
            'M24',
            'M25',
            'M26',
            'M27',
            'M28',
            'M29',
            'M30',
            'M31',
            'M32',
            'M33',
            'M34',
            'M35',
            'M36',
            'M38',
            'M39',
            'M40',
            'M41',
            'M42',
            'M43',
            'M44',
            'M45',
            'M46',
            'M47',
            'M48',
            'M49',
            'M50',
            'MH131',
            'MH78',
            'm1'
        ];
        $cops1 = [
            'Coupon',
            'MH71',
            'MH11',
            'MH50',
            'MH160',
            'MH112',
            'MH67',
            'MH111',
            'MH72',
            'M64',
            'M68',
            'M72',
            'MH130',
        ];
        $cops = Coupon::where('offer_id', 26)->whereIn('coupon', $cops1)->pluck('coupon', 'user_id')->toArray();
        dd($cops);
        $cops = Coupon::where('offer_id', 26)->whereIn('coupon', $coupons)->where('user_id', 2)->pluck('coupon')->toArray();
        dd($cops);
        $dif = array_diff($coupons, $cops);
        dd([count($cops), count($coupons)]);


        $oldIds = [
            'inf-6002',
            'inf-1000',
            'inf-4438',
            'inf-6003',
            'inf-6008',
            'inf-0',
            'inf-1000',
            'inf-5982',
            'inf-1000',
            'inf-5492',
            'inf-5513',
            'inf-6140',
            'inf-5675',
            'inf-5505',
            'inf-6021',
            'inf-6023',
            'inf-3594',
            'inf-5888',
            'inf-6024',
            'inf-5549',
            'inf-0',
            'inf-1016',
            'inf-1036',
            'inf-1044',
            'inf-1045',
            'inf-1047',
            'inf-1048',
            'inf-1051',
            'inf-1052',
            'inf-1053',
            'inf-1071',
            'inf-1071',
            'inf-1071',
            'inf-1000',
            'inf-1075',
            'inf-1076',
            'inf-1080',
            'inf-1082',
            'inf-1095',
            'inf-5970',
            'inf-1108',
            'inf-1117',
            'inf-1121',
            'inf-5971',
            'inf-1124',
            'inf-1126',
            'inf-1129',
            'inf-4330',
            'inf-1164',
            'inf-1173',
            'inf-1177',
            'inf-1178',
            'inf-1180',
            'inf-1181',
            'inf-1184',
            'inf-1185',
            'inf-1195',
            'inf-1203',
            'inf-1205',
            'inf-1206',
            'inf-1212',
            'inf-1217',
            'inf-1221',
            'inf-1224',
            'inf-6082',
            'inf-6105',
            'inf-1249',
            'inf-1251',
            'inf-1260',
            'inf-1261',
            'inf-3880',
            'inf-1266',
            'inf-1267',
            'inf-1269',
            'inf-1275',
            'inf-1276',
            'inf-6136',
            'inf-1289',
            'inf-1296',
            'inf-1299',
            'inf-1300',
            'inf-1308',
            'inf-1314',
            'inf-1318',
            'inf-1321',
            'inf-1329',
            'inf-1331',
            'inf-1331',
            'inf-1334',
            'inf-1015',
            'inf-1347',
            'inf-1000',
            'inf-1362',
            'inf-1363',
            'inf-1368',
            'inf-1373',
            'inf-1380',
            'inf-1388',
            'inf-1389',
            'inf-6095',
            'inf-1400',
            'inf-1401',
            'inf-1405',
            'inf-1410',
            'inf-6109',
            'inf-1427',
            'inf-1428',
            'inf-1440',
            'inf-1443',
            'inf-1451',
            'inf-1453',
            'inf-1456',
            'inf-1463',
            'inf-6125',
            'inf-1467',
            'inf-1470',
            'inf-1477',
            'inf-1487',
            'inf-1508',
            'inf-1514',
            'inf-6094',
            'inf-6133',
            'inf-1533',
            'inf-1537',
            'inf-1545',
            'inf-1547',
            'inf-1549',
            'inf-1549',
            'inf-1554',
            'inf-1564',
            'inf-1288',
            'inf-5617',
            'inf-6135',
            'inf-1000',
            'inf-1601',
            'inf-5084',
            'inf-3739',
            'inf-1621',
            'inf-1624',
            'inf-0',
            'inf-0',
            'inf-1667',
            'inf-1719',
            'inf-1057',
            'inf-0',
            'inf-1787',
            'inf-1000',
            'inf-1000',
            'inf-1818',
            'inf-1823',
            'inf-1000',
            'inf-1839',
            'inf-1841',
            'inf-1850',
            'inf-1854',
            'inf-1855',
            'inf-1864',
            'inf-1881',
            'inf-1891',
            'inf-5764',
            'inf-1918',
            'inf-1942',
            'inf-1994',
            'inf-1994',
            'inf-1994',
            'inf-2000',
            'inf-2003',
            'inf-2028',
            'inf-2030',
            'inf-1071',
            'inf-2105',
            'inf-6013',
            'inf-2128',
            'inf-2130',
            'inf-2163',
            'inf-2190',
            'inf-2191',
            'inf-2208',
            'inf-6151',
            'inf-2221',
            'inf-2231',
            'inf-2244',
            'inf-2251',
            'inf-2270',
            'inf-0',
            'inf-2295',
            'inf-1000',
            'inf-0',
            'inf-2320',
            'inf-2326',
            'inf-2337',
            'inf-2342',
            'inf-2350',
            'inf-2357',
            'inf-2365',
            'inf-2374',
            'inf-5603',
            'inf-2036',
            'inf-2395',
            'inf-2398',
            'inf-2402',
            'inf-2407',
            'inf-2417',
            'inf-2424',
            'inf-2425',
            'inf-2430',
            'inf-5871',
            'inf-2445',
            'inf-2458',
            'inf-1000',
            'inf-2603',
            'inf-2485',
            'inf-2512',
            'inf-5622',
            'inf-2544',
            'inf-0',
            'inf-0',
            'inf-2566',
            'inf-5630',
            'inf-2581',
            'inf-2588',
            'inf-1000',
            'inf-2593',
            'inf-2608',
            'inf-2621',
            'inf-2621',
            'inf-2639',
            'inf-2643',
            'inf-6032',
            'inf-2660',
            'inf-2666',
            'inf-5915',
            'inf-2679',
            'inf-2683',
            'inf-2684',
            'inf-2690',
            'inf-2696',
            'inf-5678',
            'inf-2696',
            'inf-2702',
            'inf-2710',
            'inf-2711',
            'inf-2722',
            'inf-6122',
            'inf-4638',
            'inf-5652',
            'inf-2752',
            'inf-2755',
            'inf-5624',
            'inf-5813',
            'inf-2777',
            'inf-2796',
            'inf-2988',
            'inf-2813',
            'inf-6132',
            'inf-0',
            'inf-0',
            'inf-5629',
            'inf-2856',
            'inf-2870',
            'inf-2881',
            'inf-2900',
            'inf-2914',
            'inf-2915',
            'inf-2923',
            'inf-2924',
            'inf-5886',
            'inf-2956',
            'inf-2957',
            'inf-2969',
            'inf-1000',
            'inf-6151',
            'inf-2980',
            'inf-0',
            'inf-1000',
            'inf-2990',
            'inf-2993',
            'inf-2996',
            'inf-2999',
            'inf-5980',
            'inf-6092',
            'inf-3015',
            'inf-3016',
            'inf-3023',
            'inf-3025',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-5004',
            'inf-3085',
            'inf-5945',
            'inf-3109',
            'inf-3120',
            'inf-3121',
            'inf-3126',
            'inf-3128',
            'inf-0',
            'inf-3161',
            'inf-4456',
            'inf-0',
            'inf-0',
            'inf-3196',
            'inf-3204',
            'inf-3217',
            'inf-3222',
            'inf-1000',
            'inf-3231',
            'inf-0',
            'inf-3234',
            'inf-3238',
            'inf-3241',
            'inf-1701',
            'inf-5415',
            'inf-3260',
            'inf-1000',
            'inf-3280',
            'inf-1000',
            'inf-5634',
            'inf-3324',
            'inf-1000',
            'inf-5677',
            'inf-3329',
            'inf-3344',
            'inf-3344',
            'inf-3347',
            'inf-5965',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-3366',
            'inf-3368',
            'inf-5984',
            'inf-3379',
            'inf-5681',
            'inf-3393',
            'inf-3421',
            'inf-3427',
            'inf-1000',
            'inf-1000',
            'inf-3453',
            'inf-1000',
            'inf-0',
            'inf-3466',
            'inf-0',
            'inf-3606',
            'inf-1000',
            'inf-3484',
            'inf-3495',
            'inf-5573',
            'inf-0',
            'inf-1000',
            'inf-3510',
            'inf-3515',
            'inf-5851',
            'inf-5783',
            'inf-3539',
            'inf-3550',
            'inf-6007',
            'inf-3562',
            'inf-1000',
            'inf-3564',
            'inf-3565',
            'inf-3582',
            'inf-3585',
            'inf-3587',
            'inf-5698',
            'inf-3598',
            'inf-5793',
            'inf-3614',
            'inf-3628',
            'inf-5749',
            'inf-3652',
            'inf-1000',
            'inf-6123',
            'inf-3657',
            'inf-1000',
            'inf-3670',
            'inf-5532',
            'inf-3679',
            'inf-3679',
            'inf-6038',
            'inf-6041',
            'inf-6115',
            'inf-3685',
            'inf-6014',
            'inf-6001',
            'inf-3720',
            'inf-5951',
            'inf-5786',
            'inf-3733',
            'inf-3736',
            'inf-3742',
            'inf-3751',
            'inf-3767',
            'inf-3779',
            'inf-3780',
            'inf-3792',
            'inf-3803',
            'inf-3019',
            'inf-1000',
            'inf-6044',
            'inf-3824',
            'inf-3835',
            'inf-3855',
            'inf-0',
            'inf-0',
            'inf-1000',
            'inf-3867',
            'inf-0',
            'inf-0',
            'inf-3891',
            'inf-3897',
            'inf-3898',
            'inf-3901',
            'inf-3908',
            'inf-3917',
            'inf-3936',
            'inf-3939',
            'inf-3940',
            'inf-3940',
            'inf-3943',
            'inf-3949',
            'inf-3954',
            'inf-3964',
            'inf-3965',
            'inf-3971',
            'inf-3973',
            'inf-3974',
            'inf-3976',
            'inf-3981',
            'inf-3984',
            'inf-3985',
            'inf-4449',
            'inf-4005',
            'inf-1157',
            'inf-4008',
            'inf-1000',
            'inf-6042',
            'inf-4016',
            'inf-5771',
            'inf-1000',
            'inf-4022',
            'inf-0',
            'inf-1984',
            'inf-4038',
            'inf-6022',
            'inf-5702',
            'inf-6068',
            'inf-4081',
            'inf-4082',
            'inf-4088',
            'inf-4089',
            'inf-4099',
            'inf-4104',
            'inf-1000',
            'inf-4119',
            'inf-6062',
            'inf-4121',
            'inf-3134',
            'inf-4124',
            'inf-5993',
            'inf-1000',
            'inf-4130',
            'inf-4131',
            'inf-1000',
            'inf-4529',
            'inf-4139',
            'inf-4145',
            'inf-4149',
            'inf-4154',
            'inf-6131',
            'inf-4144',
            'inf-1000',
            'inf-6019',
            'inf-4170',
            'inf-5718',
            'inf-4191',
            'inf-1599',
            'inf-4209',
            'inf-0',
            'inf-6054',
            'inf-6035',
            'inf-4238',
            'inf-4239',
            'inf-4254',
            'inf-4263',
            'inf-4264',
            'inf-2042',
            'inf-4277',
            'inf-1000',
            'inf-4293',
            'inf-4302',
            'inf-4302',
            'inf-4303',
            'inf-4311',
            'inf-4311',
            'inf-4312',
            'inf-6020',
            'inf-1000',
            'inf-4328',
            'inf-5711',
            'inf-4329',
            'inf-4332',
            'inf-4333',
            'inf-4337',
            'inf-4337',
            'inf-4337',
            'inf-4337',
            'inf-6054',
            'inf-6083',
            'inf-4349',
            'inf-5773',
            'inf-5854',
            'inf-4362',
            'inf-5744',
            'inf-5745',
            'inf-5776',
            'inf-2923',
            'inf-5837',
            'inf-1000',
            'inf-0',
            'inf-4405',
            'inf-4411',
            'inf-4424',
            'inf-4427',
            'inf-4429',
            'inf-4430',
            'inf-4434',
            'inf-4437',
            'inf-0',
            'inf-4446',
            'inf-5841',
            'inf-5740',
            'inf-4459',
            'inf-1000',
            'inf-1000',
            'inf-4468',
            'inf-1000',
            'inf-1000',
            'inf-4480',
            'inf-4481',
            'inf-5729',
            'inf-4487',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-4494',
            'inf-0',
            'inf-6077',
            'inf-4507',
            'inf-4508',
            'inf-4510',
            'inf-4514',
            'inf-4521',
            'inf-4522',
            'inf-0',
            'inf-6031',
            'inf-0',
            'inf-4538',
            'inf-6079',
            'inf-4544',
            'inf-5913',
            'inf-4558',
            'inf-4560',
            'inf-4563',
            'inf-4564',
            'inf-1000',
            'inf-6064',
            'inf-4571',
            'inf-4572',
            'inf-4573',
            'inf-4576',
            'inf-1000',
            'inf-6069',
            'inf-1000',
            'inf-4583',
            'inf-0',
            'inf-4590',
            'inf-4590',
            'inf-4592',
            'inf-4597',
            'inf-4598',
            'inf-4641',
            'inf-4714',
            'inf-4714',
            'inf-0',
            'inf-4813',
            'inf-4826',
            'inf-4827',
            'inf-4829',
            'inf-0',
            'inf-4837',
            'inf-4839',
            'inf-0',
            'inf-4846',
            'inf-4855',
            'inf-3920',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-4866',
            'inf-1000',
            'inf-4876',
            'inf-4880',
            'inf-5975',
            'inf-4888',
            'inf-4890',
            'inf-4895',
            'inf-0',
            'inf-4910',
            'inf-0',
            'inf-0',
            'inf-4919',
            'inf-4927',
            'inf-4929',
            'inf-4929',
            'inf-4943',
            'inf-4946',
            'inf-4947',
            'inf-4969',
            'inf-5964',
            'inf-4977',
            'inf-4979',
            'inf-4980',
            'inf-5972',
            'inf-0',
            'inf-4990',
            'inf-4991',
            'inf-4995',
            'inf-5002',
            'inf-0',
            'inf-5010',
            'inf-5015',
            'inf-5018',
            'inf-0',
            'inf-0',
            'inf-5045',
            'inf-5047',
            'inf-5052',
            'inf-5056',
            'inf-5403',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-5974',
            'inf-0',
            'inf-6067',
            'inf-6016',
            'inf-5845',
            'inf-3149',
            'inf-5479',
            'inf-6026',
            'inf-5473',
            'inf-5558',
            'inf-4576',
            'inf-1253',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-5959',
            'inf-0',
            'inf-5485',
            'inf-5414',
            'inf-6063',
            'inf-5438',
            'inf-1000',
            'inf-5546',
            'inf-5555',
            'inf-5661',
            'inf-5936',
            'inf-0',
            'inf-0',
            'inf-5679',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-4038',
            'inf-1000',
            'inf-0',
            'inf-6089',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-0',
            'inf-5765',
            'inf-0',
            'inf-5646',
            'inf-5775',
            'inf-2639',
            'inf-2957',
            'inf-4209',
            'inf-2923',
            'inf-2710',
            'inf-5943',
            'inf-5860',
            'inf-5867',
            'inf-5892',
            'inf-5895',
            'inf-2650',
            'inf-1279',
            'inf-5870',
            'inf-5879',
            'inf-5880',
            'inf-5925',
            'inf-5887',
            'inf-6060',
            'inf-5730',
            'inf-1854',
            'inf-3587',
            'inf-3238',

        ];
        $ids = array_unique($oldIds);
        $affiliates = User::wherePosition('publisher')->whereTeam('influencer')->whereIn('ho_id', $ids)->pluck('ho_id')->toArray();
        $dif = array_diff($ids, $affiliates);

        dd([
            'ids' => count($ids),
            'diff' => $dif,
            'influencers' => count($affiliates),
        ]);
        dd($affiliates);









        $data = [];

        $reports = PivotReport::with('coupon')->get();
        foreach ($reports as $index => $report) {
            $data[$index]['name'] = $report->coupon->user->name;
            $data[$index]['team'] = $report->coupon->user->team;
            $data[$index]['id'] = $report->coupon->user->ho_id;
            $data[$index]['coupon'] = $report->coupon->coupon;
            $data[$index]['orders'] = $report->orders;
        }
        return view('admin.test', ['data' => $data]);

        dd($data);
        $inf  = DB::table('pivot_reports')
            ->select(
                DB::raw('pivot_reports.orders as orders'),
                'users.team as team',
                'users.name as name',
            )
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->orderBy('orders',  'DESC')
            ->having('orders', '>', 0)
            ->get();
        dd($inf);
        // abort(404);
        $affiliates = User::wherePosition('publisher')->whereTeam('affiliate')->count();
        $influencers = User::wherePosition('publisher')->whereTeam('influencer')->count();
        $organic = User::wherePosition('publisher')->whereTeam('media_buying')->count();

        $coupons = Coupon::count();
        $data = [
            'affiliates' => $affiliates,
            'influencers' => $influencers,
            'organic' => $organic,
            'total' => $organic  + $influencers + $affiliates,
            'coupons' => $coupons,
        ];
        dd($data);
        // $reports = PivotReport::all();
        // $coupons = Coupon::get();
        // $reports = PivotReport::all();
        // foreach($coupons as $coupon){
        //     echo "coupon id => " . $coupon->id;
        //     echo "<br>";
        //     $coupon->forceDelete();
        // }
        // foreach($reports as $report){
        //     echo "report id => " . $report->id;
        //     echo "<br>";
        //     $report->forceDelete();
        // }
        // $accountManagers = User::select(['id', 'name', 'team'])->wherePosition('account_manager')->get();
        // return view('new_admin.auth.login', ['accountManagers' => $accountManagers]);
        // return view('new_admin.index');
    }
}

