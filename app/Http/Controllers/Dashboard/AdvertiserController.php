<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Advertiser;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
            $advertisers = Advertiser::all();
            return DataTables::of($advertisers)->make(true);
        }
        return view('new_admin.advertisers.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_advertisers');
        return view('new_admin.advertisers.create',[
            'countries' => Country::all(),
            'cities' => City::all(),
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
            'phone'                 => 'nullable|numeric|min:1',
            'email'                 => 'nullable|max:255|email:rfc,filter',
            'ho_user_id'            => 'nullable|max:255',
            'company_name_en'       => 'required|max:255',
            'website'               => 'nullable|max:255',
            'categories'            => 'array|required|exists:categories,id',
            'country_id'            => 'required|max:255|exists:countries,id',
            'currency_id'           => 'required|max:255|exists:currencies,id',
            'address'               => 'nullable|max:255',
            'validation_duration'   => 'nullable|max:255',
            'status'                => 'required|in:active,inactive',
            'validation_source'     => 'nullable|max:255',
            'validation_type'       => 'required|in:system,sheet,manual_report_via_email',
            'language'              => 'required|in:ar,en,ar_en',
            'access_username'       => 'nullable|max:255',
            'access_password'       => 'nullable|max:255',
            'contract'              => 'nullable|file|mimetypes:application/pdf|max:1024',
            'nda'                   => 'nullable|file|mimetypes:application/pdf|max:1024',
            'io'                    => 'nullable|file|mimetypes:application/pdf|max:1024',
        ]);

        $data['exclusive'] = isset($request->exclusive)&&$request->exclusive == 'on' ? true : false;
        $data['broker'] = isset($request->broker)&&$request->broker == 'on' ? true : false;
        unset($data['categories']);
        unset($data['contract']);
        unset($data['nda']);
        unset($data['io']);

        if($request->hasFile('contract')){
            $data['contract'] = uploadImage($request->file('contract'), "Advertisers");
        }
        if($request->hasFile('nda')){
            $data['nda'] = uploadImage($request->file('nda'), "Advertisers");
        }
        if($request->hasFile('io')){
            $data['io'] = uploadImage($request->file('io'), "Advertisers");
        }

        $advertiser = Advertiser::create($data);
        $advertiser->categories()->attach($request->categories);
        userActivity('Advertiser', $advertiser->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.advertisers.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view_advertisers');
        $advertiser = Advertiser::withTrashed()->findOrFail($id);
        userActivity('Advertiser', $advertiser->id, 'show');
        return view('new_admin.advertisers.show', ['advertiser' => $advertiser]);
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

        return view('new_admin.advertisers.edit', [
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
            'phone'                 => 'nullable|numeric|min:1',
            'email'                 => 'nullable|max:255|email:rfc,filter',
            'ho_user_id'            => 'nullable|max:255',
            'company_name_en'       => 'required|max:255',
            'website'               => 'nullable|max:255',
            'categories'            => 'array|required|exists:categories,id',
            'country_id'            => 'required|max:255|exists:countries,id',
            'currency_id'           => 'required|max:255|exists:currencies,id',
            'address'               => 'nullable|max:255',
            'validation_duration'   => 'nullable|max:255',
            'status'                => 'required|in:active,inactive',
            'validation_source'     => 'nullable|max:255',
            'validation_type'       => 'required|in:system,sheet,manual_report_via_email',
            'language'              => 'required|in:ar,en,ar_en',
            'access_username'       => 'nullable|max:255',
            'access_password'       => 'nullable|max:255',
            'contract'              => 'nullable|file|mimetypes:application/pdf|max:1024',
            'nda'                   => 'nullable|file|mimetypes:application/pdf|max:1024',
            'io'                    => 'nullable|file|mimetypes:application/pdf|max:1024',
        ]);

        $data['exclusive'] = isset($request->exclusive)&&$request->exclusive == 'on' ? true : false;
        $data['broker'] = isset($request->broker)&&$request->broker == 'on' ? true : false;
        unset($data['categories']);
        unset($data['contract']);
        unset($data['nda']);
        unset($data['io']);

        if($request->hasFile('contract')){
            deleteImage($advertiser->contract, "Advertisers");
            $data['contract'] = uploadImage($request->file('contract'), "Advertisers");
        }
        if($request->hasFile('nda')){
            deleteImage($advertiser->nda, "Advertisers");
            $data['nda'] = uploadImage($request->file('nda'), "Advertisers");
        }
        if($request->hasFile('io')){
            deleteImage($advertiser->contract, "Advertisers");
            $data['io'] = uploadImage($request->file('io'), "Advertisers");
        }

        userActivity('Advertiser', $advertiser->id, 'update', $data, $advertiser);


        $advertiser->update($data);
        $advertiser->categories()->sync($request->categories);


        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.advertisers.index')->with($notification);
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

    public function changeStatus(Request $request){
        $this->authorize('update_advertisers');

        $advertiser = Advertiser::findOrFail($request->id);
        $advertiser->status = $request->status == 'active' ? 'active' : 'inactive';
        $advertiser->save();
        return response()->json(['message' => 'Updated Succefuly']);
    }

}
