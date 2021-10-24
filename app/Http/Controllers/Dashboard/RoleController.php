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
        'offerRequests',
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
        return view('dashboard.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.roles.create',[
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
            $notification = array(
                'message' => 'Created Succefuly ',
                'alert-type' => 'success'
            );
            return redirect()->route('dashboard.roles.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('dashboard.roles.show',[
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
        return view('dashboard.roles.edit',[
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
        $notification = array(
            'message' => 'Updated Succefuly ',
            'alert-type' => 'success'
        );
        return redirect()->route('dashboard.roles.index')->with($notification);
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
            if($id != 1){
                $role = Role::find($id);
                $role->destroy($id);
            }
            
        }
    }
}
