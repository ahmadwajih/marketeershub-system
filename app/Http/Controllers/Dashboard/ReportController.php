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
        $offers = Offer::with(['users' => function($q){
            $q->where('users.id', auth()->user()->id);
        },
        'coupons' => function($q){
            $q->where('coupons.user_id', auth()->user()->id)
            ->orWhereIn('coupons.user_id', );
        }
        ])->get();

        return view('dashboard.reports.index', ['offers' => $offers]);

    }
}
