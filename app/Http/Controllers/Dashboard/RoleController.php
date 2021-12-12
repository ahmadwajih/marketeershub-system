<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ability;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public $models = [
        'reports',
        'offer_requests',
        'advertisers',
        'offers',
        'coupons',
        'categories',
        'publishers',
        'pivot_report',
        'countries',
        'cites',
        'users',
        'roles',
        'currencies',
        'user_activities',

    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $roles = getModelData('Role', $request);
            return response()->json($roles);
        }
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create',[
            'models' => $this->models,
            'abilities'=> Ability::all(),
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
        $role = Role::create(
            $this->validate($request, [
                'name' => 'required|string|unique:roles',
            ]));
    
            $abilities = Ability::get();
            foreach($abilities as $ability){
                if (request($ability->name) == "on"){
                    $role->allowTo($ability);
                }
            }
            userActivity('Role', $role->id, 'create');

            $notification = array(
                'message' => 'Created Succefuly ',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.roles.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::withTrashed()->findOrFail($id);
        return view('admin.roles.show',[
            'role' => $role,
            'models' => $this->models,
            'abilities'=> Ability::get(),
            'abilitiy_role'=> $role->abilities
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {

        return view('admin.roles.edit',[
            'role' => $role,
            'models' => $this->models,
            'abilities'=> Ability::get(),
            'abilitiy_role'=> $role->abilities
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $abilities = Ability::get();
        foreach($abilities as $ability){
            if (request($ability->name) == "on" && !$role->abilities->contains($ability)){
                $role->allowTo($ability);
            }elseif (!isset($request[$ability->name]) && $role->abilities->contains($ability)){
                $role->disallowTo($ability);
            }

        }
        $role->save();
        userActivity('Role', $role->id, 'update');

        $notification = array(
            'message' => 'Updated Succefuly ',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.roles.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->ajax())
        {
            userActivity('Role', $id, 'delete');
            if($id != 1){
                $role = Role::find($id);
                $role->destroy($id);
            }
            
        }
    }
}
