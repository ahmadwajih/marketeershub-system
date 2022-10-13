<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\PivotReportErrorsExport;
use App\Http\Controllers\Controller;
use App\Imports\PivotReportImport;
use App\Imports\V2\UpdateReportImport;
use App\Imports\ValidationPivotReportImport;
use App\Models\Offer;
use App\Notifications\UpdateValidation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Notification;

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
        return view('new_admin.pivot-report.create', [
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
            'type' => 'required|in:update,validation',
            'report' => 'required|mimes:xlsx,csv',
        ]);
        Excel::import(new UpdateReportImport($request->offer_id, $request->type, $request->date),request()->file('report'));

        if($request->type=='validation'){
            $offer = Offer::findOrFail($request->offer_id);
            // Notification::send($offer->users, new UpdateValidation($offer));
        }
        userActivity('PivotReport', null, 'upload');

        $notification = [
            'message' => 'Uploaded successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }

    public function downloadErrors(){
        if(session('columnHaveIssue')){
            $errors = session('columnHaveIssue');
            session()->forget('columnHaveIssue');
            return Excel::download(new PivotReportErrorsExport($errors), 'errors.csv',\Maatwebsite\Excel\Excel::CSV );

        }
        return redirect()->back();
        
    }

}