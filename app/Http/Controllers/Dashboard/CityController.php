<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_cites');
        if ($request->ajax()){
            $coupons = City::with('country');
            return DataTables::of($coupons)->make(true);
        }
        return view('new_admin.cities.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_cites');
        return view('new_admin.cities.create',[
            'countries' => Country::all()
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
        $this->authorize('create_cites');
        $data = $request->validate([
            'name_en'       => 'required|unique:cities|max:255',
            'name_ar'       => 'required|unique:cities|max:255',
            'code'          => 'required|max:20',
            'country_id'    => 'required|exists:countries,id',
        ]);

        $city = City::create($data);
        userActivity('City', $city->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.cities.index')->with($notification);
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
        $this->authorize('show_cites');
        $city = City::findOrFail($id);
        userActivity('City', $city->id, 'show');
        return view('admin.cities.show', ['city' => $city]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $this->authorize('show_cites');
        return view('new_admin.cities.edit', [
            'city' => $city,
            'countries' => Country::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $this->authorize('update_cites');
        $data = $request->validate([
            'name_ar'       => 'required|max:255|unique:cities,name_ar,'.$city->id,
            'name_en'       => 'required|max:255|unique:cities,name_en,'.$city->id,    
            'code'          => 'required|max:20',
            'country_id'    => 'required|exists:countries,id',

        ]);
        userActivity('City', $city->id, 'update', $data, $city);
       
        $city->update($data);

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.cities.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, City $city)
    {
        $this->authorize('delete_cites');
        if($request->ajax()){
            userActivity('City', $city->id, 'delete');
            $city->delete();
        }
    }
}

