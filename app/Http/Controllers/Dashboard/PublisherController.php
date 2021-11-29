<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Imports\PublishersImport;
use App\Imports\PublishersUpdateHasofferIdByEmail;
use App\Models\City;
use App\Models\Country;
use App\Models\Offer;
use App\Models\Role;
use App\Models\SocialMediaLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

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
        if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
            $publishers = User::wherePosition('publisher')->with('parent', 'categories')->where('parent_id', auth()->user()->id)->orWhere('parent_id', null)->get();
        }else{
            $publishers = User::wherePosition('publisher')->with('parent', 'categories')->get();
        }
        $categories = Category::all();
        $accountManagers = User::wherePosition('account_manager')->get();
        return view('admin.publishers.index', [
            'categories' => $categories,
            'accountManagers' => $accountManagers,
            'publishers' => $publishers,
        ]);
    }


    public function dashboard(){
       // $this->authorize('view_publishers');
       // userActivity('User', $publisher->id, 'show');
        $publisher = User::findOrFail(Auth::user()->id);
        return view('admin.publishers.new.dashboard', ['publisher' => $publisher]);
    }

    public function offers() {
        $offers = Offer::paginate();
        return view('admin.publishers.new.offers', ['offers' => $offers]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBasedOnType(Request $request, $type)
    {
        $this->authorize('view_publishers');
        $publishers = User::wherePosition('publisher')->where([
            ['position', '=', 'publisher'],
            ['team', '=', $type],
        ])->with('parent', 'categories')->get();
        $categories = Category::all();
        $accountManagers = User::wherePosition('account_manager')->get();
        return view('admin.publishers.index', [
            'categories' => $categories,
            'accountManagers' => $accountManagers,
            'publishers' => $publishers,
        ]);
        return view('admin.publishers.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $this->authorize('view_publishers');
        $publishers = User::query();
        $where = [['id', '!=', 0]];
        // Check  pased on status
        if($request->status){
            $where[] = ['status', '=', $request->status];
        }
        if($request->team){
            $where[] = ['team', '=', $request->team];
        }

        // check based on category
        if($request->category_id){
            $publishers = $publishers->whereHas('categories', function($q) use($request) {
                $q->whereIn('category_id', [$request->category_id]);
            });
        }

        // check based on account manager 
        if($request->account_manager_id){
            if($request->account_manager_id == 'unassigned'){
                $where[] = ['parent_id', '=', null];

            }else{
                $where[] = ['parent_id', '=', $request->account_manager_id];

            }
        }
        $publishers = $publishers->with('parent')->where($where)->get();

        $categories = Category::all();
        $accountManagers = User::wherePosition('account_manager')->get();
        $data = $request->all();
        $data['categories'] = $categories;
        $data['accountManagers'] = $accountManagers;
        $data['publishers'] = $publishers;
        // dd($data);
        return view('admin.publishers.index', $data);
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
            'referral_account_manager'  => 'nullable|max:255',
            'account_title'             => 'required|max:255',
            'bank_name'                 => 'required|max:255',
            'bank_branch_code'          => 'required|max:255',
            'swift_code'                => 'required|max:255',
            'iban'                      => 'required|max:255',
            'currency'                  => 'required|max:255',
            'image'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',


        ]);
        $data['password'] = Hash::make($request->password);
        $data['position'] = 'publisher';
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


            $role = Role::findOrFail(4);
            $publisher->assignRole($role);

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
        dd($publisher->socialLinks);
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
            'parent_id'                 => 'nullable|numeric|exists:users,id',
            'status'                    => 'nullable|in:active,pending,closed',
            'team'                      => 'nullable|in:management,digital_operation,finance,media_buying,influencer,affiliate,prepaid',
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
        // Unasign categories 
        $publisher->categories()->detach();
        // Assign Categories
        foreach($request->categories as $categoryId){
            $category = Category::findOrFail($categoryId);
            $publisher->assignCategory($category);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAccountManager(Request $request)
    {
        $publisher = User::whereId($request->affiliateId)->first();
        if($publisher){
            $publisher->parent_id = auth()->user()->id;
            $publisher->save();
            return response()->json([
                'code' => 200,
                'message' => 'Updated',
            ], 200);

        }
        return response()->json([
            'code'      =>  401,
            'message'   =>  __('Affiliate Dose not exists')
        ], 404);
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
    /** 
     * Show account manager details.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function myAccountManager(){
        if(auth()->user()->parent){
            $accountManager = auth()->user()->parent;
            return view('admin.publishers.myAccountManager', [
                'accountManager' => $accountManager,
            ]);
        }
        return redirect()->withErrors(['message' => __('You do not have account manager')]);
    }

    

}
