<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\CouponImport;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\CouponCps;
use App\Models\Offer;
use App\Models\User;
use App\Notifications\CodeRecycled;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CouponController extends Controller
{
    public string $module_name = 'coupons';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view_coupons');
        if(isset($request->success) && $request->success == 'true'){
            //todo fix typo
            $couponsCountBeforUploading = session('coupons_count_before_uploading');
            $couponsCount = Coupon::count();
            $totalUploadedCoupons = $couponsCount - $couponsCountBeforUploading;
            $notification = [
                'message' => $totalUploadedCoupons . ' Coupon Uploaded Successfully.',
                'alert-type' => 'success',
                'uploading' =>true
            ];
            return redirect()->route('admin.coupons.index')->with($notification);
        }

        // Get Coupons
        $query = Coupon::query();

         $tableLength = session('table_length') ?? config('app.pagination_pages');

        // Filter
        if (isset($request->offer_id) && $request->offer_id  != null) {
            $query->where('offer_id', $request->offer_id);
            session()->put('coupons_filter_offer_id', $request->offer_id);
        } elseif (session('coupons_filter_offer_id')) {
            $query->where('offer_id', session('coupons_filter_offer_id'));
        }

        if (isset($request->user_id) && $request->user_id  != null || session('coupons_filter_user_id')) {
            $query->where('user_id', $request->user_id);
            session()->put('coupons_filter_user_id', $request->user_id);
        } elseif (session('coupons_filter_user_id')) {
            $query->where('user_id', session('coupons_filter_user_id'));
        }

        if (isset($request->status) && $request->status  != null) {
            $query->where('status', $request->status);
            session()->put('coupons_filter_status', $request->status);
        } elseif (session('coupons_filter_status')) {
            $query->where('status', session('coupons_filter_status'));
        }

        if (isset($request->search) && $request->search  != null) {
            $query->where('coupon', $request->search);
        }
        $publisherForFilter = User::whereId(session('coupons_filter_user_id'))->first();

        $coupons = $query->with(['offer', 'user'])->orderBy('id', 'desc')->paginate($tableLength);
        $countries = Country::all();
        $offers = Offer::orderBy('id', 'desc')->get();
        $import_file="";
        $fileUrl = $this->bulk_import_result($import_file);
        return view('new_admin.coupons.index', [
            'countries' => $countries,
            'coupons' => $coupons,
            'offers' => $offers,
            'publisherForFilter' => $publisherForFilter,
            'import_file'=>json_decode($import_file),
            'fileUrl' => $fileUrl,
        ]);
    }
    public function download($dir): BinaryFileResponse|string
    {
        ob_end_clean();
        $path = storage_path("app/public/missing/$this->module_name/$dir/");
        $filesInFolder = file_exists($path)?\File::files($path):[];
        $count = count($filesInFolder);
        if (file_exists($path) and $count) {
            $array = pathinfo($filesInFolder[$count - 1]);
            return response()->download($path . "/" . $array['basename']);
        }
        return "not found";
    }

    //todo fix func. name typo
    public function clearFilterSeassoions(): RedirectResponse
    {
        session()->forget('coupons_filter_offer_id');
        session()->forget('coupons_filter_user_id');
        session()->forget('coupons_filter_status');
        return redirect()->route('admin.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $this->authorize('create_coupons');

        return view('new_admin.coupons.create', [
            'offers' => Offer::whereStatus("active")->get(),
            'users' => User::whereStatus("active")->whereIn('position', ['publisher'])->whereIn('team', ['media_buying', 'influencer', 'affiliate', 'prepaid'])->latest()->get(),
            'countries' => Country::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_coupons');
        $request->validate([
            'coupon'          => 'required|max:255',
            'offer_id'        => 'required|numeric|exists:offers,id',
            'user_id'        => 'nullable|numeric|exists:users,id',
        ]);


        if ($request->have_custom_payout == 'on') {
            $request->validate([
                // Payout Validation
                'payout_cps_type' => 'required_if:have_custom_payout,on|in:static,new_old,slaps',
                'static_payout_type' => 'required_if:payout_cps_type,static|in:flat,percentage',
                'new_old_payout_type' => 'required_if:payout_cps_type,new_old|in:flat,percentage',
                'static_payout' => 'required_if:payout_cps_type,static|array',
                'static_payout.*.payout' => 'required_if:payout_cps_type,static',

                'new_old_payout' => 'required_if:payout_cps_type,new_old|array',
                'new_old_payout.*.new_payout' => 'required_if:payout_cps_type,new_old',
                'new_old_payout.*.old_payout' => 'required_if:payout_cps_type,new_old',

                'payout_slaps' => 'required_if:payout_cps_type,slaps|array',
                'payout_slaps.*.from' => 'required_if:payout_cps_type,slaps',
                'payout_slaps.*.to' => 'required_if:payout_cps_type,slaps',
                'payout_slaps.*.payout' => 'required_if:payout_cps_type,slaps'

            ]);

            if (!$this->offerPayoutDateValidation($request)) {
                return redirect()->back()->withErrors(['Error' => 'To date can not be after from date.'])->withInput($request->all());
            }
        }
        $data['coupon'] = strtolower(trim(str_replace(' ', '', trim($request->coupon))));
        $data['have_custom_payout'] = isset($request->have_custom_payout) && $request->have_custom_payout == 'on' ? true : false;
        $data['payout_cps_type'] = isset($request->payout_cps_type) ? $request->payout_cps_type : '';
        $data['payout_type'] = isset($request->payout_type) ? $request->payout_type : '';
        $data['offer_id'] = $request->offer_id;
        $data['user_id'] = $request->user_id;
        $coupon = Coupon::create($data);
        // dd($coupon->user);/
        //  if($request->user_id){
        //     try {
        //         Notification::send($coupon->user, new CodeRecycled($coupon));
        //     } catch (\Throwable $th) {
        //         Log::debug($th);
        //     }

        // }
        if ($request->have_custom_payout == 'on') {
            // If payout_cps_type is static
            if ($request->payout_cps_type == 'static') {
                if ($request->static_payout && count($request->static_payout) > 0) {
                    foreach ($request->static_payout as $staticPayout) {
                        CouponCps::create([
                            'type' => 'payout',
                            'cps_type' => 'static',
                            'amount_type' => $request->static_payout_type,
                            'amount' => $staticPayout['payout'],
                            'date_range' => isset($staticPayout['date_range']) && $staticPayout['date_range'][0] == 'on' ? true : false,
                            'from_date' => $staticPayout['from_date'] ?? null,
                            'to_date' => $staticPayout['to_date'] ?? null,
                            'countries' => isset($staticPayout['countries']) && $staticPayout['countries'][0] == 'on' ? true : false,
                            'countries_ids' => isset($staticPayout['countries_ids']) ? json_encode($staticPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                            'coupon_id' => $coupon->id,
                        ]);
                    }
                }
            }

            // If payout_cps_type is new_old
            if ($request->payout_cps_type == 'new_old') {
                if ($request->new_old_payout && count($request->new_old_payout) > 0) {
                    foreach ($request->new_old_payout as $newOldPayout) {
                        CouponCps::create([
                            'type' => 'payout',
                            'cps_type' => 'new_old',
                            'amount_type' => $request->new_old_payout_type,
                            'new_amount' => $newOldPayout['new_payout'],
                            'old_amount' => $newOldPayout['old_payout'],
                            'date_range' => isset($newOldPayout['date_range']) && $newOldPayout['date_range'][0] == 'on' ? true : false,
                            'from_date' => $newOldPayout['from_date'] ?? null,
                            'to_date' => $newOldPayout['to_date'] ?? null,
                            'countries' => isset($newOldPayout['countries']) && $newOldPayout['countries'][0] == 'on' ? true : false,
                            'countries_ids' => isset($newOldPayout['countries_ids']) ? json_encode($newOldPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                            'coupon_id' => $coupon->id,
                        ]);
                    }
                }
            }

            // If payout_cps_type is slaps
            if ($request->payout_cps_type == 'slaps') {
                if ($request->payout_slaps && count($request->payout_slaps) > 0) {
                    foreach ($request->payout_slaps as $slapsPayout) {
                        CouponCps::create([
                            'type' => 'payout',
                            'cps_type' => 'slaps',
                            'amount_type' => 'flat',
                            'amount' => $slapsPayout['payout'],
                            'from' => $slapsPayout['from'] ?? null,
                            'to' => $slapsPayout['to'] ?? null,
                            'coupon_id' => $coupon->id,
                        ]);
                    }
                }
            }
        }
        userActivity('Coupon', $coupon->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.coupons.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $this->authorize('view_coupons');
        $coupon = Coupon::findOrFail($id);
        userActivity('Coupon', $coupon->id, 'show');
        return view('new_admin.coupons.show', ['coupon' => $coupon]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Coupon $coupon)
    {
        $this->authorize('update_coupons');

        return view('new_admin.coupons.edit', [
            'coupon' => $coupon,
            'offers' => Offer::whereStatus("active")->get(),
            'countries' => Country::all(),
            'users' => User::whereStatus("active")->whereIn('position', ['publisher'])->whereIn('team', ['media_buying', 'influencer', 'affiliate', 'prepaid'])->latest()->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->authorize('update_coupons');
        $request->validate([
            'coupon'          => 'required|max:255',
            'offer_id'        => 'required|numeric|exists:offers,id',
            'user_id'        => 'nullable|numeric|exists:users,id',

            // Payout Validation
            // 'payout_cps_type' => 'required_if:have_custom_payout,on|in:static,new_old,slaps',
            // 'static_payout_type' => 'required_if:payout_cps_type,static|in:flat,percentage',
            // 'new_old_payout_type' => 'required_if:payout_cps_type,new_old|in:flat,percentage',
            // 'static_payout' => 'required_if:payout_cps_type,static|array',
            // 'static_payout.*.payout' => 'required_if:payout_cps_type,static',

            // 'new_old_payout' => 'required_if:payout_cps_type,new_old|array',
            // 'new_old_payout.*.new_payout' => 'required_if:payout_cps_type,new_old',
            // 'new_old_payout.*.old_payout' => 'required_if:payout_cps_type,new_old',

            // 'payout_slaps' => 'required_if:payout_cps_type,slaps|array',
            // 'payout_slaps.*.from' => 'required_if:payout_cps_type,slaps',
            // 'payout_slaps.*.to' => 'required_if:payout_cps_type,slaps',
            // 'payout_slaps.*.payout' => 'required_if:payout_cps_type,slaps',
        ]);

        if (!$this->offerPayoutDateValidation($request)) {
            return redirect()->back()->withErrors(['Error' => 'To date can not be after from date.'])->withInput($request->all());
        }
        $data['coupon'] = strtolower(trim(str_replace(' ', '', trim($request->coupon))));
        $data['have_custom_payout'] = isset($request->have_custom_payout) && $request->have_custom_payout == 'on' ? true : false;
        $data['payout_cps_type'] = isset($request->payout_cps_type) ? $request->payout_cps_type : '';
        $data['payout_type'] = isset($request->payout_type) ? $request->payout_type : '';
        $data['offer_id'] = $request->offer_id;
        $data['user_id'] = $request->user_id;
        $coupon->update($data);
        userActivity('Coupon', $coupon->id, 'update');
        // if ($request->user_id) {
        //     try {
        //         Notification::send($coupon->user, new CodeRecycled($coupon));
        //     } catch (\Throwable $th) {
        //         Log::debug($th);
        //     }
        // }
        $coupon->cps()->forceDelete();

        if ($request->have_custom_payout == 'on') {
            // If payout_cps_type is static
            if ($request->payout_cps_type == 'static') {
                if ($request->static_payout && count($request->static_payout) > 0) {
                    foreach ($request->static_payout as $staticPayout) {
                        CouponCps::create([
                            'type' => 'payout',
                            'cps_type' => 'static',
                            'amount_type' => $request->static_payout_type,
                            'amount' => $staticPayout['payout'],
                            'date_range' => isset($staticPayout['date_range']) && $staticPayout['date_range'][0] == 'on' ? true : false,
                            'from_date' => $staticPayout['from_date'] ?? null,
                            'to_date' => $staticPayout['to_date'] ?? null,
                            'countries' => isset($staticPayout['countries']) && $staticPayout['countries'][0] == 'on' ? true : false,
                            'countries_ids' => isset($staticPayout['countries_ids']) ? json_encode($staticPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                            'coupon_id' => $coupon->id,
                        ]);
                    }
                }
            }

            // If payout_cps_type is new_old
            if ($request->payout_cps_type == 'new_old') {
                if ($request->new_old_payout && count($request->new_old_payout) > 0) {
                    foreach ($request->new_old_payout as $newOldPayout) {
                        CouponCps::create([
                            'type' => 'payout',
                            'cps_type' => 'new_old',
                            'amount_type' => $request->new_old_payout_type,
                            'new_amount' => $newOldPayout['new_payout'],
                            'old_amount' => $newOldPayout['old_payout'],
                            'date_range' => isset($newOldPayout['date_range']) && $newOldPayout['date_range'][0] == 'on' ? true : false,
                            'from_date' => $newOldPayout['from_date'] ?? null,
                            'to_date' => $newOldPayout['to_date'] ?? null,
                            'countries' => isset($newOldPayout['countries']) && $newOldPayout['countries'][0] == 'on' ? true : false,
                            'countries_ids' => isset($newOldPayout['countries_ids']) ? json_encode($newOldPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                            'coupon_id' => $coupon->id,
                        ]);
                    }
                }
            }

            // If payout_cps_type is slaps
            if ($request->payout_cps_type == 'slaps') {
                if ($request->payout_slaps && count($request->payout_slaps) > 0) {
                    foreach ($request->payout_slaps as $slapsPayout) {
                        CouponCps::create([
                            'type' => 'payout',
                            'cps_type' => 'slaps',
                            'amount_type' => 'flat',
                            'amount' => $slapsPayout['payout'],
                            'from' => $slapsPayout['from'] ?? null,
                            'to' => $slapsPayout['to'] ?? null,
                            'coupon_id' => $coupon->id,
                        ]);
                    }
                }
            }
        }

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.coupons.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Coupon $coupon
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(Request $request, Coupon $coupon): JsonResponse
    {
        $this->authorize('delete_coupons');
        if ($request->ajax()) {
            if ($coupon->report && $coupon->report->count() > 0) {
                return response()->json(['message' => __('You cannot delete this coupon because it have transactions.')], 422);
            }
            userActivity('Coupon', $coupon->id, 'delete');
            $coupon->forceDelete();
        }
        return response()->json(['message' => __('Success.')]);
    }
    /**
     * Show the form for uploading a new resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function uploadForm(): View|Factory|Application
    {
        $this->authorize('create_coupons');
        return view('new_admin.coupons.upload', [
            'offers' => Offer::whereStatus("active")->orderBy('id', 'desc')->get()
        ]);
    }
    /**
     * Show the form for uploading a new resource.
     *
     * @param \App\Http\Requests\Request $request
     * @return Application|ResponseFactory|Response
     * @throws AuthorizationException
     */
    public function upload(\App\Http\Requests\Request $request)
    {
        $this->authorize('create_coupons');
        $request->validate([
            'offer_id'   => 'required|exists:offers,id',
            'coupons'    => 'required|mimes:xlsx,csv',
        ]);

        $files = Storage::allFiles("public/missing/$this->module_name");
        Storage::delete($files);
        Storage::delete($this->module_name.'_importing_counts.json');
        Storage::delete($this->module_name.'_failed_rows.json');
        Storage::delete($this->module_name.'_duplicated_rows.json');

        session(['coupons_count_before_uploading' => Coupon::count()]);
        $id = now()->unix();
        $data = ["id" => $id];
        Storage::put($this->module_name.'_import_data.json', json_encode($data));
        $offer_id = $request->offer_id;
        Excel::queueImport(new CouponImport($offer_id,$id), $request->file('coupons')->store('files'));
        userActivity('Coupon', null, 'upload');
        return redirect()->route('admin.coupons.index', ['uploading'=> 'true']);
    }
    /**
     * @throws Exception
     * @noinspection PhpUndefinedMethodInspection
     */
    public function importStatus(): Response|Application|ResponseFactory
    {
        $id = 0;
        if (Storage::has('coupons_import_data.json')){
            $import_file = Storage::get("coupons_import_data.json");
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
    /**
     * @throws AuthorizationException
     */
    public function changeStatus(Request $request): JsonResponse
    {
        $this->authorize('update_coupons');
        $coupon = Coupon::findOrFail($request->id);
        $coupon->status = $request->status == 'active' ? 'active' : 'inactive';
        $coupon->save();
        return response()->json(['message' => 'Updated Succefuly']);
    }
    public function bulckEdit(Request $request)
    {
        return view('new_admin.coupons.bulck-edit-form');
    }

    public function bulckUpdate(Request $request)
    {
        if (!$this->offerPayoutDateValidation($request)) {
            return redirect()->back()->withErrors(['Error' => 'To date can not be after from date.'])->withInput($request->all());
        }
        if (count($request->item_check) > 0) {
            foreach ($request->item_check as $couponId) {
                $coupon = Coupon::findOrFail($couponId);
                if ($request->user_id) {
                    $coupon->user_id = $request->user_id;
                    $coupon->save();
                }
                // dd($request->all());
                $coupon->cps()->forceDelete();

                // If payout_cps_type is static
                if ($request->have_custom_payout == 'on') {
                    // If payout_cps_type is static
                    if ($request->payout_cps_type == 'static') {
                        if ($request->static_payout && count($request->static_payout) > 0) {
                            foreach ($request->static_payout as $staticPayout) {
                                CouponCps::create([
                                    'type' => 'payout',
                                    'cps_type' => 'static',
                                    'amount_type' => $request->static_payout_type,
                                    'amount' => $staticPayout['payout'],
                                    'date_range' => isset($staticPayout['date_range']) && $staticPayout['date_range'][0] == 'on' ? true : false,
                                    'from_date' => $staticPayout['from_date'] ?? null,
                                    'to_date' => $staticPayout['to_date'] ?? null,
                                    'countries' => isset($staticPayout['countries']) && $staticPayout['countries'][0] == 'on' ? true : false,
                                    'countries_ids' => isset($staticPayout['countries_ids']) ? json_encode($staticPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                                    'coupon_id' => $coupon->id,
                                ]);
                            }
                        }
                    }

                    // If payout_cps_type is new_old
                    if ($request->payout_cps_type == 'new_old') {
                        if ($request->new_old_payout && count($request->new_old_payout) > 0) {
                            foreach ($request->new_old_payout as $newOldPayout) {
                                CouponCps::create([
                                    'type' => 'payout',
                                    'cps_type' => 'new_old',
                                    'amount_type' => $request->new_old_payout_type,
                                    'new_amount' => $newOldPayout['new_payout'],
                                    'old_amount' => $newOldPayout['old_payout'],
                                    'date_range' => isset($newOldPayout['date_range']) && $newOldPayout['date_range'][0] == 'on' ? true : false,
                                    'from_date' => $newOldPayout['from_date'] ?? null,
                                    'to_date' => $newOldPayout['to_date'] ?? null,
                                    'countries' => isset($newOldPayout['countries']) && $newOldPayout['countries'][0] == 'on' ? true : false,
                                    'countries_ids' => isset($newOldPayout['countries_ids']) ? json_encode($newOldPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                                    'coupon_id' => $coupon->id,
                                ]);
                            }
                        }
                    }

                    // If payout_cps_type is slaps
                    if ($request->payout_cps_type == 'slaps') {
                        if ($request->payout_slaps && count($request->payout_slaps) > 0) {
                            foreach ($request->payout_slaps as $slapsPayout) {
                                CouponCps::create([
                                    'type' => 'payout',
                                    'cps_type' => 'slaps',
                                    'amount_type' => 'flat',
                                    'amount' => $slapsPayout['payout'],
                                    'from' => $slapsPayout['from'] ?? null,
                                    'to' => $slapsPayout['to'] ?? null,
                                    'coupon_id' => $coupon->id,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
    }


    public function bulkChangeRevenue(Request $request)
    {
        return $request->all();
        $coupon = Coupon::findOrFail($request->id);
        $coupon->status = $request->status == 'active' ? 'active' : 'inactive';
        $coupon->save();
        return response()->json(['message' => 'Updated Succefuly']);
    }

    public function loadPayout(Request $request)
    {
        $coupon = Coupon::whereId($request->id)->first();
        if ($coupon) {
            return view('new_admin.coupons.load-payout', ['coupon' => $coupon]);
        }
        return 'No Data';
    }


    public function offerPayoutDateValidation(Request $request)
    {
        // Payout
        // Validate Static Payout
        if ($request->payout_cps_type == 'static' && $request->static_payout && count($request->static_payout) > 0) {
            foreach ($request->static_payout as $staticPayout) {
                if (isset($staticPayout['date_range']) && $staticPayout['date_range'][0]  == 'on') {
                    if ($staticPayout['from_date'] > $staticPayout['to_date']) {
                        return false;
                    }
                }
            }
        }

        // Validate new old Payout
        if ($request->payout_cps_type == 'new_old' && $request->new_old_payout && count($request->new_old_payout) > 0) {
            foreach ($request->new_old_payout as $newOldPayout) {
                if (isset($newOldPayout['date_range']) && $newOldPayout['date_range'][0]  == 'on') {
                    if ($newOldPayout['from_date'] > $newOldPayout['to_date']) {
                        return false;
                    }
                }
            }
        }

        // Validate slaps Payout
        if ($request->payout_cps_type == 'slaps' && $request->payout_slaps && count($request->payout_slaps) > 0) {
            foreach ($request->payout_slaps as $slapsPayout) {
                if ($slapsPayout['from'] > $slapsPayout['to']) {
                    return false;
                }
            }
        }
        return true;
    }
}
