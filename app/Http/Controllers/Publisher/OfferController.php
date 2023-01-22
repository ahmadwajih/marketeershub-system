<?php

namespace App\Http\Controllers\Publisher;

use App\Models\User;
use App\Models\Offer;
use Matrix\Exception;
use App\Models\Coupon;
use App\Models\Country;
use App\Models\Category;
use App\Models\Currency;
use App\Models\OfferCps;
use App\Models\OfferSlap;
use App\Models\Advertiser;
use App\Models\NewOldOffer;
use App\Facades\SallaFacade;
use App\Models\OfferRequest;
use Illuminate\Http\Request;
use App\Notifications\NewOffer;
use Yajra\DataTables\DataTables;
use App\Facades\PublisherProfile;
use App\Imports\OfferCouponImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('view_offers');
        $query = Offer::query();
        // Filter
        if (isset($request->status) && $request->status  != null) {
            $status = $request->status;
            if ($status == 'active') {
                $query->where('status', 'active');
            } else {
                $query->where('status', '!=', 'active');
            }
            session()->put('offers_filter_status', $request->status);
        } elseif (session('offers_filter_status')) {
            $status = session('offers_filter_status');
            if ($status == 'active') {
                $query->where('status', 'active');
            } else {
                $query->where('status','!=', 'active');
            }
        }

        if (isset($request->revenue_cps_type) && $request->revenue_cps_type  != null) {
            $query->where('revenue_cps_type', $request->revenue_cps_type);
            session()->put('offers_filter_revenue_cps_type', $request->revenue_cps_type);
        } elseif (session('offers_filter_revenue_cps_type')) {
            $query->where('revenue_cps_type', session('offers_filter_revenue_cps_type'));
        }

        if (isset($request->payout_cps_type) && $request->payout_cps_type  != null) {
            $query->where('payout_cps_type', $request->payout_cps_type);
            session()->put('offers_filter_payout_cps_type', $request->payout_cps_type);
        } elseif (session('offers_filter_payout_cps_type')) {
            $query->where('payout_cps_type', session('offers_filter_payout_cps_type'));
        }

        $tableLength = session('table_length') ?? config('app.pagination_pages');

        if (isset($request->search) && $request->search  != null) {
            $query->where('name_ar', 'like',  "%{$request->search}%")
                ->orWhere('name_en', 'like', "%{$request->search}%");
        }

        $userId = auth()->user()->id;
        $children = userChildrens(auth()->user());
        array_push($children, $userId);

        $offers = PublisherProfile::offers_collection($children)->latest()->paginate($tableLength);
        $update             = in_array('update_offers', auth()->user()->permissions->pluck('name')->toArray());
        $offerRequestsArray = OfferRequest::where('user_id', auth()->user()->id)->pluck('offer_id')->toArray();

        return view('publishers.offers.index', compact('offers', 'offerRequestsArray'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myOffers(Request $request)
    {
        $this->authorize('view_offers');
        $offers             = auth()->user()->offers;
        $update             = in_array('update_offers', auth()->user()->permissions->pluck('name')->toArray());
        $offerRequestsArray = OfferRequest::where('user_id', auth()->user()->id)->pluck('offer_id')->toArray();
        return view('admin.offers.index', compact('offers', 'offerRequestsArray'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_offers');
        return view('new_admin.offers.create', [
            'countries' => Country::all(),
            'categories' => Category::all(),
            'currencies' => Currency::all(),
            'advertisers' => Advertiser::whereStatus('active')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create_offers');
        $data = $request->validate([
            // Genral Info
            'name_en' => 'required|max:255',
            'advertiser_id' => 'nullable|exists:advertisers,id',
            'description_en' => 'nullable',
            'website' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'offer_url' => 'required|url|max:255',
            'categories' => 'array|required|exists:categories,id',
            'coupons' => 'nullable|file',
            'expire_date' => 'nullable|date|after:yesterday',
            'note' => 'nullable',
            'terms_and_conditions_en' => 'nullable',
            // 'countries' => 'array|required|exists:countries,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'discount' => 'nullable|max:255',
            // Revenue Validation
            'revenue_cps_type' => 'required|in:static,new_old,slaps',
            'static_revenue_type' => 'required_if:revenue_cps_type,static|in:flat,percentage',
            'new_old_revenue_type' => 'required_if:revenue_cps_type,new_old|in:flat,percentage',
            'static_revenue' => 'required_if:revenue_cps_type,static|array',
            'static_revenue.*.revenue' => 'required_if:revenue_cps_type,static',

            'new_old_revenue' => 'required_if:revenue_cps_type,new_old|array',
            'new_old_revenue.*.new_revenue' => 'required_if:revenue_cps_type,new_old',
            'new_old_revenue.*.old_revenue' => 'required_if:revenue_cps_type,new_old',

            'revenue_slaps' => 'required_if:revenue_cps_type,slaps|array',
            'revenue_slaps.*.from' => 'required_if:revenue_cps_type,slaps',
            'revenue_slaps.*.to' => 'required_if:revenue_cps_type,slaps',
            'revenue_slaps.*.revenue' => 'required_if:revenue_cps_type,slaps',
            // Payout Validation
            'payout_cps_type' => 'required|in:static,new_old,slaps',
            'static_payout_type' => 'required_if:payout_cps_type,static|in:flat,percentage',
            'new_old_payout_type' => 'required_if:payout_cps_type,new_old|in:flat,percentage',
            'static_payout' => 'required_if:payout_cps_type,static|array',
            'static_payout.*.payout' => 'required_if:payout_cps_type,static',

            'new_old_payout' => 'required_if:payout_cps_type,new_old|array',
            'new_old_payout.*.new_payout' => 'required_if:payout_cps_type,new_old',
            'new_old_payout.*.old_payout' => 'required_if:payout_cps_type,new_old',

            'payout_slaps' => 'required_if:payout_cps_type,slaps|array',
            'payout_slaps.*.from' => 'required_if:payout_cps_type,slaps',
            'payout_slaps.*.to' => 'required_if:payout_cps_type,slaps',
            'payout_slaps.*.payout' => 'required_if:payout_cps_type,slaps',


        ]);

        $thumbnail = '';
        if ($request->has('thumbnail')) {
            $thumbnail = time() . rand(11111, 99999) . '.' . $request->thumbnail->extension();
            $request->thumbnail->storeAs('Images/Offers/', $thumbnail, 'public');
        }

        try {
            DB::beginTransaction();

            $offer = Offer::create([
                'name_en' => $request->name_en,
                'advertiser_id' => $request->advertiser_id,
                'description_en' => $request->description_en,
                'website' => $request->website,
                'thumbnail' => $thumbnail,
                'offer_url' => $request->offer_url,
                'status' => 'active',
                'expire_date' => $request->expire_date,
                'note' => $request->note,
                'terms_and_conditions_en' => $request->terms_and_conditions_en,
                'currency_id' => $request->currency_id,
                'discount' => $request->discount,
                'revenue_cps_type' => $request->revenue_cps_type,
                'revenue_type' => $request->revenue_cps_type == 'static' ? $request->static_revenue_type : $request->new_old_revenue_type,
                'payout_cps_type' => $request->payout_cps_type,
                'payout_type' => $request->payout_cps_type == 'static' ? $request->static_payout_type : $request->new_old_payout_type,

            ]);

            userActivity('Offer', $offer->id, 'create');
            // $publishers = User::wherePosition('publisher')->get();
            // try {
            //     Notification::send($publishers, new NewOffer($offer));
            // } catch (\Throwable $th) {
            //     Log::debug($th);
            // }

            if ($request->categories) {
                $offer->categories()->attach($request->categories);
            }

            // if ($request->countries) {
            //     $offer->countries()->attach($request->countries);
            // }

            // If revenue_cps_type is static
            if ($request->revenue_cps_type == 'static') {
                if ($request->static_revenue && count($request->static_revenue) > 0) {
                    foreach ($request->static_revenue as $staticRevenue) {
                        OfferCps::create([
                            'type' => 'revenue',
                            'cps_type' => 'static',
                            'amount_type' => $request->static_revenue_type,
                            'amount' => $staticRevenue['revenue'],
                            'date_range' => isset($staticRevenue['date_range']) && $staticRevenue['date_range'][0] == 'on' ? true : false,
                            'from_date' => $staticRevenue['from_date'] ?? null,
                            'to_date' => $staticRevenue['to_date'] ?? null,
                            'countries' => isset($staticRevenue['countries']) && $staticRevenue['countries'][0] == 'on' ? true : false,
                            'countries_ids' => isset($staticRevenue['countries_ids']) ? json_encode($staticRevenue['countries_ids'], JSON_NUMERIC_CHECK) : null,
                            'offer_id' => $offer->id,
                        ]);
                    }
                }
            }

            // If revenue_cps_type is new_old
            if ($request->revenue_cps_type == 'new_old') {
                if ($request->new_old_revenue && count($request->new_old_revenue) > 0) {
                    foreach ($request->new_old_revenue as $newOldRevenue) {
                        OfferCps::create([
                            'type' => 'revenue',
                            'cps_type' => 'new_old',
                            'amount_type' => $request->new_old_revenue_type,
                            'new_amount' => $newOldRevenue['new_revenue'],
                            'old_amount' => $newOldRevenue['old_revenue'],
                            'date_range' => isset($newOldRevenue['date_range']) &&  $newOldRevenue['date_range'][0] == 'on' ? true : false,
                            'from_date' => $newOldRevenue['from_date'] ?? null,
                            'to_date' => $newOldRevenue['to_date'] ?? null,
                            'countries' => isset($newOldRevenue['countries']) && $newOldRevenue['countries'][0] == 'on' ? true : false,
                            'countries_ids' => isset($newOldRevenue['countries_ids']) ? json_encode($newOldRevenue['countries_ids'], JSON_NUMERIC_CHECK) : null,
                            'offer_id' => $offer->id,
                        ]);
                    }
                }
            }

            // If revenue_cps_type is slaps
            if ($request->revenue_cps_type == 'slaps') {
                if ($request->revenue_slaps && count($request->revenue_slaps) > 0) {
                    foreach ($request->revenue_slaps as $slapsRevenue) {
                        OfferCps::create([
                            'type' => 'revenue',
                            'cps_type' => 'slaps',
                            'amount_type' => $request->static_revenue_type,
                            'amount' => $slapsRevenue['revenue'],
                            'from' => $slapsRevenue['from'] ?? null,
                            'to' => $slapsRevenue['to'] ?? null,
                            'offer_id' => $offer->id,
                        ]);
                    }
                }
            }


            // If payout_cps_type is static
            if ($request->payout_cps_type == 'static') {
                if ($request->static_payout && count($request->static_payout) > 0) {
                    foreach ($request->static_payout as $staticPayout) {
                        OfferCps::create([
                            'type' => 'payout',
                            'cps_type' => 'static',
                            'amount_type' => $request->static_payout_type,
                            'amount' => $staticPayout['payout'],
                            'date_range' => isset($staticPayout['date_range']) && $staticPayout['date_range'][0] == 'on' ? true : false,
                            'from_date' => $staticPayout['from_date'] ?? null,
                            'to_date' => $staticPayout['to_date'] ?? null,
                            'countries' => isset($staticPayout['countries']) && $staticPayout['countries'][0] == 'on' ? true : false,
                            'countries_ids' => isset($staticPayout['countries_ids']) ? json_encode($staticPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                            'offer_id' => $offer->id,
                        ]);
                    }
                }
            }

            // If payout_cps_type is new_old
            if ($request->payout_cps_type == 'new_old') {
                if ($request->new_old_payout && count($request->new_old_payout) > 0) {
                    foreach ($request->new_old_payout as $newOldPayout) {
                        OfferCps::create([
                            'type' => 'payout',
                            'cps_type' => 'new_old',
                            'amount_type' => $request->new_old_payout_type,
                            'new_amount' => $newOldPayout['new_payout'],
                            'old_amount' => $newOldPayout['old_payout'],
                            'date_range' => isset($newOldPayout['date_range']) && $newOldPayout['date_range'][0] == 'on' ? true : false,
                            'from_date' => $newOldPayout['from_date'] ?? null,
                            'to_date' => $newOldPayout['to_date'] ?? null,
                            'countries' => isset($newOldPayout['countries']) && $newOldPayout['countries'][0] == 'on' ? true : false,
                            'countries_ids' => isset($newOldPayout['countries_ids']) ? json_encode($newOldPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                            'offer_id' => $offer->id,
                        ]);
                    }
                }
            }

            // If payout_cps_type is slaps
            if ($request->payout_cps_type == 'slaps') {
                if ($request->payout_slaps && count($request->payout_slaps) > 0) {
                    foreach ($request->payout_slaps as $slapsPayout) {
                        OfferCps::create([
                            'type' => 'payout',
                            'cps_type' => 'slaps',
                            'amount_type' => $request->static_payout_type,
                            'amount' => $slapsPayout['payout'],
                            'from' => $slapsPayout['from'] ?? null,
                            'to' => $slapsPayout['to'] ?? null,
                            'offer_id' => $offer->id,
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }


        // If this offer is with salla partener
        if ($request->partener == 'salla') {
            SallaFacade::assignSalaInfoToOffer($offer->salla_user_email, $offer->id);
        }

        // Check of offer type is link tracking to upload coupons
        if ($request->coupons) {
            Excel::queueImport(new OfferCouponImport($offer->id), request()->file('coupons'));
        }
        $notification = [
            'message' => 'Created successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.offers.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $this->authorize('view_offers');
        $offer = Offer::withTrashed()->findOrFail($id);
        $offerRequest = OfferRequest::where([
            ['user_id', '=', auth()->user()->id],
            ['offer_id', '=', $offer->id]

        ])->first();


        $topPublishers = DB::table('pivot_reports')
            ->select(
                DB::raw('pivot_reports.orders as orders'),
                DB::raw('pivot_reports.sales as sales'),
                DB::raw('pivot_reports.payout as payout'),
                DB::raw('pivot_reports.revenue as revenue'),
                'users.id as user_id',
                'users.ho_id as user_ho_id',
                'users.name as user_name',
                'users.team as user_team',
                'pivot_reports.date as date',
                DB::raw('COUNT(coupons.id) as coupons')
            )
            ->orderBy('orders',  'desc')
            ->join('offers', 'pivot_reports.offer_id', '=', 'offers.id')
            ->join('coupons', 'pivot_reports.coupon_id', '=', 'coupons.id')
            ->join('users', 'coupons.user_id', '=', 'users.id')
            ->groupBy('user_name', 'date', 'orders')

            ->get();

        // Get Coupons
        $query = Coupon::query();

        // Filter
        if (isset($request->user_id) && $request->user_id  != null) {
            $query->where('user_id', $request->user_id);
        }

        if (isset($request->status) && $request->status  != null) {
            $query->where('status', $request->status);
        }

        if (isset($request->search) && $request->search  != null) {
            $query->where('coupon', $request->search);
        }
        $tableLength = session('table_length') ?? config('app.pagination_pages');
        $coupons = $query->where('offer_id', $id)->with(['offer', 'user'])->paginate($tableLength);
        // userActivity('Offer', $offer->id, 'view');
        //
        return view('new_admin.offers.show', [
            'offer' => $offer,
            'offerRequest' => $offerRequest,
            'topPublishers' => $topPublishers->groupBy('date')->first(),
            'publishers' => User::wherePosition('publisher')->get(),
            'countries' => Country::all(),
            'coupons' => $coupons
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Offer $offer)
    {
        $this->authorize('update_offers');
        return view('new_admin.offers.edit', [
            'offer' => $offer,
            'countries' => Country::all(),
            'categories' => Category::all(),
            'currencies' => Currency::all(),
            'advertisers' => Advertiser::whereStatus('active')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Offer $offer)
    {
        // dd($request->all());
        $this->authorize('update_offers');
        $data = $request->validate([
            // Genral Info
            'name_en' => 'required|max:255',
            'advertiser_id' => 'nullable|exists:advertisers,id',
            'description_en' => 'nullable',
            'website' => 'nullable|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'offer_url' => 'required|url|max:255',
            'categories' => 'array|required|exists:categories,id',
            'coupons' => 'nullable|file',
            'status' => 'required|in:active,pending,pused,expire',
            'expire_date' => 'nullable|date|after:yesterday',
            'note' => 'nullable',
            'terms_and_conditions_en' => 'nullable',
            // 'countries' => 'array|required|exists:countries,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'discount' => 'nullable|max:255',
            // Revenue Validation
            'revenue_cps_type' => 'required|in:static,new_old,slaps',
            'static_revenue_type' => 'required_if:revenue_cps_type,static|in:flat,percentage',
            'new_old_revenue_type' => 'required_if:revenue_cps_type,new_old|in:flat,percentage',
            'static_revenue' => 'required_if:revenue_cps_type,static|array',
            'static_revenue.*.revenue' => 'required_if:revenue_cps_type,static',

            'new_old_revenue' => 'required_if:revenue_cps_type,new_old|array',
            'new_old_revenue.*.new_revenue' => 'required_if:revenue_cps_type,new_old',
            'new_old_revenue.*.old_revenue' => 'required_if:revenue_cps_type,new_old',

            'revenue_slaps' => 'required_if:revenue_cps_type,slaps|array',
            'revenue_slaps.*.from' => 'required_if:revenue_cps_type,slaps',
            'revenue_slaps.*.to' => 'required_if:revenue_cps_type,slaps',
            'revenue_slaps.*.revenue' => 'required_if:revenue_cps_type,slaps',
            // Payout Validation
            'payout_cps_type' => 'required|in:static,new_old,slaps',
            'static_payout_type' => 'required_if:payout_cps_type,static|in:flat,percentage',
            'new_old_payout_type' => 'required_if:payout_cps_type,new_old|in:flat,percentage',
            'static_payout' => 'required_if:payout_cps_type,static|array',
            'static_payout.*.payout' => 'required_if:payout_cps_type,static',

            'new_old_payout' => 'required_if:payout_cps_type,new_old|array',
            'new_old_payout.*.new_payout' => 'required_if:payout_cps_type,new_old',
            'new_old_payout.*.old_payout' => 'required_if:payout_cps_type,new_old',

            'payout_slaps' => 'required_if:payout_cps_type,slaps|array',
            'payout_slaps.*.from' => 'required_if:payout_cps_type,slaps',
            'payout_slaps.*.to' => 'required_if:payout_cps_type,slaps',
            'payout_slaps.*.payout' => 'required_if:payout_cps_type,slaps',


        ]);

        $thumbnail = $offer->thumbnail;
        if ($request->has("thumbnail")) {
            Storage::disk('public')->delete('Images/Offers/' . $offer->thumbnail);
            $thumbnail = time() . rand(11111, 99999) . '.' . $request->thumbnail->extension();
            $request->thumbnail->storeAs('Images/Offers/', $thumbnail, 'public');
        }
        unset($data['thumbnail']);
        userActivity('Offer', $offer->id, 'update', $data, $offer);

        $offer->update([
            'name_en' => $request->name_en,
            'advertiser_id' => $request->advertiser_id,
            'description_en' => $request->description_en,
            'website' => $request->website,
            'thumbnail' => $thumbnail,
            'offer_url' => $request->offer_url,
            'status' => $request->status,
            'expire_date' => $request->expire_date,
            'note' => $request->note,
            'terms_and_conditions_en' => $request->terms_and_conditions_en,
            'currency_id' => $request->currency_id,
            'discount' => $request->discount,
            'revenue_cps_type' => $request->revenue_cps_type,
            'revenue_type' => $request->revenue_cps_type == 'static' ? $request->static_revenue_type : $request->new_old_revenue_type,
            'payout_cps_type' => $request->payout_cps_type,
            'payout_type' => $request->payout_cps_type == 'static' ? $request->static_payout_type : $request->new_old_payout_type,
        ]);

        if ($request->categories) {
            $offer->categories()->sync($request->categories);
        }

        if ($request->countries) {
            $offer->countries()->sync($request->countries);
        }

        $offer->cps()->delete();
        // If revenue_cps_type is static
        if ($request->revenue_cps_type == 'static') {
            if ($request->static_revenue && count($request->static_revenue) > 0) {
                foreach ($request->static_revenue as $staticRevenue) {
                    OfferCps::create([
                        'type' => 'revenue',
                        'cps_type' => 'static',
                        'amount_type' => $request->static_revenue_type,
                        'amount' => $staticRevenue['revenue'],
                        'date_range' => isset($staticRevenue['date_range']) && $staticRevenue['date_range'][0] == 'on' ? true : false,
                        'from_date' => $staticRevenue['from_date'] ?? null,
                        'to_date' => $staticRevenue['to_date'] ?? null,
                        'countries' => isset($staticRevenue['countries']) && $staticRevenue['countries'][0] == 'on' ? true : false,
                        'countries_ids' => isset($staticRevenue['countries_ids']) ? json_encode($staticRevenue['countries_ids'], JSON_NUMERIC_CHECK) : null,
                        'offer_id' => $offer->id,
                    ]);
                }
            }
        }

        // If revenue_cps_type is new_old
        if ($request->revenue_cps_type == 'new_old') {
            if ($request->new_old_revenue && count($request->new_old_revenue) > 0) {
                foreach ($request->new_old_revenue as $newOldRevenue) {
                    OfferCps::create([
                        'type' => 'revenue',
                        'cps_type' => 'new_old',
                        'amount_type' => $request->new_old_revenue_type,
                        'new_amount' => $newOldRevenue['new_revenue'],
                        'old_amount' => $newOldRevenue['old_revenue'],
                        'date_range' => isset($newOldRevenue['date_range']) &&  $newOldRevenue['date_range'][0] == 'on' ? true : false,
                        'from_date' => $newOldRevenue['from_date'] ?? null,
                        'to_date' => $newOldRevenue['to_date'] ?? null,
                        'countries' => isset($newOldRevenue['countries']) && $newOldRevenue['countries'][0] == 'on' ? true : false,
                        'countries_ids' => isset($newOldRevenue['countries_ids']) ? json_encode($newOldRevenue['countries_ids'], JSON_NUMERIC_CHECK) : null,
                        'offer_id' => $offer->id,
                    ]);
                }
            }
        }

        // If revenue_cps_type is slaps
        if ($request->revenue_cps_type == 'slaps') {
            if ($request->revenue_slaps && count($request->revenue_slaps) > 0) {
                foreach ($request->revenue_slaps as $slapsRevenue) {
                    OfferCps::create([
                        'type' => 'revenue',
                        'cps_type' => 'slaps',
                        'amount_type' => $request->static_revenue_type,
                        'amount' => $slapsRevenue['revenue'],
                        'from' => $slapsRevenue['from'] ?? null,
                        'to' => $slapsRevenue['to'] ?? null,
                        'offer_id' => $offer->id,
                    ]);
                }
            }
        }


        // If payout_cps_type is static
        if ($request->payout_cps_type == 'static') {
            if ($request->static_payout && count($request->static_payout) > 0) {
                foreach ($request->static_payout as $staticPayout) {
                    OfferCps::create([
                        'type' => 'payout',
                        'cps_type' => 'static',
                        'amount_type' => $request->static_payout_type,
                        'amount' => $staticPayout['payout'],
                        'date_range' => isset($staticPayout['date_range']) && $staticPayout['date_range'][0] == 'on' ? true : false,
                        'from_date' => $staticPayout['from_date'] ?? null,
                        'to_date' => $staticPayout['to_date'] ?? null,
                        'countries' => isset($staticPayout['countries']) && $staticPayout['countries'][0] == 'on' ? true : false,
                        'countries_ids' => isset($staticPayout['countries_ids']) ? json_encode($staticPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                        'offer_id' => $offer->id,
                    ]);
                }
            }
        }

        // If payout_cps_type is new_old
        if ($request->payout_cps_type == 'new_old') {
            if ($request->new_old_payout && count($request->new_old_payout) > 0) {
                foreach ($request->new_old_payout as $newOldPayout) {
                    OfferCps::create([
                        'type' => 'payout',
                        'cps_type' => 'new_old',
                        'amount_type' => $request->new_old_payout_type,
                        'new_amount' => $newOldPayout['new_payout'],
                        'old_amount' => $newOldPayout['old_payout'],
                        'date_range' => isset($newOldPayout['date_range']) && $newOldPayout['date_range'][0] == 'on' ? true : false,
                        'from_date' => $newOldPayout['from_date'] ?? null,
                        'to_date' => $newOldPayout['to_date'] ?? null,
                        'countries' => isset($newOldPayout['countries']) && $newOldPayout['countries'][0] == 'on' ? true : false,
                        'countries_ids' => isset($newOldPayout['countries_ids']) ? json_encode($newOldPayout['countries_ids'], JSON_NUMERIC_CHECK) : null,
                        'offer_id' => $offer->id,
                    ]);
                }
            }
        }

        // If payout_cps_type is slaps
        if ($request->payout_cps_type == 'slaps') {
            if ($request->payout_slaps && count($request->payout_slaps) > 0) {
                foreach ($request->payout_slaps as $slapsPayout) {
                    OfferCps::create([
                        'type' => 'payout',
                        'cps_type' => 'slaps',
                        'amount_type' => $request->static_payout_type,
                        'amount' => $slapsPayout['payout'],
                        'from' => $slapsPayout['from'] ?? null,
                        'to' => $slapsPayout['to'] ?? null,
                        'offer_id' => $offer->id,
                    ]);
                }
            }
        }



        // If this offer is with salla partener
        if ($request->partener == 'salla') {
            SallaFacade::assignSalaInfoToOffer($offer->salla_user_email, $offer->id);
        }

        $notification = [
            'message' => 'Updated successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('admin.offers.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Offer $offer)
    {
        $this->authorize('delete_offers');
        if ($request->ajax()) {
            userActivity('Offer', $offer->id, 'delete');
            Storage::disk('public')->delete('Images/Offers/' . $offer->thumbnail);
            $offer->delete();
        }
    }

    public function changeStatus(Request $request)
    {
        $this->authorize('update_offers');
        $offer = Offer::findOrFail($request->id);
        $offer->status = $request->status == 'active' ? 'active' : 'pused';
        $offer->save();
        return response()->json(['message' => 'Updated Succefuly']);
    }

    public function coupons(Request $request, $offer)
    {
        // ;
        if ($request->ajax()) {
            $coupons = Coupon::where('offer_id', $offer)->with(['offer', 'user'])->get();
            return DataTables::of($coupons)->make(true);
        }
    }

    public function clearFilterSeassoions()
    {
        session()->forget('offers_filter_status');
        session()->forget('offers_filter_revenue_cps_type');
        session()->forget('offers_filter_payout_cps_type');
        return redirect()->route('admin.offers.index');
    }
}
