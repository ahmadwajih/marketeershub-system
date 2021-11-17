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
        $offers = Offer::all();
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


    public function test(){        

        // foreach(auth()->user()->notifications->take(10) as $notification){
        //     dd($notification);
        // }



        // dd(auth()->user()->notifications);
        // dd(env('DB_DATABASE'));
        $publishers = User::wherePosition('publisher')->limit(10)->get();
        $offer = Offer::first();
        Notification::send($publishers, new NewOffer($offer));
            dd($publishers);
        // $publishers = 
        // dd($publishers);
    }

}
