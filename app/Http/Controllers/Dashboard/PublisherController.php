<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        return view('dashboard.publishers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_publishers');
        return view('dashboard.publishers.create',[
            'countries' => Country::all(),
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
        /*
        
        */
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
        ]);

        $data['password'] = Hash::make($request->password);
        $data['position'] = 'publisher';
        User::create($data);

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('dashboard.publishers.index');
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
        return view('dashboard.publishers.show', ['publisher' => $publisher]);
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
