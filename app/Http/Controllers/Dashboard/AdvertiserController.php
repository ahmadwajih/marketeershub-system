<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;

class AdvertiserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_advertisers');
        if($request->ajax()){
            $advertisers = getModelData('Advertiser', $request);
            return response()->json($advertisers);
        }
        return view('admin.advertisers.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_advertisers');
        return view('admin.advertisers.create',[
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
        $this->authorize('create_advertisers');

        $data = $request->validate([
            'name'          => 'required|max:255',
            'phone'         => 'required|max:255',
            'email'         => 'required|max:255',
            'ho_user_id'    => 'nullable|max:255',
            'company_name'  => 'required|max:255',
            'website'       => 'nullable|max:255',
            'country_id'    => 'required|max:255',
            'city_id'       => 'required|max:255',
            'address'       => 'nullable|max:255',
            'status'        => 'nullable|in:pending,rejected,approved',
        ]);

        Advertiser::create($data);
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.advertisers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Advertiser $advertiser)
    {
        $this->authorize('show_advertisers');

        return view('admin.advertisers.show', ['advertiser' => $advertiser]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Advertiser $advertiser)
    {
        $this->authorize('update_advertisers');

        return view('admin.advertisers.edit', [
            'advertiser' => $advertiser,
            'countries' => Country::all(),
            'cities' => City::whereCountryId($advertiser->country_id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Advertiser $advertiser)
    {
        $this->authorize('update_advertisers');
        $data = $request->validate([
            'name'          => 'required|max:255',
            'phone'         => 'required|max:255',
            'email'         => 'required|max:255',
            'ho_user_id'    => 'nullable|max:255',
            'company_name'  => 'required|max:255',
            'website'       => 'nullable|max:255',
            'country_id'    => 'required|max:255',
            'city_id'       => 'required|max:255',
            'address'       => 'nullable|max:255',
            'status'        => 'nullable|in:pending,rejected,approved',
        ]);

        $advertiser->update($data);
        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.advertisers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Advertiser $advertiser)
    {
        $this->authorize('delete_advertisers');
        if($request->ajax()){
            $advertiser->delete();
        }
    }
}
