<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\User;
use App\Notifications\NewOffer;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\App;


class DashboardController extends Controller
{
    public function index(){ 
        
        $this->authorize('view_dashboard');
        $offers = Offer::all();
        $affiliates = User::whereTeam('affiliate')->get();
        $influencers = User::whereTeam('influencer')->get();
        $media_buying = User::whereTeam('media_buying')->get();
    
        

        
        $pendingTotalOrders = 0;
        $pendingTotalSales = 0;
        $pendingTotalPayout = 0;
        $totalOrders = 0;
        $totalSales = 0;
        $totalPayout = 0;
        foreach($offers as $offer){
            foreach($offer->coupons as $coupon){
                if($coupon->report){
                    $pendingTotalOrders += $coupon->report->orders;
                    $pendingTotalSales += $coupon->report->sales;
                    $pendingTotalPayout += $coupon->report->payout;
                    $totalOrders += $coupon->report->v_orders;
                    $totalSales += $coupon->report->v_sales;
                    $totalPayout += $coupon->report->v_payout;
                }
            }
        }
        return view('admin.index', [
            'offers' => $offers,
            'pendingTotalOrders' => $pendingTotalOrders,
            'pendingTotalSales' => $pendingTotalSales,
            'pendingTotalPayout' => $pendingTotalPayout,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'totalPayout' => $totalPayout,
        ]);

        return view('admin.index');
    }


    public function changeLang($lang){      
        session(['lang' => $lang]);
        return redirect()->back();
    }


    public function test():array{
        

        dd(testFunction(var2:10, var1:20));
    }

}
