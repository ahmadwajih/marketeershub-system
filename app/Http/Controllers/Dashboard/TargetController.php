<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_targets');
        if ($request->ajax()){
            $targets = getModelData('Country' , $request);
            return response()->json($targets);
        }
        return view('admin.targets.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_targets');
        return view('admin.targets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
        $this->authorize('create_targets');
        $data = $request->validate([
            'name_en' => 'required|unique:targets|max:255',
            'name_ar' => 'required|unique:targets|max:255',
            'code'    => 'required|max:20'
        ]);

        $country = Country::create($data);
        userActivity('Country', $country->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.targets.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view_targets');
        $country = Country::findOrFail($id);
        userActivity('Country', $country->id, 'show');
        return view('admin.targets.show', ['country' => $country]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        $this->authorize('view_targets');
        return view('admin.targets.edit', [
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
        $this->authorize('update_targets');
        $data = $request->validate([
            'name_ar' => 'required|max:255|unique:targets,name_ar,'.$country->id,
            'name_en' => 'required|max:255|unique:targets,name_en,'.$country->id,    
            'code'    => 'required|max:20'
        ]);
        userActivity('Country', $country->id, 'update', $data, $country);
       
        $country->update($data);

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.targets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Country $country)
    {
        $this->authorize('delete_targets');
        if($request->ajax()){
            userActivity('Country', $country->id, 'delete');
            $country->delete();
        }
    }
}

