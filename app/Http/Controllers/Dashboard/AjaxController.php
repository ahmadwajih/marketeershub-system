<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Coupon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Financial\Coupons;

class AjaxController extends Controller
{
     /**
     * return list of cities based on country id
     *
     * @return \Illuminate\Http\Response
     */
    public function cities(Request $request)
    {
        if ($request->ajax()){
            $cities = City::where('country_id', $request->countryId)->get();
            return view('dashboard.ajax.cities', ['cities' => $cities]);
        }
    }

    public function viewCoupons(Request $request)
    {
        if ($request->ajax()){
            $coupons = Coupon::where('user_id', auth()->user()->id)->where('offer_id', $request->offerId)->get();
            return view('dashboard.modals.coupons', ['coupons' => $coupons]);
        }
    }

}
