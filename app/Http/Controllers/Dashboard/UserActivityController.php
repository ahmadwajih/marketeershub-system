<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\UserActivity;
use App\Notifications\ApprovedUserProfileUpdates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class UserActivityController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_user_activities');
        if($request->ajax()){
            $activities = getModelData('UserActivity', $request, ['user']);
            return response()->json($activities);
        }
        return view('admin.activities.index');

    }

    public function updateUserActivityApproval(Request $request){
        $this->authorize('update_user_activities');
        $request->validate([
            "object" => 'required|max:255',
            "object_id" => 'required|numeric',
            "user_id" => 'required|numeric',
            "activity_id" => 'required|numeric',
            "keys" => 'required|array',
            "values" => 'required|array',
            "keys.*" => 'required',
            "values.*" => 'required',
        ]);

        $model = "App\Models\\".$request->object;
        $object = $model::findOrFail($request->object_id);
       
        $data = [];
        foreach($request->keys as $index => $key){
            $data[$key] = $request->values[$index];
        }
        $object->update($data);

        $activity = UserActivity::findOrFail($request->activity_id);
        $activity->approved = true;
        $activity->approved_by = auth()->user()->id;
        $activity->save();
        try {
            Notification::send($object, new ApprovedUserProfileUpdates($object));
        } catch (\Throwable $th) {
            Log::debug($th);
        }
        

        return redirect()->back();

    }
}
