<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\PublishersImport;
use App\Imports\PublishersUpdateHasofferIdByEmail;
use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\SocialMediaLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

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
            $users = getModelData('User' , $request, ['parent','socialMediaLinks', 'offers'], array(
                ['position', '=', 'publisher'],
                ['team', '=', $type],
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
    public function sort(Request $request, $sort)
    {
        /*
         $offers = Offer::whereHas('users', function($q) use($childrens) {
            $q->whereIn('user_id', $childrens);
        })->with(['users' => function($q) use($childrens){
            $q->whereIn('users.id', $childrens);
        },
        'coupons' => function($q) use($childrens){
            $q->whereIn('coupons.user_id', $childrens);
        }])->get();
         */
        $this->authorize('view_publishers');
        if ($request->ajax()){
           
            $model = new Offer();
            $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
            $model   = $model->query();

            // Define the page and number of items per page
            $page = 1;
            $per_page = 10;

            // Get the request parameters
            $params = $request->all();
            // Set the current page
            if(isset($params['pagination']['page'])) {
                $page = $params['pagination']['page'];
            }

            // Set the number of items
            if(isset($params['pagination']['perpage'])) {
                $per_page = $params['pagination']['perpage'];
            }

            // Set the search filter
            if(isset($params['query']['generalSearch'])) {
                foreach ($columns as $column){
                    $model->orWhere($column, 'LIKE', "%" . $params['query']['generalSearch'] . "%");
                }
            }


            // Get how many items there should be
            $total = $model->count();
            $total = $model->where($where)->limit($per_page)->count();
    //            ->where($where['column'], $where['operation'], $where['value'])

            // Get the items defined by the parameters
            $results = $model->skip(($page - 1) * $per_page)
                ->where($where)
                ->take($per_page)->orderBy('id', 'DESC')
                ->get();


            $response = [
                'meta' => [
                    "page" => $page,
                    "pages" => ceil($total / $per_page),
                    "perpage" => $per_page,
                    "total" => $total,
                    "sort" => $order_sort,
                    "field" => $order_field
                ],
                
                'data' => $model->with($relations)->where($where)->orderBy('id', 'ASC')->get()
            ];

            return response()->json($response);
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
            'categories' => Category::all(),
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
            'name'                      => 'required|max:255',
            'email'                     => 'required|unique:users|max:255',
            'phone'                     => 'required|unique:users|max:255',
            'password'                  => 'required|min:6',
            'parent_id'                 => 'required|numeric|exists:users,id',
            'country_id'                => 'required|exists:countries,id',
            'city_id'                   => 'required|exists:cities,id',
            'gender'                    => 'required|in:male,female',
            'status'                    => 'required|in:active,pending,closed',
            'team'                      => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate,prepaid',
            'skype'                     => 'nullable|max:255',
            'address'                   => 'nullable|max:255',
            'category'                  => 'nullable|max:255',
            'years_of_experience'       => 'required_if:team,affiliate|nullable|numeric',
            'traffic_sources'           => 'required_if:team,affiliate|max:255',
            'affiliate_networks'        => 'required_if:team,affiliate|max:255',
            'owened_digital_assets'     => 'required_if:team,affiliate|max:255',
            'account_title'             => 'required|max:255',
            'bank_name'                 => 'required|max:255',
            'bank_branch_code'          => 'required|max:255',
            'swift_code'                => 'required|max:255',
            'iban'                      => 'required|max:255',
            'currency'                  => 'required|max:255',
            'roles.*'                   => 'exists:roles,id',
            'image'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',


        ]);
        $data['password'] = Hash::make($request->password);
        $data['position'] = 'publisher';
        unset($data['roles']);
        unset($data['social_media']);
        if($request->hasFile('image')){
            $data['image'] = uploadImage($request->file('image'), "Users");
        }
        // dd($data);
        $publisher = User::create($data);
        // Store Activity 
        userActivity('User', $publisher->id, 'create');

        // Add categories
        if($request->categories){
            foreach($request->categories as $categoryId){
                $category = Category::findOrFail($categoryId);
                $publisher->assignCategory($category);
            }
        }

        // Assign Role 
        if(count($request->roles) > 0){
            foreach ($request->roles as $role_id)
            {
                $role = Role::findOrFail($role_id);
                $publisher->assignRole($role);
            }
        }

        // Store Social Media Accounts 
        if($request->team == 'influencer' || $request->team == 'prepaid'){
            if($request->social_media && count($request->social_media) > 0){
                foreach($request->social_media as $link){
                    SocialMediaLink::create([
                        'link' => $link['link'],
                        'platform' => $link['platform'],
                        'followers' => $link['followers'],
                        'user_id' => $publisher->id,
                    ]);
                }
                
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
        userActivity('User', $publisher->id, 'show');
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
        if(auth()->user()->id != $id){
            $this->authorize('update_publishers');
        }
        $publisher = User::findOrFail($id);
        return view('admin.publishers.edit', [ 
            'publisher' => $publisher,
            'countries' => Country::all(),
            'cities' => City::whereCountryId($publisher->country_id)->get(),
            'parents' => User::where('position', 'account_manager')->whereStatus('active')->get(),
            'categories' => Category::all(),
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

        if(auth()->user()->id != $id){
            $this->authorize('update_publishers');
        }

        $data = $request->validate([
            'name'                      => 'required|max:255',
            'email'                     => 'required|max:255|unique:users,email,'.$id,
            'phone'                     => 'required|max:255|unique:users,phone,'.$id,
            'password'                  => 'nullable|min:6',
            'country_id'                => 'required|exists:countries,id',
            'city_id'                   => 'required|exists:cities,id',
            'gender'                    => 'required|in:male,female',
            // 'parent_id'                 => 'required|numeric|exists:users,id',
            // 'status'                    => 'required|in:active,pending,closed',
            // 'roles.*'                   => 'exists:roles,id',
            // 'team'                      => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate,prepaid',
            'skype'                     => 'nullable|max:255',
            'address'                   => 'nullable|max:255',
            'category'                  => 'nullable|max:255',
            'years_of_experience'       => 'required_if:team,affiliate|numeric',
            'traffic_sources'           => 'required_if:team,affiliate|max:255',
            'affiliate_networks'        => 'required_if:team,affiliate|max:255',
            'owened_digital_assets'     => 'required_if:team,affiliate|max:255',
            'account_title'             => 'required|max:255',
            'bank_name'                 => 'required|max:255',
            'bank_branch_code'          => 'required|max:255',
            'swift_code'                => 'required|max:255',
            'iban'                      => 'required|max:255',
            'currency'                  => 'required|max:255',
            'categories'                => 'array|required|exists:categories,id',
            'image'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',


        ]);

        unset($data['password']);
        unset($data['roles']);
        unset($data['social_media']);
        unset($data['categories']);

        if($request->password){
            $data['password'] = Hash::make($request->password);
        }

        $publisher = User::findOrFail($id);

        // Update Image 
        $data['image'] = $publisher->image;
        if($request->has("image")){
            Storage::disk('public')->delete('Images/Users/'.$publisher->image);
            $image = time().rand(11111,99999).'.'.$request->image->extension();
            $request->image->storeAs('Images/Users/',$image, 'public');
            $data['image'] = $image;
        }

        if($publisher->socialMediaLinks){
            $publisher->socialMediaLinks()->delete();
        }
        $publisher->update($data);
        userActivity('User', $publisher->id, 'update');
<<<<<<< Updated upstream
        // Unasign categories 
=======

        // Unasign categories
>>>>>>> Stashed changes
        $publisher->categories()->detach();
        // Assign Categories
        foreach($request->categories as $categoryId){
            $category = Category::findOrFail($categoryId);
            $publisher->assignCategory($category);
        }

        // Asign Role 
        if($request['roles']){
            $publisher->roles()->detach();
            foreach ($request['roles'] as $role_id)
            {
                $role = Role::findOrFail($role_id);
                $publisher->assignRole($role);
            }
        }

        if($request->team == 'influencer' || $request->team == 'prepaid'){
            if($request->social_media && count($request->social_media) > 0){
                foreach($request->social_media as $link){
                    SocialMediaLink::create([
                        'link' => $link['link'],
                        'platform' => $link['platform'],
                        'followers' => $link['followers'],
                        'user_id' => $publisher->id,
                    ]);
                }
                
            }
        }
        

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        if(auth()->user()->id == $id){
            return redirect()->route('admin.publisher.profile');
        }
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
            userActivity('User', $publisher->id, 'delete');
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
        $publisher = auth()->user();
        $userId  = auth()->user()->id;
        $childrens = auth()->user()->childrens()->pluck('id')->toArray();
        array_push($childrens, $userId);

        $offers = Offer::whereHas('users', function($q) use($childrens) {
            $q->whereIn('user_id', $childrens);
        })->with(['users' => function($q) use($childrens){
            $q->whereIn('users.id', $childrens);
        },
        'coupons' => function($q) use($childrens){
            $q->whereIn('coupons.user_id', $childrens);
        }])->get();
        $pendingTotalOrders = 0;
        $pendingTotalSales = 0;
        $pendingTotalPayout = 0;
        $totalOrders = 0;
        $totalSales = 0;
        $totalPayout = 0;
        foreach($offers as $offer){
            foreach($offer->coupons as $coupon){
                if($coupon->report){
                    $pendingTotalOrders += $coupon->report->orders;
                    $pendingTotalSales += $coupon->report->sales;
                    $pendingTotalPayout += $coupon->report->payout;
                    $totalOrders += $coupon->report->v_orders;
                    $totalSales += $coupon->report->v_sales;
                    $totalPayout += $coupon->report->v_payout;
                }
            }
        }
        return view('admin.publishers.profile', [
            'publisher' => $publisher,
            'offers' => $offers,
            'pendingTotalOrders' => $pendingTotalOrders,
            'pendingTotalSales' => $pendingTotalSales,
            'pendingTotalPayout' => $pendingTotalPayout,
            'totalOrders' => $totalOrders,
            'totalSales' => $totalSales,
            'totalPayout' => $totalPayout,
        ]);
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
        userActivity('User', null , 'upload', 'Upload Publishers');
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
        userActivity('User', null , 'upload', 'Upload and Update HasOffer Id ByEmail');
        $notification = [
            'message' => 'Uploaded successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.publishers.index');
    }

}
