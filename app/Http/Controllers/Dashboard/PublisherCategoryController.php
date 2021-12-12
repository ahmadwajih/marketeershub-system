<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\PublisherCategory;
use Illuminate\Http\Request;

class PublisherCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorize('view_publisher_ategories');
        if ($request->ajax()){
            $categories = getModelData('PublisherCategory' , $request);
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
        $this->authorize('create_publisher_categories');
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
        $this->authorize('create_publisher_categories');
        $data = $request->validate([
            'title' => 'required|unique:publisher_categories|max:255',
        ]);

        $category = PublisherCategory::create($data);
        userActivity('PublisherCategory', $category->id, 'create');

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
        $this->authorize('show_publisher_categories');
        $category = PublisherCategory::withTrashed()->findOrFail($id);
        userActivity('PublisherCategory', $category->id, 'show');
        return view('admin.advertiserCategories.show', ['category' => $category]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PublisherCategory $publisherCategory)
    {
        $this->authorize('show_publisher_categories');
        return view('admin.advertiserCategories.edit', [
            'category' => $publisherCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PublisherCategory $publisherCategory)
    {
        $this->authorize('update_publisher_categories');
        $data = $request->validate([
            'title' => 'required|max:255|unique:advertiser_categories,title,'.$publisherCategory->id,
        ]);
       
        $publisherCategory->update($data);
        userActivity('PublisherCategory', $publisherCategory->id, 'update');

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
    public function destroy(Request $request, PublisherCategory $category)
    {
        $this->authorize('delete_publisher_categories');
        if($request->ajax()){
            userActivity('PublisherCategory', $category->id, 'delete');
            $category->delete();
        }
    }
}