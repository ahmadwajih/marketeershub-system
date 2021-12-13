<?php


namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
            $categories = getModelData('Category' , $request);
            return response()->json($categories);
        }
        return view('admin.categories.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_categories');
        return view('admin.categories.create');
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
            'title_en' => 'required|unique:categories|max:255',
            'title_ar' => 'required|unique:categories|max:255',
            'type'     => 'required|in:advertisers,publishers,offers,other'
        ]);

        $category = Category::create($data);
        userActivity('Category', $category->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.categories.index');
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
        $category = Category::withTrashed()->findOrFail($id);
        userActivity('Category', $category->id, 'show');
        return view('admin.categories.show', ['category' => $category]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('show_categories');
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update_categories');
        $data = $request->validate([
            'title_ar' => 'required|max:255|unique:categories,title_ar,'.$category->id,
            'title_en' => 'required|max:255|unique:categories,title_en,'.$category->id,    
            'type'     => 'required|in:advertisers,publishers,offers,other'
        ]);
        userActivity('Category', $category->id, 'update', $data, $category);
       
        $category->update($data);

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        $this->authorize('delete_categories');
        if($request->ajax()){
            userActivity('Category', $category->id, 'delete');
            $category->delete();
        }
    }
}

