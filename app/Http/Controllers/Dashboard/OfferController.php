<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\Category;
use App\Models\Country;
use App\Models\NewOldOffer;
use App\Models\Offer;
use App\Models\OfferRequest;
use App\Models\OfferSlap;
use App\Models\User;
use App\Notifications\NewOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorize('view_offers');
        $offers = Offer::with(['advertiser', 'categories', 'countries'])->latest()->get();
        $offerRequestsArray = OfferRequest::where('user_id', auth()->user()->id)->pluck('offer_id')->toArray();
        return view('admin.offers.index', compact('offers', 'offerRequestsArray'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myOffers(Request $request)
    {
        $this->authorize('view_offers');
        $offers = auth()->user()->offers;
        $offerRequestsArray = OfferRequest::where('user_id', auth()->user()->id)->pluck('offer_id')->toArray();
        return view('admin.offers.index', compact('offers', 'offerRequestsArray'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_offers');
        return view('admin.offers.create',[
            'countries' => Country::all(),
            'categories' => Category::all(),
            'advertisers' => Advertiser::whereStatus('approved')->get()
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
        $this->authorize('create_offers');
        $data = $request->validate([
            'name' => 'required|max:255',
            'advertiser_id' => 'nullable|exists:advertisers,id',
            'description' => 'nullable',
            'website' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'offer_url' => 'required|url|max:255',
            'categories' => 'array|required|exists:categories,id',
            'type' => 'required|in:coupon_tracking,link_traking',
            'payout_type' => 'required|in:cps_flat,cps_percentage',
            'cps_type' => 'required|in:static,new_old,slaps',
            'payout' => 'required_if:cps_type,static|nullable|numeric',
            'revenue' => 'required_if:cps_type,static|nullable|numeric',
            'status' => 'required|in:active,pending,pused,expire',
            'expire_date' => 'required|date|after:yesterday',
            'note' => 'nullable',
            'terms_and_conditions' => 'nullable',
            'countries' => 'array|required|exists:countries,id',
            'currency_id' => 'nullable',
            'discount' => 'required|numeric',
            'discount_type' => 'required|in:flat,percentage',
        ]);

        $thumbnail = '';
        if($request->has('thumbnail')){
            $thumbnail = time().rand(11111,99999).'.'.$request->thumbnail->extension();
            $request->thumbnail->storeAs('Images/Offers/',$thumbnail, 'public');
        }
        
        $offer = Offer::create([
            'name' => $request->name,
            'description' => $request->description,
            'website' => $request->website,
            'thumbnail' => $thumbnail,
            'offer_url' => $request->offer_url,
            'type' => $request->type,
            'payout_type' => $request->payout_type,
            'cps_type' => $request->cps_type,
            'payout' => $request->cps_type=='static'?$request->payout:null,
            'revenue' => $request->cps_type=='static'?$request->revenue:null,
            'status' => $request->status,
            'expire_date' => $request->expire_date,
            'note' => $request->note, 
            'terms_and_conditions' => $request->terms_and_conditions,
            'advertiser_id' => $request->advertiser_id,
            'currency_id' => $request->currency_id,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
        ]);
        userActivity('Offer', $offer->id, 'create');
        $publishers = User::wherePosition('publisher')->get();
        Notification::send($publishers, new NewOffer($offer));

        if($request->categories){
            foreach($request->categories as $categoryId){
                $category = Category::findOrFail($categoryId);
                $offer->assignCategory($category);
            }
        }
        
        if($request->countries){
            foreach($request->countries as $countryId){
                $country = Country::findOrFail($countryId);
                $offer->assignCountry($country);
            }
        }
        
        // If cps is new old
        if($request->cps_type == 'new_old'){
            NewOldOffer::create([
                'new_payout' => $request->new_payout,
                'new_revenue' => $request->new_revenue,
                'old_payout' => $request->old_payout,
                'old_revenue' => $request->old_revenue,
                'offer_id' => $offer->id,
            ]);
        }

        // If cps is slaps 
        if($request->cps_type == 'slaps'){
            if($request->slaps && count($request->slaps) > 0){
                foreach($request->slaps as $slap){
                    OfferSlap::create([
                        'slap_type' => $slap['slap_type'],
                        'from' => $slap['from'],
                        'to' => $slap['to'],
                        'payout' => $slap['payout'],
                        'revenue' => $slap['revenue'],
                        'offer_id' => $offer->id,
                    ]);
                }
            }
            
        }
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.offers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show_offers');
        $offer = Offer::withTrashed()->findOrFail($id);
        userActivity('Offer', $offer->id, 'create');
        return view('admin.offers.show', ['offer' => $offer]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        $this->authorize('update_offers');
        return view('admin.offers.edit', [ 
            'offer' => $offer,
            'countries' => Country::all(),
            'categories' => Category::all(),
            'advertisers' => Advertiser::whereStatus('approved')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        $this->authorize('update_offers');
        $data = $request->validate([
            'name' => 'required|max:255',
            'advertiser_id' => 'nullable|exists:advertisers,id',
            'description' => 'nullable',
            'website' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'offer_url' => 'required|url|max:255',
            'categories' => 'array|required|exists:categories,id',
            'type' => 'required|in:coupon_tracking,link_traking',
            'payout_type' => 'required|in:cps_flat,cps_percentage',
            'cps_type' => 'required|in:static,new_old,slaps',
            'payout' => 'required_if:cps_type,static|nullable|numeric',
            'revenue' => 'required_if:cps_type,static|nullable|numeric',
            'status' => 'required|in:active,pending,pused,expire',
            'expire_date' => 'required|date|after:yesterday',
            'note' => 'nullable',
            'terms_and_conditions' => 'nullable',
            'countries' => 'array|required|exists:countries,id',
            'currency_id' => 'nullable',
            'discount' => 'required|numeric',
            'discount_type' => 'required|in:flat,percentage',
        ]);
        $thumbnail = $offer->thumbnail;
        if($request->has("thumbnail")){
            Storage::disk('public')->delete('Images/Offers/'.$offer->thumbnail);
            $thumbnail = time().rand(11111,99999).'.'.$request->thumbnail->extension();
            $request->thumbnail->storeAs('Images/Offers/',$thumbnail, 'public');
        }

        $offer->update([
            'name' => $request->name,
            'description' => $request->description,
            'website' => $request->website,
            'thumbnail' => $thumbnail,
            'offer_url' => $request->offer_url,
            'type' => $request->type,
            'payout_type' => $request->payout_type,
            'cps_type' => $request->cps_type,
            'payout' => $request->cps_type=='static'?$request->payout:null,
            'revenue' => $request->cps_type=='static'?$request->revenue:null,
            'status' => $request->status,
            'expire_date' => $request->expire_date,
            'note' => $request->note,
            'terms_and_conditions' => $request->terms_and_conditions,
            'advertiser_id' => $request->advertiser_id,
            'currency_id' => $request->currency_id,
            'discount_type' => $request->discount_type,
            'discount' => $request->discount,
        ]);
        userActivity('Offer', $offer->id, 'update');

        $offer->categories()->detach();
        foreach($request->categories as $categoryId){
            $category = Category::findOrFail($categoryId);
            $offer->assignCategory($category);
        }
        foreach($request->countries as $countryId){
            $country = Country::findOrFail($countryId);
            $offer->assignCountry($country);
        }
        // If cps is new old
        if($request->cps_type == 'new_old'){
            NewOldOffer::create([
                'new_payout' => $request->new_payout,
                'new_revenue' => $request->new_revenue,
                'old_payout' => $request->old_payout,
                'old_revenue' => $request->old_revenue,
                'offer_id' => $offer->id,
            ]);
        }

        // If cps is slaps 
        if($request->cps_type == 'slaps'){
            foreach($request->slaps as $slap){
                OfferSlap::create([
                    'slap_type' => $slap['slap_type'],
                    'from' => $slap['from'],
                    'to' => $slap['to'],
                    'payout' => $slap['payout'],
                    'revenue' => $slap['revenue'],
                    'offer_id' => $offer->id,
                ]);
            }
        }
        
        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.offers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Offer $offer)
    {
        $this->authorize('delete_offers');
        if($request->ajax()){
            userActivity('Offer', $offer->id, 'delete');
            Storage::disk('public')->delete('Images/Offers/'.$offer->thumbnail);
            $offer->delete();
        }
    }
}