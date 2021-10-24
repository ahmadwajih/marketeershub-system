<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Models\OfferRequest;
use App\Models\User;

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
        return view('dashboard.offerRequests.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_offerRequests');
        return view('dashboard.offerRequests.create', [
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
        OfferRequest::create($data);
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('dashboard.offerRequests.index');
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
        OfferRequest::create([
            'offer_id' => $request->offerId,
            'user_id' => auth()->user()->id,
        ]);
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
        return view('dashboard.offerRequests.show', ['offerRequest' => $offerRequest]);
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
        return view('dashboard.offerRequests.edit', [
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
        // dd($request->all());
        $this->authorize('update_offerRequests');
        $data = $request->validate([
            'status' => 'required|in:pending,rejected,approved',
        ]);
        if($request->coupons ){
            foreach($request->coupons as $coupon){
                $existsCoupon = Coupon::findOrFail($coupon);
                $existsCoupon->user_id = $offerRequest->user_id;
                $existsCoupon->save();
            }
        }
        if($request->status =='approved'){
            $offerRequest->user->assignOffer($offerRequest->offer);
        }else{
            $offerRequest->user->unAssignOffer($offerRequest->offer_id);
        }

        $offerRequest->update($data);
        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('dashboard.offerRequests.index');
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
            $offerRequest->delete();
        }
    }
}
