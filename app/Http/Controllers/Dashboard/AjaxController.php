<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\User;
use App\Models\UserActivity;
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
            $coupons = [];
            $link = '';

            $offer = Offer::findOrFail($request->offer_id);
            if($offer->type == 'coupon_tracking'){
                $coupons = Coupon::where('user_id', auth()->user()->id)->where('offer_id', $request->offer_id)->get();
            }else{
                $link = $offer->offer_url.'?affiliate_id='.auth()->user()->id.'&offer_id='.$offer->id; 
            }
            return view('admin.modals.coupons', ['coupons' => $coupons, 'link' => $link]);
        }
    }

    public function viewActivityHistory(Request $request)
    {
        if ($request->ajax()){
            $activity = UserActivity::findOrFail($request->activityId);
            return view('admin.modals.activityHistory', ['activity' => $activity]);
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
