<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;
/*
 * Just for repo fix
 **/
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
            'categories' => Category::whereType('advertisers')->get(),
            'currencies' => Currency::all(),
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
            'name'                  => 'nullable|max:255',
            'phone'                 => 'nullable|max:255',
            'email'                 => 'nullable|max:255',
            'ho_user_id'            => 'nullable|max:255',
            'company_name_ar'       => 'required|max:255',
            'company_name_en'       => 'required|max:255',
            'website'               => 'nullable|max:255',
            'categories'            => 'array|required|exists:categories,id',
            'country_id'            => 'required|max:255|exists:countries,id',
            'city_id'               => 'required|max:255|exists:cities,id',
            'currency_id'           => 'required|max:255|exists:currencies,id',
            'address'               => 'nullable|max:255',
            'validation_duration'   => 'nullable|max:255',
            'status'                => 'required|in:active,unactive',
            'validation_source'     => 'nullable|max:255',
            'validation_type'       => 'required|in:system,sheet,manual_report_via_email',
            'language'              => 'required|in:ar,en,ar_en',
            'access_username'       => 'nullable|max:255',
            'access_password'       => 'nullable|max:255',
        ]);

        $data['exclusive'] = isset($request->exclusive)&&$request->exclusive == 'on' ? true : false;
        unset($data['categories']);

        $advertiser = Advertiser::create($data);
        $advertiser->categories()->attach($request->categories);
        userActivity('Advertiser', $advertiser->id, 'create');

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
    public function show($id)
    {
        $this->authorize('show_advertisers');
        $advertiser = Advertiser::withTrashed()->findOrFail($id);
        userActivity('Advertiser', $advertiser->id, 'show');
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
            'categories' => Category::whereType('advertisers')->get(),
            'currencies' => Currency::all(),
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
            'name'                  => 'nullable|max:255',
            'phone'                 => 'nullable|max:255',
            'email'                 => 'nullable|max:255',
            'ho_user_id'            => 'nullable|max:255',
            'company_name_ar'       => 'required|max:255',
            'company_name_en'       => 'nullable|max:255',
            'website'               => 'nullable|max:255',
            'categories'            => 'array|required|exists:categories,id',
            'country_id'            => 'required|max:255|exists:countries,id',
            'city_id'               => 'required|max:255|exists:cities,id',
            'currency_id'           => 'required|max:255|exists:currencies,id',
            'address'               => 'nullable|max:255',
            'validation_duration'   => 'nullable|max:255',
            'status'                => 'required|in:active,unactive',
            'validation_source'     => 'nullable|max:255',
            'validation_type'       => 'required|in:system,sheet,manual_report_via_email',
            'language'              => 'required|in:ar,en,ar_en',
            'access_username'       => 'nullable|max:255',
            'access_password'       => 'nullable|max:255',
        ]);

        $data['exclusive'] = isset($request->exclusive)&&$request->exclusive == 'on' ? true : false;
        unset($data['categories']);
        userActivity('Advertiser', $advertiser->id, 'update', $data, $advertiser);

        $advertiser->update($data);
        $advertiser->categories()->sync($request->categories);


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
            userActivity('Advertiser', $advertiser->id, 'delete');
            $advertiser->delete();
        }
    }
}
