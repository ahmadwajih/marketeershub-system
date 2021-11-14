<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
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
            return view('admin.ajax.cities', ['cities' => $cities]);
        }
    }

    public function viewCoupons(Request $request)
    {
        if ($request->ajax()){
            $coupons = Coupon::where('user_id', auth()->user()->id)->where('offer_id', $request->offerId)->get();
            return view('admin.modals.coupons', ['coupons' => $coupons]);
        }
    }

    public function accountManagers(Request $request)
    {
        if ($request->ajax()){
            $users = User::where('position', 'account_manager')
            ->whereStatus('active')
            ->where('team', $request->team)->get();
            return view('admin.ajax.options', ['options' => $users]);
        }
    }

    public function readNotifications(){
        auth()->user()->unreadNotifications->markAsRead();
    }

}
