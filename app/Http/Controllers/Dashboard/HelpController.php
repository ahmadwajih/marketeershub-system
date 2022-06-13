<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Help;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view_helps');

        $helps = Help::get();
        return view('admin.helps.index', ['helps' => $helps]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_helps');
        return view('admin.helps.create');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_helps');

        $data = $request->validate([
            'title' => 'required|max:200',
            'content' => 'required',
        ]);

        Help::create($data);
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.helps.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Help $help)
    {
        $this->authorize('update_helps');
        return view('admin.helps.edit', ['help' => $help]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Help $help)
    {
        $this->authorize('update_helps');

        $data = $request->validate([
            'title' => 'required|max:200',
            'content' => 'required',
        ]);

        $help->title = $request->title;
        $help->content = $request->content;
        $help->save();

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.helps.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Help $help)
    {
        $this->authorize('delete_helps');

        if($request->ajax()){
            $help->delete();
            return response()->json(true, 200);
        }
    }

    public function uploadImages(Request $request){
        $imageName = uploadImage($request->upload, 'Helps');
        return response()->json(['url' => getImagesPath('Helps', $imageName)], 200);
    }

    public function search(Request $request){
        $this->authorize('view_helps');
        if(is_null($request->search)){
            $helps = Help::all();

        }else{
            $search = $request->search;
            $helps = Help::query()
                        ->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('content', 'LIKE', "%{$search}%")
                        ->get();
        }
        
        return view('admin.helps.search', ['helps' => $helps]);
    }
}
