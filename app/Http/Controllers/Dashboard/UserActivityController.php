<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
        $this->authorize('view_userActivities');
        if($request->ajax()){
            $activities = getModelData('UserActivity', $request, ['user']);
            return response()->json($activities);
        }
        return view('admin.activities.index');

    }
}
