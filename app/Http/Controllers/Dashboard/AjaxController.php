<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
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
        if ($request->ajax()) {
            $cities = City::where('country_id', $request->countryId)->get();
            return view('new_admin.components.option', [
                'title' => "Select City",
                "items" => $cities
            ]);
        }
    }


    public function viewActivityHistory(Request $request)
    {
        if ($request->ajax()) {
            $activity = UserActivity::findOrFail($request->activityId);
            return view('admin.modals.activityHistory', ['activity' => $activity]);
        }
    }

    public function accountManagers(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('position', 'account_manager')
                ->whereStatus('active')
                ->where('team', $request->team)->get();
            return view('admin.ajax.options', ['options' => $users]);
        }
    }

    public function getCategoriesBasedOnTeam(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::where('type', $request->team)->get();
            return view('admin.ajax.categories_option', ['options' => $categories]);
        }
    }

    public function readNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function getAccountManagersBasedOnTeam(Request $request)
    {
        if ($request->ajax()) {
            $accountManagers = User::where('position', 'account_manager')->where('team', $request->team)->get();
            return view('new_admin.components.option', [
                'title' => "Select Referral",
                "items" => $accountManagers
            ]);
        }
    }
}
