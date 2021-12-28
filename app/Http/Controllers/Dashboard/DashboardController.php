<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Offer;
use App\Models\PivotReport;
use App\Models\PublisherCategory;
use App\Models\User;
use App\Notifications\NewOffer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){ 
        
        $this->authorize('view_dashboard');

        // Get all offers that have coupons and report
        $offers = Offer::whereHas('coupons', function($q)  {
            $q->whereHas('report');
        })->get();

        // Get total numbers for all teams
        $totalNumbers = DB::table('pivot_reports')
        ->select(DB::raw('IFNULL(orders, 0) as orders'), DB::raw('IFNULL(sales, 0) as sales'), DB::raw('IFNULL(revenue, 0) as revenue'), DB::raw('IFNULL(payout, 0) as payout'))
        ->orderBy('pivot_reports.date', 'desc')
        ->first();

       // Get totla numbers for seperate Team
       
        return view('admin.index', [
            'offers' => $offers,
            'totalNumbers' => $totalNumbers, 
            'totalInfluencerNumbers' => totalNumbersForSeparateTeam('influencer'),
            'totalAffiliateNumbers' => totalNumbersForSeparateTeam('affiliate'),
            'totalMediaBuyingNumbers' => totalNumbersForSeparateTeam('media_buying'),
        ]);

        return view('admin.index');
    }


    public function changeLang($lang){      
        session(['lang' => $lang]);
        return redirect()->back();
    }


    public function test(){
        // $report = PivotReport::get()[0];
        // $report->forceDelete();
        dd(PivotReport::get()[0]);
    }
}
