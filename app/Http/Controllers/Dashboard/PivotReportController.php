<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\PivotReportErrorsExport;
use App\Http\Controllers\Controller;
use App\Imports\PivotReportImport;
use App\Imports\V2\UpdateReportImport;
use App\Imports\ValidationPivotReportImport;
use App\Models\Offer;
use App\Models\PivotReport;
use App\Notifications\UpdateValidation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Notification;
use Yajra\DataTables\Facades\DataTables;

class PivotReportController extends Controller
{


    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return redirect()->back();
        $this->authorize('view_pivot_report');
        if ($request->ajax()) {
            $coupons = PivotReport::with(['offer', 'coupon']);
            return DataTables::of($coupons)->make(true);
        }
        return view('new_admin.pivot-report.index');
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
            'offers' => Offer::whereStatus("active")->orderBy('id', 'desc')->get(),
        ]);
    }

    public function edit()
    {
        abort(404);
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
        Excel::import(new UpdateReportImport($request->offer_id, $request->type), request()->file('report'));

        if ($request->type == 'validation') {
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

    public function downloadErrors()
    {
        if (session('columnHaveIssue')) {
            $errors = session('columnHaveIssue');
            session()->forget('columnHaveIssue');
            return Excel::download(new PivotReportErrorsExport($errors), 'errors.csv', \Maatwebsite\Excel\Excel::CSV);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, PivotReport $pivotReport)
    {
        $this->authorize('delete_cites');
        if ($request->ajax()) {
            userActivity('PivotReport', $pivotReport->id, 'delete');
            $pivotReport->delete();
        }
    }

    public function defineExcelSheetColumns(Request $request)
    {

        $request->validate([
            'offer_id' => 'required|numeric|exists:offers,id',
        ]);

        $offer = Offer::findOrFail($request->offer_id);
        $revenue = $offer->cps->where('type', 'revenue');
        $payout = $offer->cps->where('type', 'payout');
        $revenueHaveDateRange = $revenue->where('date_range', 1)->where('from_date', '!=', null)->where('to_date', '!=', null)->first();
        $revenueHaveCountries = $revenue->where('countries', 1)->where('countries_ids', '!=', null)->first();
        $payoutHaveDateRange = $payout->where('date_range', 1)->where('from_date', '!=', null)->where('to_date', '!=', null)->first();
        $payoutHaveCountries = $payout->where('countries', 1)->where('countries_ids', '!=', null)->first();
        $haveDateRange = $revenueHaveDateRange || $payoutHaveDateRange ? true : false;
        $haveCountryRange = $revenueHaveCountries || $payoutHaveCountries ? true : false;
        $cpsType = $offer->payout_cps_type;
       
        $link = asset('dashboard/excel-sheets-examples/update-report');
        $title = 'Download example';
        
        if(count($revenue) == 0 && count($payout) == 0 ){
            return response()->json(['data' =>false]);
        }

        if ($cpsType == 'static') {
            // If have date range and countries conditoin 
            if ($haveDateRange && $haveCountryRange) {
                $link .= '/static-with-date-range-and-countries-condition.xlsx';
                $title = 'Fixed amount with date range and countries condition';
            }
            // If have date range conditoin 
            if ($haveDateRange && !$haveCountryRange) {
                $link .= '/static-with-date-range-condition.xlsx';
                $title = 'Fixed amount with date range condition';
            }
            // If have countries conditoin 
            if (!$haveDateRange && $haveCountryRange) {
                $link .= '/static-with-countries-condition.xlsx';
                $title = 'Fixed amount with countries condition';
            }
            // If dosnot have date range and dosner countries conditoin 
            if (!$haveDateRange && !$haveCountryRange) {
                $link .= '/static-without-date-range-and-without-countries-condition.xlsx';
                $title = 'Fixed amount without date range and without countries condition';
            }
        }

        if ($cpsType == 'new_old') {
            // If have date range and countries conditoin 
            if ($haveDateRange && $haveCountryRange) {
                $link .= '/new-old-with-date-range-and-countries-condition.xlsx';
                $title = 'New-Old with date range and countries condition';
            }
            // If have date range conditoin 
            if ($haveDateRange && !$haveCountryRange) {
                $link .= '/new-old-with-date-range-condition.xlsx';
                $title = 'New-Old with date range condition';
            }
            // If have countries conditoin 
            if (!$haveDateRange && $haveCountryRange) {
                $link .= '/new-old-with-countries-condition.xlsx';
                $title = 'New-Old with countries condition';
            }
            // If dosnot have date range and dosner countries conditoin 
            if (!$haveDateRange && !$haveCountryRange) {
                $link .= '/new-old-without-date-range-and-without-countries-condition.xlsx';
                $title = 'New-Old without date range and without countries condition';
            }
        }

        if ($cpsType == 'slaps') {
            $link .= '/slabs.xlsx';
            $title = 'Slabs';
        }

        return response()->json(['link' => $link,'title' => $title]);
    }
}
