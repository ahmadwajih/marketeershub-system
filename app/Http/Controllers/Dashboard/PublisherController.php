<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Extended\MhDataTables;
use App\Imports\InfluencerImport;
use App\Imports\PublisherImportV2;
use App\Imports\PublishersImport;
use App\Imports\PublishersUpdateHasofferIdByEmail;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\DigitalAsset;
use App\Models\Offer;
use App\Models\Payment;
use App\Models\Role;
use App\Models\SocialMediaLink;
use App\Models\User;
use App\Models\Coupon;
use App\Notifications\PublisherNeedToUpdateHisInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Matrix\Exception;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Notification;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view_publishers');
        $where = [
            ['users.id', '!=', null]
        ];
        $sortBy = 'id';
        $sortType = 'desc';

        if(isset($request->team) && $request->team != null){
            $where[] = ['users.team', '=', $request->team];
        }
        if(isset($request->account_manager) && $request->account_manager != null){
            $where[] = ['users.parent_id', '=', $request->account_manager];
        }
        if(isset($request->status) && $request->status != null){
            $where[] = ['users.status', '=', $request->status];
        }
        if(isset($request->country_id) && $request->country_id != null){
            $where[] = ['users.country_id', '=', $request->country_id];
        }
        if(isset($request->city_id) && $request->city_id != null){
            $where[] = ['users.city_id', '=', $request->city_id];
        }
        if(isset($request->category_id) && $request->category_id != null){
            $where[] = ['categories.id', '=', $request->category_id];
        }
        if(isset($request->platform) && $request->platform != null){
            $where[] = ['social_media_links.platform', '=', $request->platform];
        }
        // if(isset($request->performance) && $request->performance != null){
        //     $where[] = ['orders_number', '<=', 10];
        // }
        
        if(isset($request->sort_by) && $request->sort_by != null){
            $sortBy = $request->sort_by;
        }
        if(isset($request->sort_type) && $request->sort_type != null){
            $sortType = $request->sort_type;
        }

 
        if ($request->ajax()) {
            try {
                
                $publishers = User::select([
                    'users.id',
                    'users.ho_id',
                    'users.name',
                    'users.email',
                    'users.team',
                    DB::raw('COUNT(offer_user.offer_id) AS offersCount'),
                    'users.category',
                    'users.phone',
                    'users.parent_id',
                    'users.referral_account_manager',
                    'users.created_at',
                    'users.status',
                    'countries.name_en as country_name',
                    'cities.name_en as city_name',
                    DB::raw('TRUNCATE(SUM(pivot_reports.orders),2) as orders_number'), 
                    DB::raw('TRUNCATE(SUM(pivot_reports.sales),2) as sales_number'), 
                    DB::raw('TRUNCATE(SUM(pivot_reports.revenue) ,2) as revenue_number'),
                    DB::raw('TRUNCATE(SUM(pivot_reports.payout) ,2) as payout_number'),
                ])

                    ->leftJoin('countries', 'countries.id', '=', 'users.country_id')
                    ->leftJoin('cities', 'cities.id', '=', 'users.city_id')
                    ->leftJoin('category_user', 'category_user.user_id', '=', 'users.id')
                    ->leftJoin('categories', 'categories.id', '=', 'category_user.category_id')
                    ->leftJoin('social_media_links', 'social_media_links.user_id', '=', 'users.id')
                    ->leftJoin('coupons', 'coupons.user_id', '=', 'users.id')
                    ->leftJoin('pivot_reports', 'pivot_reports.coupon_id', '=', 'coupons.id')
                    ->leftJoin('offer_user', 'offer_user.user_id', '=', 'users.id')
                    ->wherePosition('publisher')
                    ->with('parent', 'categories', 'socialMediaLinks')
                    ->where($where)
                    ->groupBy('users.id');
                    $publishers->orderBy($sortBy, $sortType);
                if (in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid']) && $request->parent_id == null) {
                    $data = $publishers->where(function ($query) {
                        $childrens = auth()->user()->childrens()->pluck('id')->toArray();
                         array_push($childrens, auth()->user()->id);
                        $query
                            ->whereIn('parent_id', $childrens)
                            ->orWhere('parent_id', '=', null);
                   
                        $query->where('users.team', auth()->user()->team);
                    });
                } else {
                    $data = $publishers->groupBy('users.id');
                }
                // return $data;
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('parent_id', function ($row) {
                        return !empty($row->parent->name) ? $row->parent->name : '';
                    })
             
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('admin.publisher.profile', $row->id) . '" class="edit btn btn-primary btn-xs m-1"><i class="fas fa-eye"></i></a>';
                        $btn .= '<a href="' . route('admin.publishers.edit', $row->id) . '" class="edit btn btn-primary btn-xs m-1"><i class="fas fa-pen"></i></a>';
                        $btn .= $row->parent ? $row->parent->name : " <button class='btn badge btn-success ' onclick='assignToMe(" . $row->id . ")'>" . __('Assign To Me') . "</button>";
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
            }
        }

        if(auth()->user()->position == 'super_admin'){
            $accountManagers = User::where('position', 'account_manager')->get();
        }else{
            $accountManagers = auth()->user()->childrens()->where('position', 'account_manager')->get();
        }
        return view('admin.publishers.index', [
            'categories' => Category::whereType('publishers')->get(),
            'accountManagers' =>  $accountManagers,
            'countries' => Country::all(),
        ]);
    }



    public function dashboard(){
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
        ])->with('parent', 'categories')->paginate(10);

        $accountManagers = User::wherePosition('account_manager')->get();
        return view('admin.publishers.index', [
            'categories' => Category::whereType('publishers')->get(),
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
        $where = [['position', '=', 'publisher']];
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


        if ($request->ajax()) {
            if( in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
                $data = User::select('*')->wherePosition('publisher')->with('parent', 'categories')->where(function ($query) {
                    $query->where('parent_id', '=' ,auth()->user()->id)
                        ->orWhere('parent_id', '=', null);
                })->where($where);
            }else{
                $data = User::select('*')->wherePosition('publisher')->with('parent', 'categories')->where($where);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){

                    $btn = '<a href="'.route('admin.publishers.show', $row->id).'" class="edit btn btn-primary btn-sm">View</a>';
                    $btn .= $row->parent?$row->parent->name:" <button class='btn badge btn-success assignToMe' onclick='assignToMe(".$row->id.")'>".__('Assign To Me')."</button>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        $categories = Category::whereType('publishers')->get();
        $accountManagers = User::wherePosition('account_manager')->get();
        $data = $request->all();
        $data['categories'] = $categories;
        $data['accountManagers'] = $accountManagers;

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
            'categories' => Category::whereType('influencer')->get(),
            'users' => User::where('position', 'account_manager')->whereStatus('active')->get(),
            'currencies' => Currency::all(),
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
            'password'                  => ['required','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'parent_id'                 => 'required|numeric|exists:users,id',
            'country_id'                => 'required|exists:countries,id',
            'city_id'                   => 'required|exists:cities,id',
            'gender'                    => 'required|in:male,female',
            'status'                    => 'required|in:active,pending,closed',
            'team'                      => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate,prepaid',
            'skype'                     => 'nullable|max:255',
            'address'                   => 'nullable|max:255',
            'category'                  => 'nullable|max:255',
            'years_of_experience'       => 'nullable|numeric',
            // 'traffic_sources'           => 'required_if:team,affiliate|max:255',
            'affiliate_networks'        => 'required_if:team,affiliate|max:255',
            // 'digital_asset'            => 'required_if:team,affiliate|max:255',
            'referral_account_manager'  => 'nullable|max:255',
            'account_title'             => 'nullable|max:255',
            'bank_name'                 => 'nullable|max:255',
            'bank_branch_code'          => 'nullable|max:255',
            'swift_code'                => 'nullable|max:255',
            'iban'                      => 'nullable|max:255',
            'currency_id'               => 'nullable|exists:currencies,id',
            'image'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',

        ]);
        if($request->traffic_sources){
            $data['traffic_sources'] = implode(",",$request->traffic_sources);
        }
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
        if($request->team == 'affiliate'){
            if($request->digital_asset && count($request->digital_asset) > 0){
                foreach($request->digital_asset as $link){

                    DigitalAsset::create([
                        'link' => $link['link'],
                        'platform' => $link['platform'],
                        'other_platform_name' => $link['other_platform_name'],
                        'user_id' => $publisher->id,
                    ]);
                    
                }

            }
        }

        // Store Social Media Accounts
        if($request->team == 'influencer' || $request->team == 'prepaid'){
            if($request->social_media && count($request->social_media) > 0){
                foreach($request->social_media as $link){
                    if(!is_null($link['link'])){
                        SocialMediaLink::create([
                            'link' => $link['link'],
                            'platform' => $link['platform'],
                            'followers' => $link['followers'],
                            'user_id' => $publisher->id,
                        ]);
                    }
                    
                }

            }
        }

        // Store Digital Asset
        // if($request->team == 'influencer' || $request->team == 'prepaid'){
        //     if($request->social_media && count($request->social_media) > 0){
        //         foreach($request->social_media as $link){
        //             if(!is_null($link['link'])){
        //                 SocialMediaLink::create([
        //                     'link' => $link['link'],
        //                     'platform' => $link['platform'],
        //                     'followers' => $link['followers'],
        //                     'user_id' => $publisher->id,
        //                 ]);
        //             }
                    
        //         }

        //     }
        // }
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
        if(auth()->user()->id != $id || !in_array($id, auth()->user()->childrens()->pluck('id')->toArray())){
            $this->authorize('show_publishers');
        }

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
        if(auth()->user()->id != $id && !in_array($id, auth()->user()->childrens()->pluck('id')->toArray())){
            $this->authorize('update_publishers');
        }
        $accountManagers = User::where('position', 'account_manager')->get();
        $publisher = User::findOrFail($id);
        if($publisher->position != 'publisher'){
            return redirect()->route('admin.users.edit', $id);
        }
        $publisher->traffic_sources = explode(',', $publisher->traffic_sources);

        return view('admin.publishers.edit', [
            'publisher' => $publisher,
            'countries' => Country::all(),
            'cities' => City::whereCountryId($publisher->country_id)->get(),
            'parents' => User::where('position', 'account_manager')->whereStatus('active')->get(),
            'categories' => Category::whereType('influencer')->get(),
            'roles' => Role::all(),
            'currencies' => Currency::all(),
            'accountManagers' => $accountManagers,
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
        $message = 'Updated successfully';
        $data = $request->validate([
            'name'                      => 'required|max:255',
            'email'                     => 'required|max:255|unique:users,email,'.$id,
            'phone'                     => 'required|max:255|unique:users,phone,'.$id,
            'password'                  => ['nullable','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'country_id'                => 'required|exists:countries,id',
            'city_id'                   => 'required|exists:cities,id',
            'gender'                    => 'required|in:male,female',
            'parent_id'                 => 'nullable|numeric|exists:users,id',
            'status'                    => 'nullable|in:active,pending,closed',
            'team'                      => 'nullable|in:management,digital_operation,finance,media_buying,influencer,affiliate,prepaid',
            'skype'                     => 'nullable|max:255',
            'address'                   => 'nullable|max:255',
            'category'                  => 'nullable|max:255',
            'years_of_experience'       => 'nullable|numeric',
            'affiliate_networks'        => 'nullable|max:255',
            'referral_account_manager'  => 'nullable|exists:users,id',
            'account_title'             => 'nullable|required_if:position,publisher|max:255',
            'bank_name'                 => 'nullable|required_if:position,publisher|max:255',
            'bank_branch_code'          => 'nullable|required_if:position,publisher|max:255',
            'swift_code'                => 'nullable|required_if:position,publisher|max:255',
            'iban'                      => 'nullable|required_if:position,publisher|max:255',
            'currency_id'               => 'nullable|required_if:position,publisher|exists:currencies,id',
            'categories'                => 'nullable|array|required_if:position,publisher|exists:categories,id',
            'social_media.*.link'       => 'required_if:team,influencer',
            'image'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        if($request->traffic_sources){
            $data['traffic_sources'] = implode(",",$request->traffic_sources);
        }
        unset($data['password']);
        unset($data['social_media']);
        unset($data['categories']);
        unset($data['roles']);

        if($request->password){
            $data['password'] = Hash::make($request->password);
        }
        // dd($data);
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

        if($publisher->digitalAssets){
            $publisher->digitalAssets()->delete();
        }

        if(auth()->user()->position == 'account_manager' || auth()->user()->position == 'publisher'){
            userActivity('User', $publisher->id, 'update', $data, $publisher, null, false);
            $message = 'A request to update the data has been sent to your direct head';
            // Check if publisher have AM
            if($publisher->parent_id != null){
                // Get AM
                $accountManager = User::where('id', $publisher->parent_id)->first();
                // Check if AM exists 
                if($accountManager){
                    // Send notification to AM
                     Notification::send($accountManager, new PublisherNeedToUpdateHisInfo($publisher));
                     // Check if AM has head
                     if($accountManager->parent_id != null){
                         // Get Head Info
                        $head = User::where('id', $accountManager->parent_id)->first();
                        // Check if head exists
                        if($head){
                            // Send notification to head
                            Notification::send($head, new PublisherNeedToUpdateHisInfo($publisher));
                        }
                     }  
                }
            }

        }else{
            $message = __('Data updated successfully');
            userActivity('User', $publisher->id, 'update', $data, $publisher);
            $publisher->update($data);
        }

        if($request->categories){
            // Unasign categories
            $publisher->categories()->detach();
            // Assign Categories
            foreach($request->categories as $categoryId){
                $category = Category::findOrFail($categoryId);
                $publisher->assignCategory($category);
            }
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

        if($request->team == 'affiliate'){
            if($request->digital_asset && count($request->digital_asset) > 0){
                foreach($request->digital_asset as $link){
                    DigitalAsset::create([
                        'link' => $link['link'],
                        'platform' => $link['platform'],
                        // 'other_platform_name' => $link['other_platform_name'],
                        'user_id' => $publisher->id,
                    ]);
                }

            }
        }


        $notification = [
            'message' => $message,
            'alert-type' => 'success'
        ];
        if(auth()->user()->id == $id){
            return redirect()->route('admin.publisher.profile')->with($notification);
        }
        return redirect()->route('admin.publishers.index')->with($notification);
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
            if( auth()->user()->position == 'super_admin' || auth()->user()->position == 'head'){
                
                $accountManager = User::whereId($request->accountManagerId)->first();
                if($request->accountManagerId != null && $accountManager){

                    $publisher->parent_id =  $request->accountManagerId;
                }
            }
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


    public function profile(Request $request, int $id = null)
    {
       
        $request->validate([
            'from' => "nullable|before:to",
            'to' => "nullable|after:from",
        ]);
        $userId = ($id == null) ? auth()->user()->id : $id;
        $publisher = ($id == null) ? auth()->user() : User::findOrFail($id);
        
        $childrens = userChildrens($publisher);
        
        // $childrens = userChildrens($id) ?? [0=>0];
        // $childrens = $publisher->childrens()->pluck('id')->toArray();
        array_push($childrens, $userId);
        // dd($childrens);
        // Chaeck if login user team and check publisher team to make sure there is in the same team
        if(isset($id) && in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])){
            if(auth()->user()->team == $publisher->team){
                if(!in_array($id, userChildrens()) && $publisher->parent_id != null){
                    abort(401);
                }
            }else{
                abort(401);
            }
        }
      

        $startDate = Carbon::now(); //returns current day
        $firstDay = $startDate->firstOfMonth()->format('Y-m-d');
        $lastDay = $startDate->lastOfMonth()->format('Y-m-d');
        // Date 
        $where = [
            ['pivot_reports.date', '>=', $firstDay],
            ['pivot_reports.date', '<=', $lastDay]
        ];

        if(isset($request->from) && $request->from != null && isset($request->to) && $request->to != null){
            $where[0] = ['pivot_reports.date', '>=', $request->from];
            $where[1] = ['pivot_reports.date', '<=', $request->to];
        }

        
        $offers = Offer::whereHas('coupons', function($q) use($childrens) {
            $q->whereIn('user_id', $childrens);
        })->with(['users' => function($q) use($childrens){
            $q->whereIn('users.id', $childrens);
        },
        'coupons' => function($q) use($childrens){
            $q->whereIn('coupons.user_id', $childrens);
        }])->get();


        $activeOffers = DB::table('pivot_reports')
        ->select(
                DB::raw('TRUNCATE(SUM(pivot_reports.orders),2) as orders'), 
                DB::raw('TRUNCATE(SUM(pivot_reports.sales) ,2) as sales'),
                DB::raw('TRUNCATE(SUM(pivot_reports.revenue) ,2) as revenue'),
                'offers.id as offer_id',
                'offers.name_en as offer_name',
                'offers.status as offer_status',
                'offers.thumbnail as thumbnail',
                // 'offers.description_en as description',
                'pivot_reports.date as date',
                DB::raw('COUNT(coupons.id) as coupons')
            )
            ->join('offers', 'pivot_reports.offer_id', '=', 'offers.id')
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->whereIn('coupons.user_id', $childrens)
            ->where($where)
            ->orderBy('date',  'DESC')
            ->groupBy('offer_name', 'date')
            ->get();
        
            $totalNumbers = DB::table('pivot_reports')
            ->select(DB::raw('SUM(orders) as orders'), DB::raw('SUM(sales) as sales'), DB::raw('SUM(revenue) as revenue'))
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->whereIn('coupons.user_id', $childrens)
            ->where($where)
            ->orderBy('date',  'DESC')
            ->groupBy('date')
            ->first();
            
        return view('admin.publishers.profile', [
            'publisher' => $publisher,
            'offers' => $offers,
            'activeOffers' => $activeOffers->groupBy('date')->first(), 
            'totalNumbers' => $totalNumbers
        ]);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payments(Request $request, int $id = null)
    {
        $userId = ($id == null) ? auth()->user()->id : $id;
        $publisher = ($id == null) ? auth()->user() : User::findOrFail($id);
        $childrens = $publisher->childrens()->pluck('id')->toArray();
        array_push($childrens, $userId);

        $payments = Payment::whereHas('publisher', function($q) use($childrens) {
            $q->whereIn('publisher_id', $childrens);
        })->get();

        if ($request->ajax()) {
            return DataTables::of($payments)
                    ->addIndexColumn()
                    ->editColumn('parent_id', function ($row) {
                        return !empty($row->parent->name) ? $row->parent->name : '';
                    })
            
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="' . route('admin.payments.show', $row->id) . '" class="show btn btn-primary btn-xs m-1"><i class="fas fa-eye"></i></a>';
                        return $btn;
                    })
                    ->addColumn('slip', function ($row) {
                        $btn = '<img class="img-thumbnail rounded" src="' . getImagesPath('Payments', $row->slip) . '" class="show btn btn-primary btn-xs m-1">';
                        return $btn;
                    })
                    ->rawColumns(['action', 'slip'])
                    ->make(true);
        }

        return view('admin.publishers.payments', [
            'payments' => $payments
        ]);
    }

    /** Upload Publishers */
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
        if($request->team == 'affiliate'){
            Excel::import(new PublishersImport($request->team),request()->file('publishers'));
            // Excel::queueImport(new PublishersImport($request->team),request()->file('publishers'));

        }
        if($request->team == 'influencer'){
            // Excel::import(new InfluencerImport($request->team),request()->file('publishers'));

            Excel::queueImport(new InfluencerImport($request->team),request()->file('publishers'));
        }

        userActivity('User', null , 'upload', 'Upload Publishers');
        $notification = [
            'message' => 'Uploaded successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('admin.publishers.index')->with($notification);
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
        
        try {
            return redirect()->back()->withErrors(['message' => __('You do not have account manager')]);
        } catch (\Throwable $th) {
            return redirect()->route('admin.publisher.profile');

        }
    }



}
