<?php

namespace App\Http\Controllers\Dashboard;

use App\Facades\SallaFacade;
use App\Http\Controllers\Controller;
use App\Imports\OfferCouponImport;
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
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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
        $update             = in_array('update_offers', auth()->user()->permissions->pluck('name')->toArray());
        $offers             = Offer::with(['advertiser', 'categories', 'countries'])->latest()->get();
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
        $offers             = auth()->user()->offers;
        $update             = in_array('update_offers', auth()->user()->permissions->pluck('name')->toArray());
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
        return view('admin.offers.create', [
            'countries' => Country::all(),
            'categories' => Category::all(),
            'advertisers' => Advertiser::whereStatus('active')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_offers');
        $data = $request->validate([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'partener' => 'required|in:none,salla',
            'salla_user_email' => 'required_if:partener,salla|email|nullable',
            'advertiser_id' => 'nullable|exists:advertisers,id',
            'description_ar' => 'nullable',
            'description_en' => 'nullable',
            'website' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'offer_url' => 'required|url|max:255',
            'categories' => 'array|required|exists:categories,id',
            'type' => 'required|in:coupon_tracking,link_tracking',
            'coupons' => 'nullable|file',
            'cps_type' => 'required|in:static,new_old,slaps',
            'payout_type' => 'required_if:cps_type,static|in:flat,percentage',
            'revenue_type' => 'required_if:cps_type,static|in:flat,percentage',
            'payout' => 'required_if:cps_type,static|nullable|numeric',
            'revenue' => 'required_if:cps_type,static|nullable|numeric',
            'new_payout' => 'required_if:cps_type,new_old|nullable|numeric',
            'new_revenue' => 'required_if:cps_type,new_old|nullable|numeric',
            'old_payout' => 'required_if:cps_type,new_old|nullable|numeric',
            'old_revenue' => 'required_if:cps_type,new_old|nullable|numeric',
            'status' => 'required|in:active,pending,pused,expire',
            'expire_date' => 'required|date|after:yesterday',
            'note' => 'nullable',
            'terms_and_conditions_ar' => 'nullable',
            'terms_and_conditions_en' => 'nullable',
            'countries' => 'array|required|exists:countries,id',
            'currency_id' => 'nullable',
            'discount' => 'required|numeric',
            'discount_type' => 'required|in:flat,percentage',
            'slaps.*.from' => 'required_if:cps_type,slaps',
            'slaps.*.to' => 'required_if:cps_type,slaps',
            'slaps.*.revenue' => 'required_if:cps_type,slaps',
            'slaps.*.payout' => 'required_if:cps_type,slaps',
        ]);

        $thumbnail = '';
        if ($request->has('thumbnail')) {
            $thumbnail = time() . rand(11111, 99999) . '.' . $request->thumbnail->extension();
            $request->thumbnail->storeAs('Images/Offers/', $thumbnail, 'public');
        }
        unset($data['coupons']);
        unset($data['slaps']);
        unset($data['categories']);
        unset($data['countries']);
        unset($data['new_payout']);
        unset($data['new_revenue']);
        unset($data['old_payout']);
        unset($data['old_revenue']);
        $data['thumbnail'] = $thumbnail;
        $data['payout']    = $request->cps_type == 'static' ? $request->payout : null;
        $data['revenue']   = $request->cps_type == 'static' ? $request->revenue : null;

        $offer = Offer::create($data);
        userActivity('Offer', $offer->id, 'create');
        $publishers = User::wherePosition('publisher')->get();
        Notification::send($publishers, new NewOffer($offer));

        if ($request->categories) {
            $offer->categories()->attach($request->categories);
        }

        if ($request->countries) {
            $offer->countries()->attach($request->countries);
        }

        // If cps is new old
        if ($request->cps_type == 'new_old') {
            NewOldOffer::create([
                'new_payout' => $request->new_payout,
                'new_revenue' => $request->new_revenue,
                'old_payout' => $request->old_payout,
                'old_revenue' => $request->old_revenue,
                'new_payout_type' => $request->new_payout_type,
                'new_revenue_type' => $request->new_revenue_type,
                'old_payout_type' => $request->old_payout_type,
                'old_revenue_type' => $request->old_revenue_type,
                'offer_id' => $offer->id,
            ]);
        }
        // If cps is slaps
        if ($request->cps_type == 'slaps') {
            if ($request->slaps && count($request->slaps) > 0) {
                foreach ($request->slaps as $slap) {
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

        // If this offer is with salla partener 
        if($request->partener == 'salla'){
            SallaFacade::assignSalaInfoToOffer($offer->salla_user_email, $offer->id);
        }

         // Check of offer type is link tracking to upload coupons
        if($request->coupons){
            Excel::import(new OfferCouponImport($offer->id),request()->file('coupons'));
        }
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.offers.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show_offers');
        $offer = Offer::withTrashed()->findOrFail($id);
        $offerRequest = OfferRequest::where([
            ['user_id', '=',auth()->user()->id],
            ['offer_id', '=',$offer->id]
            
        ])->first();

        userActivity('Offer', $offer->id, 'create');
        return view('admin.offers.show', ['offer' => $offer, 'offerRequest' => $offerRequest]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        $this->authorize('update_offers');
        return view('admin.offers.edit', [
            'offer' => $offer,
            'countries' => Country::all(),
            'categories' => Category::all(),
            'advertisers' => Advertiser::whereStatus('active')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        $this->authorize('update_offers');
        $data      = $request->validate([
            'name_ar' => 'required|max:255',
            'name_en' => 'required|max:255',
            'partener' => 'required|in:none,salla',
            'salla_user_email' => 'nullable|required_if:partener,salla|email',
            'advertiser_id' => 'nullable|exists:advertisers,id',
            'description_ar' => 'nullable',
            'description_en' => 'nullable',
            'website' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'offer_url' => 'required|url|max:255',
            'categories' => 'array|required|exists:categories,id',
            'type' => 'required|in:coupon_tracking,link_tracking',
            'cps_type' => 'required|in:static,new_old,slaps',
            'payout_type' => 'required|in:flat,percentage',
            'revenue_type' => 'required|in:flat,percentage',
            'payout' => 'required_if:cps_type,static|nullable|numeric',
            'revenue' => 'required_if:cps_type,static|nullable|numeric',
            'new_payout' => 'required_if:cps_type,new_old|nullable|numeric',
            'new_revenue' => 'required_if:cps_type,new_old|nullable|numeric',
            'old_payout' => 'required_if:cps_type,new_old|nullable|numeric',
            'old_revenue' => 'required_if:cps_type,new_old|nullable|numeric',
            'status' => 'required|in:active,pending,pused,expire',
            'expire_date' => 'required|date|after:yesterday',
            'note' => 'nullable',
            'terms_and_conditions_ar' => 'nullable',
            'terms_and_conditions_en' => 'nullable',
            'countries' => 'array|required|exists:countries,id',
            'currency_id' => 'nullable',
            'discount' => 'required|numeric',
            'discount_type' => 'required|in:flat,percentage',
        ]);
        $thumbnail = $offer->thumbnail;
        if ($request->has("thumbnail")) {
            Storage::disk('public')->delete('Images/Offers/' . $offer->thumbnail);
            $thumbnail = time() . rand(11111, 99999) . '.' . $request->thumbnail->extension();
            $request->thumbnail->storeAs('Images/Offers/', $thumbnail, 'public');
        }

        unset($data['categories']);
        unset($data['countries']);
        unset($data['new_payout']);
        unset($data['new_revenue']);
        unset($data['old_payout']);
        unset($data['old_revenue']);

        $data['thumbnail'] = $thumbnail;
        $data['payout']    = $request->cps_type == 'static' ? $request->payout : null;
        $data['revenue']   = $request->cps_type == 'static' ? $request->revenue : null;

        userActivity('Offer', $offer->id, 'update', $data, $offer);
        $offer->update($data);

        if ($request->categories) {
            $offer->categories()->sync($request->categories);
        }

        if ($request->countries) {
            $offer->countries()->sync($request->countries);
        }
        // If cps is new old
        if ($request->cps_type == 'new_old') {
            NewOldOffer::updateOrCreate([
                'offer_id' => $offer->id,
            ], [
                'new_payout' => $request->new_payout,
                'new_revenue' => $request->new_revenue,
                'old_payout' => $request->old_payout,
                'old_revenue' => $request->old_revenue,
                'new_payout_type' => $request->new_payout_type,
                'new_revenue_type' => $request->new_revenue_type,
                'old_payout_type' => $request->old_payout_type,
                'old_revenue_type' => $request->old_revenue_type,
            ]);
        }

        // If cps is slaps
        if ($request->cps_type == 'slaps') {
            $offer->slaps->detach();
            foreach ($request->slaps as $slap) {
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

        // If this offer is with salla partener 
        if($request->partener == 'salla'){
            SallaFacade::assignSalaInfoToOffer($offer->salla_user_email, $offer->id);
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Offer $offer)
    {
        $this->authorize('delete_offers');
        if ($request->ajax()) {
            userActivity('Offer', $offer->id, 'delete');
            Storage::disk('public')->delete('Images/Offers/' . $offer->thumbnail);
            $offer->delete();
        }
    }

}
