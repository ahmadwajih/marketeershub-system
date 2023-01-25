<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_countries');
        if ($request->ajax()){
            $coupons = Country::with('cities');
            return DataTables::of($coupons)->make(true);
            // $countries = getModelData('Country' , $request);
            // return response()->json($countries);
        }
        return view('new_admin.countries.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_countries');
        return view('new_admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_countries');
        $data = $request->validate([
            'name_en' => 'required|max:255|unique:countries',
            'name_ar' => 'required|max:255|unique:countries',
            'code'    => 'required|max:20'
        ]);

        $country = Country::create($data);
        userActivity('Country', $country->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.countries.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
        $this->authorize('view_countries');
        $country = Country::findOrFail($id);
        userActivity('Country', $country->id, 'show');
        return view('admin.countries.show', ['country' => $country]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        $this->authorize('view_countries');
        return view('new_admin.countries.edit', [
            'country' => $country
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $this->authorize('update_countries');
        $data = $request->validate([
            'name_ar' => 'required|max:255|unique:countries,name_ar,'.$country->id,
            'name_en' => 'required|max:255|unique:countries,name_en,'.$country->id,    
            'code'    => 'required|max:20'
        ]);
        userActivity('Country', $country->id, 'update', $data, $country);
       
        $country->update($data);

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.countries.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Country $country)
    {
        $this->authorize('delete_countries');
        if($request->ajax()){
            userActivity('Country', $country->id, 'delete');
            $country->forceDelete();
        }
    }
}

