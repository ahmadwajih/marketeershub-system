<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_users');
        if ($request->ajax()){
            $users = getModelData('User' , $request, ['parent','country'], array(
                ['position', '!=', 'publisher']
            ));
            return response()->json($users);
        }
        return view('admin.users.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_users');
        return view('admin.users.create',[
            'countries' => Country::all(),
            'roles' => Role::all(),
            'users' => User::whereIn('position', ['super_admin','head','team_leader', 'account_manager'])->whereStatus('active')->get(),
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
        $this->authorize('create_users');
        $data = $request->validate([
            'name'                  => 'required|max:255',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'email'                 => 'required|unique:users|max:255',
            'phone'                 => 'required|unique:users|max:255',
            'password'              => ['required','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'years_of_experience'   => 'required|numeric',
            'country_id'            => 'required|exists:countries,id',
            'city_id'               => 'required|exists:cities,id',
            'gender'                => 'required|in:male,female',
            'status'                => 'required|in:active,pending,closed',
            'team'                  => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate',
            'position'              => 'required|in:super_admin,head,team_leader,account_manager,publisher,employee',
            'roles.*'               => 'exists:roles,id',

        ]);

        if($request->hasFile('image')){
            $data['image'] = uploadImage($request->file('image'), "Users");
        }

        $data['password'] = Hash::make($request->password);
        unset($data['roles']);
        $user = User::create($data);
        if(count($request->roles) > 0){
            foreach ($request->roles as $role_id)
            {
                $role = Role::findOrFail($role_id);
                $user->assignRole($role);
            }
        }
        userActivity('User', $user->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show_users');
        $user = User::withTrashed()->findOrFail($id);
        userActivity('User', $user->id, 'show');
        $activites = getActivity('User',$id );
        return view('admin.users.show', ['user' => $user, 'activites' => $activites]);
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update_users');
        return view('admin.users.edit', [ 
            'user' => $user,
            'countries' => Country::all(),
            'roles' => Role::all(),
            'cities' => City::whereCountryId($user->country_id)->get(),
            'parents' => User::whereIn('position', ['super_admin','head','team_leader', 'account_manager'])->whereStatus('active')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update_users');
        $data = $request->validate([
            'ho_id'                 => 'nullable|max:255|unique:users,ho_id,'.$user->id,
            'name'                  => 'required|max:255',
            'email'                 => 'required|max:255|unique:users,email,'.$user->id,
            'phone'                 => 'required|max:255|unique:users,phone,'.$user->id,
            'password'              => ['nullable','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'years_of_experience'   => 'required|numeric',
            'country_id'            => 'required|exists:countries,id',
            'city_id'               => 'required|exists:cities,id',
            'gender'                => 'required|in:male,female',
            'status'                => 'required|in:active,pending,closed',
            'team'                  => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate',
            'position'              => 'required|in:super_admin,head,team_leader,account_manager,publisher,employee',
            'roles.*'               => 'exists:roles,id',
        ]);
        if($request->hasFile('image')){
            deleteImage($user->image, 'Users');
            $data['image'] = uploadImage($request->file('image'), "Users");
        }
        unset($data['password']);
        if($request->password){
            $data['password'] = Hash::make($request->password);
        }
            
        unset($data['roles']);
        $user->update($data);
        if($request['roles']){
            $user->roles()->detach();
            foreach ($request['roles'] as $role_id)
            {
                $role = Role::findOrFail($role_id);
                $user->assignRole($role);
            }
        }
        userActivity('User', $user->id, 'update');

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($notification);
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete_users');
        if($request->ajax()){
            userActivity('User', $user->id, 'delete');
            $user->delete();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = auth()->user();
        return view('admin.users.profile', ['user' => $user]);
    }
}
