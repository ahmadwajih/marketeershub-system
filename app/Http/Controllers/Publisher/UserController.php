<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Carbon\Carbon;
use App\Facades\PublisherProfile;
use Illuminate\Support\Collection;
use App\Facades\PublisherCharts;
use App\Models\Coupon;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
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
        $couponsRevenueChart = PublisherCharts::chart($chartCoupons, 'coupon', 'revenue', 'bar', 'Coupons');
        // dd($childrens);
        $assignedCoupons = Coupon::whereIn('user_id', $childrens)->get();
        $couponsFromReports = new Collection($coupons);
        $assignedCoupons = new Collection($assignedCoupons);
        $coupons = $assignedCoupons->merge($couponsFromReports); // Contains foo and bar.
        return view('publishers.users.profile', [
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
            'coupons' => $coupons->unique(),
        ]);
    }

    public function edit_profile()
    {
        $id = auth()->id();

        if (auth()->user()->id != $id && !in_array($id, auth()->user()->childrens()->pluck('id')->toArray())) {
            $this->authorize('update_publishers');
        }
        $accountManagers = User::where('position', 'account_manager')->get();
        $publisher = User::findOrFail($id);
        if ($publisher->position != 'publisher') {
            return redirect()->route('admin.users.edit', $id);
        }
        $publisher->traffic_sources = explode(',', $publisher->traffic_sources);
        return view('publishers.publishers.edit', [
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
}
