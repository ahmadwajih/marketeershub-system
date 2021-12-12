<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AdvertiserCategory;
use Illuminate\Http\Request;

class AdvertiserCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorize('view_categories');
        if ($request->ajax()){
            $categories = getModelData('AdvertiserCategory' , $request);
            return response()->json($categories);
        }
        return view('admin.advertiserCategories.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_categories');
        return view('admin.advertiserCategories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_categories');
        $data = $request->validate([
            'title' => 'required|unique:advertiser_categories|max:255',
        ]);

        $category = AdvertiserCategory::create($data);
        userActivity('AdvertiserCategory', $category->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.advertiserCategories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show_categories');
        $category = AdvertiserCategory::withTrashed()->findOrFail($id);
        userActivity('AdvertiserCategory', $category->id, 'show');
        return view('admin.advertiserCategories.show', ['category' => $category]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(AdvertiserCategory $advertiserCategory)
    {
        $this->authorize('show_categories');
        return view('admin.advertiserCategories.edit', [
            'category' => $advertiserCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdvertiserCategory $advertiserCategory)
    {
        $this->authorize('update_categories');
        $data = $request->validate([
            'title' => 'required|max:255|unique:advertiser_categories,title,'.$advertiserCategory->id,
        ]);
       
        $advertiserCategory->update($data);
        userActivity('AdvertiserCategory', $advertiserCategory->id, 'update');

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.advertiserCategories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AdvertiserCategory $category)
    {
        $this->authorize('delete_categories');
        if($request->ajax()){
            userActivity('AdvertiserCategory', $category->id, 'delete');
            $category->delete();
        }
    }
}