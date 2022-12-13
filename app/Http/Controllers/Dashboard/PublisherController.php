<?php

namespace App\Http\Controllers\Dashboard;

use App\Charts\PublisherOfferProfileChart;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Extended\MhDataTables;
use App\Imports\InfluencerImport;
use App\Imports\PublisherImportV2;
use App\Imports\PublishersImport;
use App\Imports\PublishersImportNasedOnAcountManagerAndTeam;
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
use App\Facades\PublisherCharts;
use App\Facades\PublisherProfile;
use Illuminate\Support\Facades\Cache;

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
        $tableLength = session('table_length') ?? config('app.pagination_pages');
        $query = User::query();


        // Filter
        if (isset($request->team) && $request->team  != null) {
            $query->where('team', $request->team);
            session()->put('publishers_filter_team', $request->team);
        } elseif (session('publishers_filter_team')) {
            $query->where('team', session('publishers_filter_team'));
        }

        if (isset($request->parent_id) && $request->parent_id  != null) {
            $query->where('parent_id', $request->parent_id);
            session()->put('publishers_filter_parent_id', $request->parent_id);
        } elseif (session('publishers_filter_parent_id')) {
            $query->where('parent_id', session('publishers_filter_parent_id'));
        }

        if (isset($request->status) && $request->status  != null) {
            $query->where('status', $request->status);
            session()->put('publishers_filter_status', $request->status);
        } elseif (session('publishers_filter_status')) {
            $query->where('status', session('publishers_filter_status'));
        }

        if (isset($request->search) && $request->search  != null) {
            $key = explode(' ', $request->search);
            $query->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%")
                    ->orWhere('email', 'like', "%{$value}%")
                    ->orWhere('phone', 'like', "%{$value}%")
                    ->orWhere('ho_id', 'like', "%{$value}%")
                    ->orWhere('id', 'like', "%{$value}%");
                }
            });
        }

        $publishers = $query->wherePosition('publisher')->with('parent', 'categories', 'socialMediaLinks', 'offers', 'country', 'city');

            if (in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid']) && $request->parent_id == null) {
                $publishers = $publishers->where(function ($query) {
                    $childrens = auth()->user()->childrens()->pluck('id')->toArray();
                    array_push($childrens, auth()->user()->id);
                    $query->whereIn('parent_id', $childrens)->orWhere('parent_id', '=', null);
                    $query->where('users.team', auth()->user()->team);
                });
            } else {
                $publishers = $publishers->groupBy('users.id');
            }

            $publishers = $publishers->orderBy('id', 'desc')->paginate($tableLength);
        if (auth()->user()->position == 'super_admin') {
            $accountManagers = User::where('position', 'account_manager')->get();
        } else {
            $accountManagers = auth()->user()->childrens()->where('position', 'account_manager')->get();
        }

        return view('new_admin.publishers.index', [
            'categories' => Category::whereType('publishers')->get(),
            'accountManagers' =>  $accountManagers,
            'countries' => Country::all(),
            'publishers' => $publishers
        ]);
    }

    public function dashboard()
    {
        $publisher = User::findOrFail(Auth::user()->id);
        return view('admin.publishers.new.dashboard', ['publisher' => $publisher]);
    }

    public function offers()
    {
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_publishers');
        return view('new_admin.publishers.create', [
            'cities' => City::all(),
            'countries' => Country::all(),
            'categories' => Category::whereType('affiliate')->get(),
            'users' => User::whereStatus('active')->whereHas('roles', function($query){
                return $query->where('label', 'account_manager');
            })->get(),
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
            'phone'                     => 'required|unique:users|numeric',
            'parent_id'                 => 'required|numeric|exists:users,id',
            'country_id'                => 'nullable|exists:countries,id',
            'city_id'                   => 'nullable|exists:cities,id',
            'gender'                    => 'required|in:male,female',
            'team'                      => 'required|in:management,digital_operation,finance,media_buying,influencer,affiliate,prepaid',
            'skype'                     => 'nullable|max:255',
            'address'                   => 'nullable|max:255',
            'category'                  => 'nullable|max:255',
            'years_of_experience'       => 'nullable|numeric',
            // 'traffic_sources'           => 'required_if:team,affiliate|max:255',
            'affiliate_networks'        => 'required_if:team,affiliate|max:255',
            // 'digital_asset'            => 'required_if:team,affiliate|array',
            'referral_account_manager'  => 'nullable|max:255',
            'account_title'             => 'nullable|max:255',
            'bank_name'                 => 'nullable|max:255',
            'bank_branch_code'          => 'nullable|max:255',
            'swift_code'                => 'nullable|max:255',
            'iban'                      => 'nullable|max:255',
            'currency_id'               => 'nullable|exists:currencies,id',
            'image'                     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'city'                      => 'required_if:team,influencer|max:255',
            'influencer_type'           => 'required_if:team,influencer|in:performance,prepaid,express',
            'influencer_rating'         => 'required_if:team,influencer|in:nano,micro,macro,mega,celebrity',
            'currency'                  => 'required|max:3',


        ]);
        if ($request->traffic_sources) {
            $data['traffic_sources'] = implode(",", $request->traffic_sources);
        }
        $data['password'] = Hash::make($request->password);
        $data['position'] = 'publisher';
        $data['status'] = 'active';
        $data['created_at'] = Carbon::now();
        unset($data['social_media']);
        if ($request->hasFile('image')) {
            $data['image'] = uploadImage($request->file('image'), "Users");
        }
        // dd($data);
        $publisher = User::create($data);
        // Store Activity
        userActivity('User', $publisher->id, 'create');

        // Add categories
        if ($request->categories) {
            foreach ($request->categories as $categoryId) {
                $category = Category::findOrFail($categoryId);
                $publisher->assignCategory($category);
            }
        }


        $role = Role::whereLabel('publisher')->first();
        $publisher->assignRole($role);

        // Store Social Media Accounts
        if ($request->team == 'affiliate') {
            if ($request->digital_asset && count($request->digital_asset) > 0) {
                foreach ($request->digital_asset as $link) {

                    DigitalAsset::create([
                        'link' => $link['link'],
                        'platform' => $link['platform'],
                        'other_platform_name' => $link['other_platform_name'] ?? '',
                        'user_id' => $publisher->id,
                    ]);
                }
            }
        }

        // Store Social Media Accounts
        if ($request->team == 'influencer' || $request->team == 'prepaid') {
            if ($request->social_media && count($request->social_media) > 0) {
                foreach ($request->social_media as $link) {
                    if (!is_null($link['link'])) {
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

        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.publishers.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (auth()->user()->id != $id || !in_array($id, auth()->user()->childrens()->pluck('id')->toArray())) {
            $this->authorize('view_publishers');
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
        if (auth()->user()->id != $id && !in_array($id, auth()->user()->childrens()->pluck('id')->toArray())) {
            $this->authorize('update_publishers');
        }
        $accountManagers = User::where('position', 'account_manager')->get();
        $publisher = User::findOrFail($id);
        if ($publisher->position != 'publisher') {
            return redirect()->route('admin.users.edit', $id);
        }
        $publisher->traffic_sources = explode(',', $publisher->traffic_sources);

        return view('new_admin.publishers.edit', [
            'publisher' => $publisher,
            'countries' => Country::all(),
            'cities' => City::whereCountryId($publisher->country_id)->get(),
            'users' => User::where('position', 'account_manager')->whereStatus('active')->get(),
            'categories' => Category::whereType($publisher->team)->get(),
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

        if (auth()->user()->id != $id) {
            $this->authorize('update_publishers');
        }
        $message = 'Updated successfully';
        $data = $request->validate([
            'name'                      => 'required|max:255',
            'email'                     => 'required|max:255|unique:users,email,' . $id,
            'phone'                     => 'required|numeric|unique:users,phone,' . $id,
            'password'                  => ['nullable', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
            'country_id'                => 'nullable|exists:countries,id',
            'city_id'                   => 'nullable|exists:cities,id',
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
            'city'                      => 'required_if:team,influencer|max:255',
            'influencer_type'           => 'required_if:team,influencer|in:performance,prepaid,express',
            'influencer_rating'         => 'required_if:team,influencer|in:nano,micro,macro,mega,celebrity',
            'currency'                  => 'required|max:3',
        ]);
        if ($request->traffic_sources) {
            $data['traffic_sources'] = implode(",", $request->traffic_sources);
        }
        unset($data['password']);
        unset($data['social_media']);
        unset($data['categories']);
        unset($data['roles']);

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        // dd($data);
        $publisher = User::findOrFail($id);

        // Update Image
        $data['image'] = $publisher->image;
        if ($request->has("image")) {
            Storage::disk('public')->delete('Images/Users/' . $publisher->image);
            $image = time() . rand(11111, 99999) . '.' . $request->image->extension();
            $request->image->storeAs('Images/Users/', $image, 'public');
            $data['image'] = $image;
        }

        if ($publisher->socialMediaLinks) {
            $publisher->socialMediaLinks()->delete();
        }

        if ($publisher->digitalAssets) {
            $publisher->digitalAssets()->delete();
        }

        if (auth()->user()->position == 'account_manager' || auth()->user()->position == 'publisher') {
            userActivity('User', $publisher->id, 'update', $data, $publisher, null, false);
            $message = 'A request to update the data has been sent to your direct head';
            // Check if publisher have AM
            if ($publisher->parent_id != null) {
                // Get AM
                $accountManager = User::where('id', $publisher->parent_id)->first();
                // Check if AM exists
                if ($accountManager) {
                    // Send notification to AM
                    Notification::send($accountManager, new PublisherNeedToUpdateHisInfo($publisher));
                    // Check if AM has head
                    if ($accountManager->parent_id != null) {
                        // Get Head Info
                        $head = User::where('id', $accountManager->parent_id)->first();
                        // Check if head exists
                        if ($head) {
                            // Send notification to head
                            Notification::send($head, new PublisherNeedToUpdateHisInfo($publisher));
                        }
                    }
                }
            }
        } else {
            $message = __('Data updated successfully');
            userActivity('User', $publisher->id, 'update', $data, $publisher);
            $publisher->update($data);
        }

        if ($request->categories) {
            // Unasign categories
            $publisher->categories()->detach();
            // Assign Categories
            foreach ($request->categories as $categoryId) {
                $category = Category::findOrFail($categoryId);
                $publisher->assignCategory($category);
            }
        }


        // Asign Role
        if ($request['roles']) {
            $publisher->roles()->detach();
            foreach ($request['roles'] as $role_id) {
                $role = Role::findOrFail($role_id);
                $publisher->assignRole($role);
            }
        }

        if ($request->team == 'influencer' || $request->team == 'prepaid') {
            if ($request->social_media && count($request->social_media) > 0) {
                foreach ($request->social_media as $link) {
                    if ($link['link']) {
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

        if ($request->team == 'affiliate') {
            if ($request->digital_asset && count($request->digital_asset) > 0) {
                foreach ($request->digital_asset as $link) {
                    if($link['link']){
                        DigitalAsset::create([
                            'link' => $link['link'],
                            'platform' => $link['platform'],
                            // 'other_platform_name' => $link['other_platform_name'],
                            'user_id' => $publisher->id,
                        ]);
                    }

                }
            }
        }


        $notification = [
            'message' => $message,
            'alert-type' => 'success'
        ];
        if (auth()->user()->id == $id) {
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
        if ($publisher) {
            $publisher->parent_id = auth()->user()->id;
            if (auth()->user()->position == 'super_admin' || auth()->user()->position == 'head') {

                $accountManager = User::whereId($request->accountManagerId)->first();
                if ($request->accountManagerId != null && $accountManager) {

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
        if ($request->ajax()) {
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
        array_push($childrens, $userId);

        // Chaeck if login user team and check publisher team to make sure there is in the same team
        if (isset($id) && in_array(auth()->user()->team, ['media_buying', 'influencer', 'affiliate', 'prepaid'])) {
            if (auth()->user()->team == $publisher->team) {
                if (!in_array($id, userChildrens()) && $publisher->parent_id != null) {
                    abort(401);
                }
            } else {
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

        if (isset($request->from) && $request->from != null && isset($request->to) && $request->to != null) {
            $where[0] = ['pivot_reports.date', '>=', $request->from];
            $where[1] = ['pivot_reports.date', '<=', $request->to];
        }

        $offers = PublisherProfile::offers($childrens);
        $coupons = PublisherProfile::coupons($childrens, $where);
        $activeOffers = PublisherProfile::activeOffers($childrens, $where);
        $totalNumbers = PublisherProfile::totalNumbers($childrens, $where);
        $payments = PublisherProfile::payments($childrens);
        // dd(gettype($activeOffers));
        // dd(count($activeOffers));
        // dd($payments);
        //Start Charts
        $chartCoupons = PublisherCharts::coupons($childrens, $where);
        $chartActiveOffers = PublisherCharts::activeOffers($childrens, $where);
        // Offer Charts
        $offersOrdersChart = PublisherCharts::chart($chartActiveOffers, 'offer_name', 'orders', 'doughnut', 'Offers');
        $offersSalesChart = PublisherCharts::chart($chartActiveOffers, 'offer_name', 'sales', 'doughnut', 'Offers');
        $offersRevenueChart = PublisherCharts::chart($chartActiveOffers, 'offer_name', 'revenue', 'doughnut', 'Offers');

        // Coupons Charts

        $couponsOrdersChart = PublisherCharts::chart($chartCoupons, 'coupon', 'orders', 'bar', 'Coupons');
        $couponsSalesChart = PublisherCharts::chart($chartCoupons, 'coupon', 'sales', 'bar', 'Coupons');
        $couponsRevenueChart = PublisherCharts::chart($chartCoupons, 'coupon','revenue', 'bar', 'Coupons');

        return view('new_admin.publishers.profile', [
            'publisher' => $publisher,
            'offers' => $offers,
            'activeOffers' => $activeOffers->groupBy('date')->first(),
            'totalNumbers' => $totalNumbers,
            'offersOrdersChart' => $offersOrdersChart,
            'offersSalesChart' => $offersSalesChart,
            'offersRevenueChart' => $offersRevenueChart,
            'couponsOrdersChart' => $couponsOrdersChart,
            'couponsSalesChart' => $couponsSalesChart,
            'couponsRevenueChart' => $couponsRevenueChart,
            'payments' => $payments,
            'coupons' => $coupons,
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
        $this->authorize('view_payments');

        $userId = ($id == null) ? auth()->user()->id : $id;
        $publisher = ($id == null) ? auth()->user() : User::findOrFail($id);
        $childrens = $publisher->childrens()->pluck('id')->toArray();
        array_push($childrens, $userId);

        $payments = Payment::whereHas('publisher', function ($q) use ($childrens) {
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
        return view('new_admin.publishers.upload');
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

        // Excel::import(new InfluencerImport($request->team, $request->parent_id),request()->file('publishers'));

        if ($request->team == 'affiliate') {
            Excel::import(new PublishersImport($request->team), request()->file('publishers'));
            // Excel::queueImport(new PublishersImport($request->team),request()->file('publishers'));
        }
        if ($request->team == 'influencer') {
            Excel::import(new InfluencerImport($request->team), request()->file('publishers'));
            // Excel::queueImport(new InfluencerImport($request->team),request()->file('publishers'));
        }

        userActivity('User', null, 'upload', 'Upload Publishers');
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
        Excel::import(new PublishersUpdateHasofferIdByEmail(), request()->file('publishers'));
        userActivity('User', null, 'upload', 'Upload and Update HasOffer Id ByEmail');
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
    public function myAccountManager()
    {
        if (auth()->user()->parent) {
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
    // .
    public function checkIfExists(Request $request)
    {
        $user = User::where('phone', $request->column)->orWhere('email', $request->column)->first();
        if ($user) {
            $response = '<p class="invalid-input">' . __('Already exists his name is ') . $user->name . __(' Team ') . $user->team . __(' Posiion ') . $user->position . ' </p>';
            if ($user->parent) {
                $response .= '<p class="invalid-input">' . __('His account manager is ') . $user->parent->name . '</p>';
            } else {
                $response .= '<p class="invalid-input">' . __('He dosn`t have account manager') . '</p>';
            }
            return $response;
        }
        return null;
    }

    public function changeStatus(Request $request){
        $this->authorize('update_publishers');

        $user = User::findOrFail($request->id);
        $user->status = $request->status;
        $user->save();
        return response()->json(['message' => 'Updated Succefuly']);
    }

    public function clearFilterSeassoions()
    {
        session()->forget('publishers_filter_team');
        session()->forget('publishers_filter_parent_id');
        session()->forget('publishers_filter_status');
        return redirect()->route('admin.publishers.index');
    }
}
