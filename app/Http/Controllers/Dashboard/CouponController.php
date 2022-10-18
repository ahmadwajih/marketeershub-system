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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_coupons');
        // Get Coupons 
        $query = Coupon::query();
        if(isset($request->table_length ) && $request->table_length  != null){
            session()->put('coupons_table_length', $request->table_length);
        }
        if (session()->has('coupons_table_length') == false) {
            session()->put('coupons_table_length', config('app.pagination_pages'));
        }
        $tableLength = session('coupons_table_length');
        // Filter
        

        if(isset($request->offer_id ) && $request->offer_id  != null){
            $query->where('offer_id', $request->offer_id);
        }

        if(isset($request->user_id ) && $request->user_id  != null){
            $query->where('user_id', $request->user_id);
        }

        if(isset($request->status ) && $request->status  != null){
            $query->where('status', $request->status);
        }

        if(isset($request->search ) && $request->search  != null){
            $query->where('coupon', $request->search);
        }

        $coupons = $query->with(['offer', 'user']);
        $coupons = $query->paginate($tableLength);

        $countries = Country::all();
        $publishers = User::wherePosition('publisher')->get();
        $offers = Offer::all();
        return view('new_admin.coupons.index', [
            'countries' => $countries,
            'publishers' => $publishers,
            'coupons' => $coupons,
            'offers' => $offers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_coupons');

        return view('new_admin.coupons.create', [
            'offers' => Offer::whereStatus("active")->get(),
            'users' => User::whereIn('position', ['publisher'])->whereIn('team', ['media_buying', 'influencer', 'affiliate', 'prepaid'])->get(),
            'countries' => Country::all(),
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
        $this->authorize('create_coupons');
        $data = $request->validate([
            'coupon'          => 'required|max:255',
            'offer_id'        => 'required|numeric|exists:offers,id',
            'user_id'        => 'nullable|numeric|exists:users,id',
        ]);
        $data['coupon'] = strtolower(trim(str_replace(' ', '', trim($request->coupon))));
        $data['have_custom_payout'] = isset($request->have_custom_payout) && $request->have_custom_payout == 'on' ? true : false;
        // dd($request->all());
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
                            'amount_type' => $request->payout_type,
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
                            'amount_type' => $request->payout_type,
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
                            'amount_type' => $request->payout_type,
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show_coupons');
        $coupon = Coupon::withTrashed()->findOrFail($id);
        userActivity('Coupon', $coupon->id, 'show');
        return view('new_admin.coupons.show', ['coupon' => $coupon]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        $this->authorize('update_coupons');

        return view('new_admin.coupons.edit', [
            'coupon' => $coupon,
            'offers' => Offer::whereStatus("active")->get(),
            'users' => User::whereStatus("active")->whereIn('position', ['publisher'])->whereIn('team', ['media_buying', 'influencer', 'affiliate', 'prepaid'])->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $this->authorize('update_coupons');
        $data = $request->validate([
            'coupon'          => 'required|max:255',
            'offer_id'        => 'required|numeric|exists:offers,id',
            'user_id'        => 'nullable|numeric|exists:users,id',
        ]);

        $coupon->update($data);
        userActivity('Coupon', $coupon->id, 'update');
        if ($request->user_id) {
            try {
                Notification::send($coupon->user, new CodeRecycled($coupon));
            } catch (\Throwable $th) {
                Log::debug($th);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Coupon $coupon)
    {
        $this->authorize('delete_coupons');
        if ($request->ajax()) {
            if($coupon->report && $coupon->report->count() > 0){
                return response()->json(['message' => __('You cannot delete this coupout because it have transactions.')], 422);
            }
            userActivity('Coupon', $coupon->id, 'delete');
            $coupon->delete();
        }
    }


    /**
     * Show the form for uploading a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadForm()
    {
        $this->authorize('view_upload_coupons');
        return view('new_admin.coupons.upload', [
            'offers' => Offer::whereStatus("active")->get()
        ]);
    }


    /**
     * Show the form for uploading a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        $this->authorize('view_upload_coupons');
        $request->validate([
            'offer_id'   => 'required|exists:offers,id',
            'coupons'    => 'required|mimes:xlsx,csv',
        ]);

        Excel::import(new CouponImport($request->offer_id, $request->team), request()->file('coupons'));
        userActivity('Coupon', null, 'upload');

        $notification = [
            'message' => 'Uploaded successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.coupons.index')->with($notification);
    }

    public function changeStatus(Request $request)
    {
        $this->authorize('update_coupons');
        $coupon = Coupon::findOrFail($request->id);
        $coupon->status = $request->status == 'active' ? 'active' : 'unactive';
        $coupon->save();
        return response()->json(['message' => 'Updated Succefuly']);
    }

    public function bulckEdit(Request $request)
    {
        return view('new_admin.coupons.bulck-edit-form');
    }

    public function bulckUpdate(Request $request)
    {
        if (count($request->item_check) > 0) {
            foreach ($request->item_check as $couponId) {
                $coupon = Coupon::findOrFail($couponId);
                if ($request->user_id) {
                    $coupon->user_id = $request->user_id;
                    $coupon->save();
                }
                $coupon->cps()->delete();


                // If payout_cps_type is static
                if ($request->payout_cps_type == 'static') {
                    if ($request->static_payout && count($request->static_payout) > 0) {
                        foreach ($request->static_payout as $staticPayout) {
                            CouponCps::create([
                                'type' => 'payout',
                                'cps_type' => 'static',
                                'amount_type' => $request->payout_type,
                                'amount' => $staticPayout['payout'],
                                'date_range' => isset($staticPayout['date_range']) && $staticPayout['date_range'][0] == 'on' ? true : false,
                                'from_date' => $staticPayout['from_date'] ?? null,
                                'to_date' => $staticPayout['to_date'] ?? null,
                                'countries' => isset($staticPayout['countries']) && $staticPayout['countries'][0] == 'on' ? true : false,
                                'countries_ids' => isset($staticPayout['countries_ids']) ? json_encode($staticPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                                'coupon_id' => $couponId,
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
                                'amount_type' => $request->payout_type,
                                'new_amount' => $newOldPayout['new_payout'],
                                'old_amount' => $newOldPayout['old_payout'],
                                'date_range' => isset($newOldPayout['date_range']) && $newOldPayout['date_range'][0] == 'on' ? true : false,
                                'from_date' => $newOldPayout['from_date'] ?? null,
                                'to_date' => $newOldPayout['to_date'] ?? null,
                                'countries' => isset($newOldPayout['countries']) && $newOldPayout['countries'][0] == 'on' ? true : false,
                                'countries_ids' => isset($newOldPayout['countries_ids']) ? json_encode($newOldPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                                'coupon_id' => $couponId,
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
                                'amount_type' => $request->payout_type,
                                'amount' => $slapsPayout['payout'],
                                'from' => $slapsPayout['from'] ?? null,
                                'to' => $slapsPayout['to'] ?? null,
                                'coupon_id' => $couponId,
                            ]);
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
        $coupon->status = $request->status == 'active' ? 'active' : 'unactive';
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
}
