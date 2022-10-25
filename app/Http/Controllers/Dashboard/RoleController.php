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
        'targets',
        'payments',
        'helps'
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_roles');

        return view('new_admin.roles.index', [
            'roles' => Role::with(['users', 'abilities'])->get(),
            'models' => $this->models,
            'abilities'=> Ability::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_roles');

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
        $this->authorize('create_roles');

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
            return response()->json($role, 200);

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
        $this->authorize('view_roles');

        $role = Role::withTrashed()->findOrFail($id);
        return view('new_admin.roles.show',[
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
        $this->authorize('update_roles');
        return view('new_admin.roles.edit',[
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
    public function update(Request $request)
    {
        $this->authorize('update_roles');
        $role = Role::findOrFail($request->id);
        $abilities = Ability::get();
        foreach($abilities as $ability){
            if (request($ability->name) == "on" && !$role->abilities->contains($ability)){
                $role->allowTo($ability);
            }elseif(!isset($request[$ability->name]) && $role->abilities->contains($ability)){
                $role->disallowTo($ability);
            }

        }
        $role->save();
        userActivity('Role', $role->id, 'update');

        $notification = array(
            'message' => 'Updated Succefuly ',
            'alert-type' => 'success'
        );
        return response()->json($role, 200);
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
        $this->authorize('delete_roles');

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
