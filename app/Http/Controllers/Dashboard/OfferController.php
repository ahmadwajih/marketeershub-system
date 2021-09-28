<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\Country;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        if ($request->ajax()){
            $offers = getModelData('Offer' , $request, ['advertiser']);
            return response()->json($offers);
        }
        return view('dashboard.offers.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_offers');
        return view('dashboard.offers.create',[
            'countries' => Country::all(),
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
            'description' => 'nullable',
            'website' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'offer_url' => 'required|url|max:255',
            'category' => 'nullable|max:255',
            'payout_type' => 'nullable|max:255',
            'default_payout' => 'nullable|numeric',
            'percent_payout' => 'nullable|numeric',
            'status' => 'required|in:active,pending,pused,expire',
            'expire_date' => 'required|date|after:yesterday',
            'note' => 'nullable',
            'terms_and_conditions' => 'nullable',
            'advertiser_id' => 'nullable|exists:advertisers,id',
            'country_id' => 'required|exists:countries,id',
            'currency_id' => 'nullable',
        ]);
        if($request->has('thumbnail')){
            $imageName = time().rand(11111,99999).'.'.$request->thumbnail->extension();
            $request->thumbnail->storeAs('Images/Offers/',$imageName, 'public');
            $data['thumbnail'] = $imageName;
        }
        
        Offer::create($data);
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('dashboard.offers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        $this->authorize('show_offers');
        return view('dashboard.offers.show', ['offer' => $offer]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        $this->authorize('show_offers');
        return view('dashboard.offers.edit', [ 
            'offer' => $offer,
            'countries' => Country::all(),
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
            'description' => 'nullable',
            'website' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'offer_url' => 'required|url|max:255',
            'category' => 'nullable|max:255',
            'payout_type' => 'nullable|max:255',
            'default_payout' => 'nullable|numeric',
            'percent_payout' => 'nullable|numeric',
            'status' => 'required|in:active,pending,pused,expire',
            'expire_date' => 'required|date',
            'note' => 'nullable',
            'terms_and_conditions' => 'nullable',
            'advertiser_id' => 'nullable|exists:advertisers,id',
            'country_id' => 'required|exists:countries,id',
            'currency_id' => 'nullable',
        ]);
        unset($data['thumbnail']);
        if($request->has("thumbnail")){
            Storage::disk('public')->delete('Images/Offers/'.$offer->thumbnail);
            $imageName = time().rand(11111,99999).'.'.$request->thumbnail->extension();
            $request->thumbnail->storeAs('Images/Offers/',$imageName, 'public');
            $data['thumbnail'] = $imageName;
        }
            

       
        $offer->update($data);
        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('dashboard.offers.index');
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
            Storage::disk('public')->delete('Images/Offers/'.$offer->thumbnail);
            $offer->delete();
        }
    }
}