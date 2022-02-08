<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\OfferRequest;
use App\Models\User;
use App\Notifications\NewAssigenCoupon;
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
        if ($request->ajax()){
        if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
            $offerRequests = getModelData('OfferRequest' , $request, ['user', 'offer'], function ($query) {
                $query->whereIn('user_id',auth()->user()->childrens()->pluck('id')->toArray());
            });
        }else{
            $offerRequests = getModelData('OfferRequest' , $request, ['user', 'offer'] );
        }

            return response()->json($offerRequests);
        }
        return view('admin.offerRequests.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_offer_requests');
        return view('admin.offerRequests.create', [
            'offers' => Offer::whereStatus('active')->get(),
            'users' => User::wherePosition('publisher')->get()
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
            'status' => 'required|in:pending,rejected,approved',
        ]);
        $offerRequest = OfferRequest::create($data);
        $userCoupons = Coupon::where([
            ['user_id', '=', $offerRequest->user_id],
            ['offer_id', '=', $offerRequest->offer_id],
        ])->pluck('id')->toArray();

        if($request->coupons ){
            // For loop to unassign un exists coupons 
            foreach($userCoupons as $userCoupon){
                if(!in_array($userCoupon, $request->coupons)){
                    $existsCoupon = Coupon::findOrFail($userCoupon);
                    $existsCoupon->user_id = null;
                    $existsCoupon->save();
                }
            }
            // For loop to assign coupons
            foreach($request->coupons as $coupon){
                if(!in_array($coupon, $userCoupons)){
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
        $this->authorize('show_offer_requests');
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
        $coupons = Coupon::where(function ($query) use($offerRequest) {
            $query->where('user_id',$offerRequest->user_id)
                  ->orWhere('user_id', null);
        })->where(function ($query) use($offerRequest) {
            $query->where('offer_id', $offerRequest->offer_id);
        })->get();

        return view('admin.offerRequests.edit', [
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
        $this->authorize('update_offer_requests');
        $data = $request->validate([
            'status' => 'required|in:pending,rejected,approved',
        ]);

        // Check if request has coupons 
        if($request->coupons){
            // Get user coupons
            $userCoupons = Coupon::where([
                ['user_id', '=', $offerRequest->user_id],
                ['offer_id', '=', $offerRequest->offer_id],
            ])->pluck('id')->toArray();

            // For loop to unassign un exists coupons 
            foreach($userCoupons as $userCoupon){
                if(!in_array($userCoupon, $request->coupons)){
                    $existsCoupon = Coupon::findOrFail($userCoupon);
                    $existsCoupon->user_id = null;
                    $existsCoupon->save();
                }
            }
            // For loop to assign coupons
            foreach($request->coupons as $coupon){
                if(!in_array($coupon, $userCoupons)){
                    $existsCoupon = Coupon::findOrFail($coupon);
                    $existsCoupon->user_id = $offerRequest->user_id;
                    $existsCoupon->save();
                }
            }
            Notification::send($offerRequest->user, new NewAssigenCoupon($offerRequest->offer));
        }

        // Check status 
        if($request->status =='approved'){
            if(!$offerRequest->user->offers->contains($offerRequest->offer_id)){
                $offerRequest->user->assignOffer($offerRequest->offer);
            }


        }else{
            $offerRequest->user->unAssignOffer($offerRequest->offer_id);
        }
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OfferRequest $offerRequest)
    {
        $this->authorize('delete_offer_requests');
        if($request->ajax()){
            userActivity('OfferRequest', $offerRequest->id, 'delete');
            $offerRequest->delete();
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
        ]);
        
        $offerRequest = OfferRequest::create([
            'offer_id' => $request->offerId,
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
        
        $coupons = Coupon::where(function ($query) use($request) {
            $query->where('user_id',$request->user_id)
                  ->orWhere('user_id', null);
        })->where(function ($query) use($request) {
            $query->where('offer_id', $request->offer_id);
        })->get();

        return view('admin.offerRequests.coupons', [
            'offer' => Offer::findOrFail($request->offer_id),
            'coupons' => $coupons, 
            'request' => $request
        ]);
    }

    public function viewOfferCoupons(Request $request)
    {
        if ($request->ajax()){
            $coupons = [];
            $link = '';

            $offer = Offer::findOrFail($request->offer_id);
            if($offer->type == 'coupon_tracking'){
                $coupons = Coupon::where('user_id', auth()->user()->id)->where('offer_id', $request->offer_id)->get();
            }else{
                $link = $offer->offer_url.'?utm_affiliate_id='.auth()->user()->id.'&utm_offer_id='.$offer->id; 
            }
            return view('admin.modals.coupons', ['coupons' => $coupons, 'link' => $link]);
        }
    }

}
