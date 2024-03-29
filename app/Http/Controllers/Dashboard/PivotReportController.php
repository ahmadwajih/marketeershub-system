<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\PivotReportErrorsExport;
use App\Http\Controllers\Controller;
use App\Imports\v2\UpdateReportImport;
use App\Models\Offer;
use App\Models\PivotReport;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PivotReportController extends Controller
{
    public string $module_name = "pivot_report";

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view_pivot_report');

        $query = PivotReport::query();

        $tableLength = session('table_length') ?? config('app.pagination_pages');
        // Filter
        if (isset($request->offer_id) && $request->offer_id  != null) {
            $query->where('offer_id', $request->offer_id);
            session()->put('pivot_report_filter_offer_id', $request->offer_id);
        } elseif (session('pivot_report_filter_offer_id')) {
            $query->where('offer_id', session('pivot_report_filter_offer_id'));
        }

        if (isset($request->user_id) && $request->user_id  != null || session('pivot_report_filter_user_id')) {
            $query->where('user_id', $request->user_id);
            session()->put('pivot_report_filter_user_id', $request->user_id);
        } elseif (session('pivot_report_filter_user_id')) {
            $query->where('user_id', session('pivot_report_filter_user_id'));
        }

        if (isset($request->search) && $request->search  != null) {
            $query->whereHas('coupon', function ($couponQuery) use ($request) {
                return  $couponQuery->where('coupon', $request->search);
            });
            $query->orWhereHas('offer', function ($couponQuery) use ($request) {
                return $couponQuery
                    ->where('name_en', 'like', "%$request->search%")
                    ->orWhere('name_ar', 'like', "%$request->search%");
            });
        }
        $publisherForFilter = User::whereId(session('pivot_report_filter_user_id'))->first();
        $reports = $query->with(['offer', 'user'])->orderBy('id', 'desc')->paginate($tableLength);
        $offers = Offer::orderBy('id', 'desc')->get();

        if (Storage::has($this->module_name . '_failed_rows.json')) {
            $publishers_failed_rows = json_decode(Storage::get($this->module_name . '_failed_rows.json'), true);
            session(['columnHaveIssue' => $publishers_failed_rows]);
        }

        //todo remove duplicated code
        $import_file = "";
        if (Storage::has($this->module_name . '_importing_counts.json')) {
            $import_file = Storage::get($this->module_name . '_importing_counts.json');
        }
        $fileUrl = null;
        $directory = "public/missing/$this->module_name";
        $files = Storage::allFiles($directory);
        if ($files) {
            $fileUrl = route('admin.reports.deonload.errore');
        }
        return view('new_admin.pivot-report.index', [
            'reports' => $reports,
            'offers' => $offers,
            'publisherForFilter' => $publisherForFilter,
            'import_file' => json_decode($import_file),
            'fileUrl' => $fileUrl,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
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
     * @param \App\Http\Requests\Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create_pivot_report');
        $request->validate([
            'offer_id' => 'required|numeric|exists:offers,id',
            'type' => 'required|in:update,validation',
            'report' => 'required|mimes:xlsx,csv',
        ]);
        $files = Storage::allFiles("public/missing/$this->module_name");
        Storage::delete($files);
        Storage::delete($this->module_name . '_importing_counts.json');
        Storage::delete($this->module_name . '_failed_rows.json');
        Storage::delete($this->module_name . '_duplicated_rows.json');
        Storage::delete($this->module_name . '_issues_rows.json');

        Storage::put('pivot_report_import.txt', $request->file('report')->store('files'));
        $id = now()->unix();
        session(['import' => $id]);
        $data = [
            "id" => $id,
        ];
        Storage::put('import.json', json_encode($data));
        $import_file = Storage::get("pivot_report_import.txt");
        Excel::queueImport(
            new UpdateReportImport($request->offer_id, $request->type, $id),
            $import_file
        );
        return redirect()->route('admin.reports.index', ['uploading' => 'true']);
    }
    /**
     * @throws Exception
     */
    public function status()
    {
        $id = 0;
        if (Storage::has('import.json')) {
            $import_file = Storage::get("import.json");
            $import_file = json_decode($import_file, true);
            $id = $import_file['id'];
        }
        return response([
            'started' => filled(cache("start_date_$id")),
            'finished' => filled(cache("end_date_$id")),
            'current_row' => (int) cache("current_row_$id"),
            'total_rows' => (int) cache("total_rows_$id"),
        ]);
    }
    public function downloadErrors($dir)
    {
        ob_end_clean();
        $path = storage_path("app/public/missing/$this->module_name/$dir");
        $filesInFolder = file_exists($path) ? \File::files($path) : [];
        $count = count($filesInFolder);
        if (file_exists($path) and $count) {
            $array = pathinfo($filesInFolder[$count - 1]);
            return response()->download($path . "/" . $array['basename']);
        }
        return "not found";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param int $id
     * @return void
     * @throws AuthorizationException
     */
    public function destroy(Request $request, int $id)
    {
        $this->authorize('delete_cites');
        if ($request->ajax()) {
            $pivotReport = PivotReport::findOrFail($id);
            userActivity('PivotReport', $pivotReport->id, 'delete');
            $pivotReport->forceDelete();
        }
    }
    public function defineExcelSheetColumns(Request $request): \Illuminate\Http\JsonResponse
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

        if (count($revenue) == 0 && count($payout) == 0) {
            return response()->json(['data' => false]);
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
            // If it does not have date range and dosner countries conditoin
            if (!$haveDateRange && !$haveCountryRange) {
                $link .= '/static-without-date-range-and-without-countries-condition.xlsx';
                $title = 'Fixed amount without date range and without countries condition';
            }
        }

        if ($cpsType == 'new_old') {
            // If have date range and countries conditoin
            if ($haveDateRange && $haveCountryRange) {
                if (in_array('flat', $revenue->pluck('amount_type')->toArray())) {
                    $link .= '/new-old-with-date-range-and-countries-condition-per-order.xlsx';
                    $title = 'New-Old with date range and countries condition per order';
                } else {
                    $link .= '/new-old-with-date-range-and-countries-condition-percentage.xlsx';
                    $title = 'New-Old with date range and countries condition percentage';
                }
            }
            // If have date range conditoin
            if ($haveDateRange && !$haveCountryRange) {
                if (in_array('flat', $revenue->pluck('amount_type')->toArray())) {
                    $link .= '/new-old-with-date-range-condition-per-order.xlsx';
                    $title = 'New-Old with date range condition per order';
                } else {
                    $link .= '/new-old-with-date-range-condition-percentage.xlsx';
                    $title = 'New-Old with date range condition percentage';
                }
            }
            // If have countries conditoin
            if (!$haveDateRange && $haveCountryRange) {
                if (in_array('flat', $revenue->pluck('amount_type')->toArray())) {
                    $link .= '/new-old-with-countries-condition-per-order.xlsx';
                    $title = 'New-Old with countries condition per order';
                } else {
                    $link .= '/new-old-with-countries-condition-percentage.xlsx';
                    $title = 'New-Old with countries condition percentage';
                }
            }
            // If dosnot have date range and dosner countries conditoin
            if (!$haveDateRange && !$haveCountryRange) {
                if (in_array('flat', $revenue->pluck('amount_type')->toArray())) {
                    $link .= '/new-old-without-date-range-and-without-countries-condition-per-order.xlsx';
                    $title = 'New-Old without date range and without countries condition per order';
                } else {
                    $link .= '/new-old-without-date-range-and-without-countries-condition-percentage.xlsx';
                    $title = 'New-Old without date range and without countries condition percentage';
                }
            }
        }

        if ($cpsType == 'slaps') {
            $link .= '/slabs.xlsx';
            $title = 'Slabs';
        }
        return response()->json(['link' => $link, 'title' => $title]);
    }

    /**
     * @return RedirectResponse
     */
    public function clearFilterSeassoions(): RedirectResponse
    {
        session()->forget('pivot_report_filter_offer_id');
        session()->forget('pivot_report_filter_user_id');
        session()->forget('pivot_report_filter_status');
        return redirect()->route('admin.reports.index');
    }
}
