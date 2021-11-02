<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\PublishersImport;
use App\Imports\PublishersUpdateHasofferIdByEmail;
use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_publishers');
        if ($request->ajax()){
            $users = getModelData('User' , $request, ['parent'], array(
                ['position', '=', 'publisher']
            ));
            return response()->json($users);
        }
        return view('admin.publishers.index');
    }


    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBasedOnType(Request $request, $type)
    {
        $this->authorize('view_publishers');
        if ($request->ajax()){
            $users = getModelData('User' , $request, ['parent'], array(
                ['position', '=', 'publisher'],
                ['team', '=', $type],
            ));
            return response()->json($users);
        }
        return view('admin.publishers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_publishers');
        return view('admin.publishers.create',[
            'countries' => Country::all(),
            'roles' => Role::all(),
            'users' => User::where('position', 'account_manager')->whereStatus('active')->get(),
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
        $this->authorize('create_publishers');
        $data = $request->validate([
            'name'                  => 'required|max:255',
            'email'                 => 'required|unique:users|max:255',
            'phone'                 => 'required|unique:users|max:255',
            'password'              => 'required|min:6',
            'parent_id'             => 'required|numeric|exists:users,id',
            'years_of_experience'   => 'required|numeric',
            'country_id'            => 'required|exists:countries,id',
            'city_id'               => 'required|exists:cities,id',
            'gender'                => 'required|in:male,female',
            'status'                => 'required|in:active,pending,closed',
            'team'                  => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate',
            'skype'                 => 'nullable|max:255',
            'address'               => 'nullable|max:255',
            'category'              => 'nullable|max:255',
            'traffic_sources'       => 'nullable|max:255',
            'affiliate_networks'    => 'nullable|max:255',
            'owened_digital_assets' => 'nullable|max:255',
            'account_title'         => 'required|max:255',
            'bank_name'             => 'required|max:255',
            'bank_branch_code'      => 'required|max:255',
            'swift_code'            => 'required|max:255',
            'iban'                  => 'required|max:255',
            'currency'              => 'required|max:255',
            'roles.*'               => 'exists:roles,id',

        ]);
        $data['password'] = Hash::make($request->password);
        $data['position'] = 'publisher';
        unset($data['roles']);
        $publisher = User::create($data);
        if(count($request->roles) > 0){
            foreach ($request->roles as $role_id)
            {
                $role = Role::findOrFail($role_id);
                $publisher->assignRole($role);
            }
        }
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.publishers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show_publishers');
        $publisher = User::findOrFail($id);
        return view('admin.publishers.show', ['publisher' => $publisher]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update_publishers');
        $publisher = User::findOrFail($id);
        return view('admin.publishers.edit', [ 
            'publisher' => $publisher,
            'countries' => Country::all(),
            'cities' => City::whereCountryId($publisher->country_id)->get(),
            'parents' => User::where('position', 'account_manager')->whereStatus('active')->get(),
            'roles' => Role::all(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        

        $this->authorize('update_publishers');
        $data = $request->validate([
            'name'                  => 'required|max:255',
            'email'                 => 'required|max:255|unique:users,email,'.$id,
            'phone'                 => 'required|max:255|unique:users,phone,'.$id,
            'password'              => 'nullable|min:6',
            'parent_id'             => 'required|numeric|exists:users,id',
            'years_of_experience'   => 'required|numeric',
            'country_id'            => 'required|exists:countries,id',
            'city_id'               => 'required|exists:cities,id',
            'gender'                => 'required|in:male,female',
            'status'                => 'required|in:active,pending,closed',
            'team'                  => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate',
            'skype'                 => 'nullable|max:255',
            'address'               => 'nullable|max:255',
            'category'              => 'nullable|max:255',
            'traffic_sources'       => 'nullable|max:255',
            'affiliate_networks'    => 'nullable|max:255',
            'owened_digital_assets' => 'nullable|max:255',
            'account_title'         => 'required|max:255',
            'bank_name'             => 'required|max:255',
            'bank_branch_code'      => 'required|max:255',
            'swift_code'            => 'required|max:255',
            'iban'                  => 'required|max:255',
            'currency'              => 'required|max:255',
            'roles.*'               => 'exists:roles,id',

        ]);
        unset($data['password']);
        unset($data['roles']);
        if($request->password){
            $data['password'] = Hash::make($request->password);
        }
        $publisher = User::findOrFail($id);
        $publisher->update($data);
        if($request['roles']){
            $publisher->roles()->detach();
            foreach ($request['roles'] as $role_id)
            {
                $role = Role::findOrFail($role_id);
                $publisher->assignRole($role);
            }
        }
        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.publishers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->authorize('delete_users');
        $publisher = User::findOrFail($id);
        if($request->ajax()){
            $publisher->delete();
        }
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload()
    {
        $this->authorize('create_publishers');
        return view('admin.publishers.upload');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUpload(Request $request)
    {
        
        $this->authorize('create_publishers');
        $request->validate([
            'team'       => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate',
            'publishers' => 'required|mimes:xlsx,csv',
        ]);
        Excel::import(new PublishersImport($request->team),request()->file('publishers'));
        $notification = [
            'message' => 'Uploaded successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.publishers.index');
    }

    public function uploadUpdateHasOfferIdByEmail()
    {
        $this->authorize('update_publishers');
        return view('admin.publishers.upload_update_hasoffer_id_by_email');
    }

    public function storeUploadUpdateHasOfferIdByEmail(Request $request)
    {
        
        $this->authorize('create_publishers');
        $request->validate([
            'publishers' => 'required|mimes:xlsx,csv',
        ]);
        Excel::import(new PublishersUpdateHasofferIdByEmail(),request()->file('publishers'));
        $notification = [
            'message' => 'Uploaded successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.publishers.index');
    }


}
