<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\PivotReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view_reports');
        $userId  = auth()->user()->id;
        $childrens = auth()->user()->childrens()->pluck('id')->toArray();
        array_push($childrens, $userId);

        $offers = Offer::whereHas('users', function($q) use($childrens) {
            $q->whereIn('user_id', $childrens);
        })->with(['users' => function($q) use($childrens){
            $q->whereIn('users.id', $childrens);
        },
        'coupons' => function($q) use($childrens){
            $q->whereIn('coupons.user_id', $childrens);
        }])->get();
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


        return view('admin.reports.index', [
            'offers' => $offers,
            'pendingTotalOrders' => $pendingTotalOrders,
            'pendingTotalSales' => $pendingTotalSales,
            'pendingTotalPayout' => $pendingTotalPayout,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'totalPayout' => $totalPayout,
        ]);

    }
}
