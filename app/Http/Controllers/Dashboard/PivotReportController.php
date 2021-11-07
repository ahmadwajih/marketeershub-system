<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\PivotReportImport;
use App\Models\Offer;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PivotReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return redirect()->back();
        $this->authorize('view_pivot_report');
        if($request->ajax()){
            $coupons = getModelData('Coupon', $request, ['offer', 'user']);
            return response()->json($coupons);
        }
        return view('admin.pivot-report.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_pivot_report');
        return view('admin.pivot-report.create', [
            'offers' => Offer::whereStatus("active")->get(),
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_pivot_report');
        $request->validate([
            'offer_id' => 'required|numeric|exists:offers,id',
            'report' => 'required|mimes:xlsx,csv',
        ]);
        if($request->type=='normal'){
            Excel::import(new PivotReportImport($request->offer_id),request()->file('report'));
        }else{

        }
        userActivity('PivotReport', null, 'upload');

        $notification = [
            'message' => 'Uploaded successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.pivot-report.index');
    }


}