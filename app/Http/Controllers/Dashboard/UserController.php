<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
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
            $users = getModelData('User' , $request, ['parent']);
            return response()->json($users);
        }
        return view('dashboard.users.index');
    }
    
    /**
     * return list of cities based on country id
     *
     * @return \Illuminate\Http\Response
     */
    public function getCitiesBasedOnCountryAjax(Request $request)
    {
        // $this->authorize('view_cities') ?: abort(401);
        if ($request->ajax()){
            $cities = City::where('country_id', $request->countryId)->get();
            return view('dashboard.users.cities', ['cities' => $cities]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_users');
        return view('dashboard.users.create',[
            'countries' => Country::all(),
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
            'email'                 => 'required|unique:users|max:255',
            'phone'                 => 'required|unique:users|max:255',
            'password'              => 'required|min:6',
            'years_of_experience'   => 'required|numeric',
            'parent_id'             => 'required|exists:users,id',
            'country_id'            => 'required|exists:countries,id',
            'city_id'               => 'required|exists:cities,id',
            'gender'                => 'required|in:male,female',
            'status'                => 'required|in:active,pending,closed',
            'team'                  => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate',
            'position'              => 'required|in:super_admin,head,team_leader,account_manager,publisher,employee'
        ]);

        $data['password'] = Hash::make($request->password);
        User::create($data);

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('dashboard.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
