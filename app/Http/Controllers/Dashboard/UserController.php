<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

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
            if(in_array('super_admin',   auth()->user()->roles->pluck('label')->toArray())){
                $users = User::with('parent')->where([
                    ['position', '!=', 'publisher']
                ]);
            }else{
                $users = User::with('parent')->where([
                    ['position', '!=', 'publisher'],
                    ['parent_id', '=', auth()->user()->id],
                ]);
            }
            return DataTables::of($users)->make(true);
        }
        return view('new_admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_users');
        return view('new_admin.users.create',[
            'countries' => Country::all(),
            'cities' => City::all(),
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
            'email'                 => 'required|unique:users|max:255|email:rfc,filter',
            'phone'                 => 'required|unique:users|max:255',
            'password'              => ['required', 'confirmed','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'parent_id'             => 'nullable|exists:users,id|nullable',
            'country_id'            => 'required|exists:countries,id',
            'gender'                => 'required|in:male,female',
            'team'                  => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate',
            'roles.*'               => 'exists:roles,id',

        ]);

        if($request->hasFile('image')){
            $data['image'] = uploadImage($request->file('image'), "Users");
        }

        $data['password'] = Hash::make($request->password);
        unset($data['roles']);
        $data['account_status'] = 'approved';
        $data['status'] = 'active';
        $data['position'] = 'employee';
        $user = User::create($data);
        $user->roles()->sync($request->roles);
        userActivity('User', $user->id, 'create');

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        $notification = [
            'message' => 'User Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.users.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(auth()->user()->id != $id || !in_array($id, auth()->user()->childrens()->pluck('id')->toArray())){
            $this->authorize('view_users');
        }
        $user = User::findOrFail($id);
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
        $childrens = userChildrens();
        $childrens[] =  auth()->user()->id;

        if(!in_array($user->id, $childrens)){
            $this->authorize('update_users');
        }

        return view('new_admin.users.edit', [
            'user' => $user,
            'countries' => Country::all(),
            'roles' => Role::all(),
            'cities' => City::whereCountryId($user->country_id)->get(),
            'parents' => User::whereIn('position', ['super_admin','head','team_leader', 'account_manager'])->whereStatus('active')->get(),
            'users' => User::whereIn('position', ['super_admin','head','team_leader', 'account_manager'])->whereStatus('active')->get(),
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
        $childrens = userChildrens();
        $childrens[] =  auth()->user()->id;

        if(!in_array($user->id, $childrens)){
            $this->authorize('update_users');
        }
        $data = $request->validate([
            'ho_id'                 => 'nullable|max:255',
            'parent_id'             => 'nullable|exists:users,id|nullable',
            'name'                  => 'required|max:255',
            'email'                 => 'required|email:rfc,filter|max:255|unique:users,email,'.$user->id,
            'phone'                 => 'required|max:255|unique:users,phone,'.$user->id,
            'password'              => ['nullable', 'confirmed', 'min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'],
            'country_id'            => 'required|exists:countries,id',
            'gender'                => 'required|in:male,female',
            'team'                  => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate',
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
        userActivity('User', $user->id, 'update', $data, $user);
        $user->update($data);
        if($request['roles']){
            $user->roles()->detach();
            foreach ($request['roles'] as $role_id)
            {
                $role = Role::findOrFail($role_id);
                $user->assignRole($role);
            }
        }
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
            if(count($user->childrens()->pluck('id')->toArray()) > 0){
                return response()->json(['message'=>  __('You can`t delete the user '.$user->name.' because he have ')  .  count($user->childrens()->pluck('id')->toArray()) . __(' child')], 422);
            }
            userActivity('User', $user->id, 'delete');
            $user->forceDelete();
            return true;
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
        return view('new_admin.users.profile', ['user' => $user]);
    }

    public function changeStatus(Request $request){
        $this->authorize('update_users');

        $user = User::findOrFail($request->id);
        $user->status = $request->status == 'active' ? 'active' : 'closed';
        $user->save();
        return response()->json(['message' => 'Updated Succefuly']);
    }
}
