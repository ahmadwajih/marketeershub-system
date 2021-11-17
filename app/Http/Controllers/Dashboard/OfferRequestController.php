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

class OfferRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_offerRequests');
        if ($request->ajax()){
            $offerRequests = getModelData('OfferRequest' , $request, ['user', 'offer']);
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
        $this->authorize('create_offerRequests');
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
        $this->authorize('create_offerRequests');
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'offer_id' => 'required|integer|exists:offers,id',
            'status' => 'required|in:pending,rejected,approved',
        ]);
        $offerRequest = OfferRequest::create($data);
        userActivity('OfferRequest', $offerRequest->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.offerRequests.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function offerRequestAjax(Request $request)
    {
        $this->authorize('create_offerRequests');
        $data = $request->validate([
            'offerId' => 'required|integer|exists:offers,id',
        ]);
        $exists = OfferRequest::where([
            ['offer_id', '=', $request->offerId],
            ['user_id', '=', auth()->user()->id]
        ])->first();
        if($exists){
            return response('exists', 422);
        }
        $offerRequest = OfferRequest::create([
            'offer_id' => $request->offerId,
            'user_id' => auth()->user()->id,
        ]);
        userActivity('OfferRequest', $offerRequest->id, 'create');

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OfferRequest $offerRequest)
    {
        $this->authorize('show_offerRequests');
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
        $this->authorize('show_offerRequests');
        return view('admin.offerRequests.edit', [
            'offerRequest' => $offerRequest,
            'offers' => Offer::whereStatus('active')->get(),
            'users' => User::wherePosition('publisher')->get(),
            'coupons' => $offerRequest->offer->coupons()->where('user_id',$offerRequest->user_id)->orWhere('user_id', null)->get()
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
        $this->authorize('update_offerRequests');
        $data = $request->validate([
            'status' => 'required|in:pending,rejected,approved',
        ]);
        $userCoupons = $offerRequest->user->coupons->pluck('id')->toArray();

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

        if($request->status =='approved'){
            if(!$offerRequest->user->offers->contains($offerRequest->offer_id)){
                $offerRequest->user->assignOffer($offerRequest->offer);
            }
        }else{
            $offerRequest->user->unAssignOffer($offerRequest->offer_id);
        }

        $offerRequest->update($data);
        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        userActivity('OfferRequest', $offerRequest->id, 'update');

        return redirect()->route('admin.offerRequests.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, OfferRequest $offerRequest)
    {
        $this->authorize('delete_offerRequests');
        if($request->ajax()){
            userActivity('OfferRequest', $offerRequest->id, 'delete');
            $offerRequest->delete();
        }
    }
}
