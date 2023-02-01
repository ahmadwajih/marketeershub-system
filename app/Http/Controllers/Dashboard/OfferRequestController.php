<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\SallaFacade;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Offer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Models\OfferRequest;
use App\Models\SallaAffiliate;
use App\Models\User;
use App\Notifications\NewAssigenCoupon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class OfferRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_offer_requests');

        $query = OfferRequest::query();

         $tableLength = session('table_length') ?? config('app.pagination_pages');

        // Filter
        if (isset($request->offer_id) && $request->offer_id  != null) {
            $query->where('offer_id', $request->offer_id);
            session()->put('offer_requests_filter_offer_id', $request->offer_id);
        } elseif (session('offer_requests_filter_offer_id')) {
            $query->where('offer_id', session('offer_requests_filter_offer_id'));
        }

        if (isset($request->user_id) && $request->user_id  != null || session('offer_requests_filter_user_id')) {
            $query->where('user_id', $request->user_id);
            session()->put('offer_requests_filter_user_id', $request->user_id);
        } elseif (session('offer_requests_filter_user_id')) {
            $query->where('user_id', session('offer_requests_filter_user_id'));
        }

        if (isset($request->status) && $request->status  != null) {
            $query->where('status', $request->status);
            session()->put('offer_requests_filter_status', $request->status);
        } elseif (session('offer_requests_filter_status')) {
            $query->where('status', session('offer_requests_filter_status'));
        }

        if (isset($request->search) && $request->search  != null) {
            $query->where('coupon', $request->search);
        }
        if (!in_array('super_admin', auth()->user()->roles->pluck('label')->toArray())) {
            $query->whereIn('user_id', userChildrens());
        }

        $offerRequests = $query->with(['offer', 'user'])->orderBy('id', 'desc')->paginate($tableLength);
        $publisherForFilter = User::whereId(session('offer_requests_filter_user_id'))->first();
        return view('new_admin.offerRequests.index', [
            'offerRequests' => $offerRequests,
            'offers' => Offer::orderBy('id', 'desc')->get(),
            'publisherForFilter' => $publisherForFilter
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_offer_requests');
        if (in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])) {
            $users =  auth()->user()->childrens()->get();
        } else {
            $users =  User::wherePosition('publisher')->get();
        }
        return view('new_admin.offerRequests.create', [
            'offers' => Offer::whereStatus('active')->get(),
            'users' => $users
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
        $this->authorize('create_offer_requests');
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'offer_id' => 'required|integer|exists:offers,id',
        ]);
        $data['status'] = 'approved';
        $offerRequest = OfferRequest::create($data);
        $userCoupons = Coupon::where([
            ['user_id', '=', $offerRequest->user_id],
            ['offer_id', '=', $offerRequest->offer_id],
        ])->pluck('id')->toArray();

        if ($request->coupons) {
            // For loop to unassign un exists coupons
            foreach ($userCoupons as $userCoupon) {
                if (!in_array($userCoupon, $request->coupons)) {
                    $existsCoupon = Coupon::findOrFail($userCoupon);
                    $existsCoupon->user_id = null;
                    $existsCoupon->save();
                }
            }
            // For loop to assign coupons
            foreach ($request->coupons as $coupon) {
                if (!in_array($coupon, $userCoupons)) {
                    $existsCoupon = Coupon::findOrFail($coupon);
                    $existsCoupon->user_id = $offerRequest->user_id;
                    $existsCoupon->save();
                }
            }
            Notification::send($offerRequest->user, new NewAssigenCoupon($offerRequest->offer));
        }

        userActivity('OfferRequest', $offerRequest->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.offerRequests.index')->with($notification);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OfferRequest $offerRequest)
    {
        $this->authorize('view_offer_requests');
        userActivity('OfferRequest', $offerRequest->id, 'show');
        return view('admin.offerRequests.show', ['offerRequest' => $offerRequest]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OfferRequest $offerRequest)
    {
        $this->authorize('update_offer_requests');
        $coupons = Coupon::where(function ($query) use ($offerRequest) {
            $query->where('user_id', $offerRequest->user_id)
                ->orWhere('user_id', null);
        })->where(function ($query) use ($offerRequest) {
            $query->where('offer_id', $offerRequest->offer_id);
        })->get();

        return view('new_admin.offerRequests.edit', [
            'offerRequest' => $offerRequest,
            'offers' => Offer::whereStatus('active')->get(),
            'users' => User::wherePosition('publisher')->get(),
            'coupons' => $coupons
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OfferRequest $offerRequest)
    {

        // If offer partener is Salla
        if ($offerRequest->offer->partener == 'salla') {
            $offer = $offerRequest->offer;
            $sallaInfo = $offer->sallaInfo;
            $res = SallaFacade::storeAffiliate($sallaInfo->access_token, $offer->revenue, $offer->note, $offerRequest->offer_id, $offerRequest->user_id);
        }

        $this->authorize('update_offer_requests');
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'offer_id' => 'required|integer|exists:offers,id',
        ]);

        // Check if request has coupons
        if ($request->coupons) {
            // Get user coupons
            $userCoupons = Coupon::where([
                ['user_id', '=', $offerRequest->user_id],
                ['offer_id', '=', $offerRequest->offer_id],
            ])->pluck('id')->toArray();

            // For loop to unassign un exists coupons
            foreach ($userCoupons as $userCoupon) {
                if (!in_array($userCoupon, $request->coupons)) {
                    $existsCoupon = Coupon::findOrFail($userCoupon);
                    $existsCoupon->user_id = null;
                    $existsCoupon->save();
                }
            }
            // For loop to assign coupons
            foreach ($request->coupons as $coupon) {
                if (!in_array($coupon, $userCoupons)) {
                    $existsCoupon = Coupon::findOrFail($coupon);
                    $existsCoupon->user_id = $offerRequest->user_id;
                    $existsCoupon->save();
                }
            }
            // Notification::send($offerRequest->user, new NewAssigenCoupon($offerRequest->offer));
        }

        // Check status
        // if ($request->status == 'approved') {
            if (!$offerRequest->user->offers->contains($offerRequest->offer_id)) {
                $offerRequest->user->assignOffer($offerRequest->offer);
            }

            // Salla partener code here

        // } else {
        //     $offerRequest->user->unAssignOffer($offerRequest->offer_id);
        // }
        // Update offer status
        $offerRequest->update($data);
        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        userActivity('OfferRequest', $offerRequest->id, 'update');

        return redirect()->route('admin.offerRequests.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param OfferRequest $offerRequest
     * @return Response
     * @throws AuthorizationException
     */
    public function destroy(Request $request, OfferRequest $offerRequest)
    {
        $this->authorize('delete_offer_requests');
        if ($request->ajax()) {
            userActivity('OfferRequest', $offerRequest->id, 'delete');
            $offerRequest->forceDelete();
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function offerRequestAjax(Request $request)
    {
        $this->authorize('create_offer_requests');
        $data = $request->validate([
            'offerId' => 'required|integer|exists:offers,id',
            'numberOfRequestedCoupons' => 'nullable|integer'
        ]);
        $couponsNumber = $request->numberOfRequestedCoupons ?? 1;
        $offerRequest = OfferRequest::create([
            'offer_id' => $request->offerId,
            'number_of_coupons' => $couponsNumber,
            'user_id' => auth()->user()->id,
        ]);
        userActivity('OfferRequest', $offerRequest->id, 'create');

        return true;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function offerRequestAjaxForm(Request $request)
    {
        $this->authorize('create_offer_requests');
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required|integer|exists:offers,id',
        ]);

        // Check Validation
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'code' => 422], 422);
        }

        return view('admin.offerRequests.form', [
            'offer' => Offer::findOrFail($request->offer_id)
        ]);
    }

    public function coupons(Request $request)
    {
        $this->authorize('create_offer_requests');
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required|integer|exists:offers,id',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);

        // Check Validation
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages(), 'code' => 422], 422);
        }

        $coupons = Coupon::where(function ($query) use ($request) {
            $query->where('user_id', $request->user_id)
                ->orWhere('user_id', null);
        })->where(function ($query) use ($request) {
            $query->where('offer_id', $request->offer_id);
        })->get();

        return view('new_admin.offerRequests.coupons', [
            'offer' => Offer::findOrFail($request->offer_id),
            'coupons' => $coupons,
            'request' => $request
        ]);
    }

    public function viewOfferCoupons(Request $request)
    {

        if ($request->ajax()) {
            $coupons = [];
            $link = '';

            $offer = Offer::findOrFail($request->offer_id);
            if ($offer->type == 'coupon_tracking') {
                $coupons = Coupon::where('user_id', auth()->user()->id)->where('offer_id', $request->offer_id)->get();
            } else {
                $link = $offer->offer_url . '?utm_affiliate_id=' . auth()->user()->id . '&utm_offer_id=' . $offer->id;

                if ($offer->partener == 'salla') {
                    $link =  SallaAffiliate::whereUserId(auth()->user()->id)->first()->link_affiliate;
                }
            }
            return view('admin.modals.coupons', ['coupons' => $coupons, 'link' => $link]);
        }
    }

    public function changeStatus(Request $request)
    {
        $this->authorize('update_offer_requests');
        $offerRequest = OfferRequest::findOrFail($request->id);
        $offerRequest->status = $request->status == 'approved' ? 'approved' : 'rejected';
        $offerRequest->save();
        return response()->json(['message' => 'Updated Succefuly']);
    }


    public function clearFilterSeassoions()
    {
        session()->forget('offer_requests_filter_offer_id');
        session()->forget('offer_requests_filter_user_id');
        session()->forget('offer_requests_filter_status');
        return redirect()->route('admin.offerRequests.index');
    }

}
