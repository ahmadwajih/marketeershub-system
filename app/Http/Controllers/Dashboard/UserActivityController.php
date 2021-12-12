<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $activities = UserActivity::all();
        // dd($activities[0]->element);
        $this->authorize('view_user_activities');
        if($request->ajax()){
            $activities = getModelData('UserActivity', $request, ['user']);
            return response()->json($activities);
        }
        return view('admin.activities.index');

    }
}
