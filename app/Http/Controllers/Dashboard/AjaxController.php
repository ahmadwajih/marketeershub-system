<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
     /**
     * return list of cities based on country id
     *
     * @return \Illuminate\Http\Response
     */
    public function cities(Request $request)
    {
        // $this->authorize('view_cities') ?: abort(401);
        if ($request->ajax()){
            $cities = City::where('country_id', $request->countryId)->get();
            return view('dashboard.ajax.cities', ['cities' => $cities]);
        }
    }

}
