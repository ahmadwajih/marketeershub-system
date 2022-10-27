<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrashedController extends Controller
{
    public function index(Request $request){

        $this->authorize('view_trashed');
        if (isset($request->table_length) && $request->table_length  != null) {
            session()->put('trashed_table_length', $request->table_length);
        }
        if (session()->has('trashed_table_length') == false) {
            session()->put('trashed_table_length', config('app.pagination_pages'));
        }
        $tableLength = session('trashed_table_length');

        if($request->model == 'users'){
            $users = User::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($tableLength);
            return view('new_admin.users.index', ['users' => $users]);
        }

        return view('dashboard.'.$plural.'.index', ['']);
    }

     /**
     * restore the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $model, $id)
    {
        
        can('update_admins') ?: abort(401);

            $model = Str::of($model)->trim();
            $model = Str::ucfirst($model);
            $uppaerModel = Str::ucfirst($model);
            $singularModel = Str::singular($model);
            $model = "App\Models\\".$singularModel;
            
            $model::withTrashed()->find($id)->restore();

            restoreTranslations($id, Str::singular($uppaerModel));
            $notification = array(
                'message' => 'تم الاسترجاع بنجاح. ',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);


    }

    /**
     * Force Delete the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Request $request, $model, $id)
    {
        can('delete_admins') ?: abort(401);
        $model = Str::of($model)->trim();
            $model = Str::ucfirst($model);
            $uppaerModel = Str::ucfirst($model);
            $plural = Str::plural($model);
            $model = "App\Models\\".Str::singular($model);

            $object = $model::withTrashed()->find($id);
            forceDeleteTranslations($id, Str::singular($uppaerModel));
            if(isset($object->image)){
                deleteImage($object->image, $plural);
            }
       
            if($plural == "Users"){
                try {
                    $cPanel = new cPanel(env('CPANEL_USERNAME') , env('CPANEL_PASSWORD') , env('CPANEL_IP'));
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
                
                // Delete subdomain
                // $subdomainParameters = [
                //     'domain' =>strtolower($object->subdomain_name.".vatrena.store"),
                // ];
                // Delete Database
                $databaseParameters = [
                    'name' =>$object->db_name,
                ];
                // Delete Database User
                $databaseUserParameters = [
                    'name' =>$object->db_username,
                ];

                // $delsubdomain = $cPanel->api2('SubDomain', 'delsubdomain',$subdomainParameters);
                $mysql = $cPanel->uapi('Mysql','delete_database',$databaseParameters);
                $user = $cPanel->uapi('Mysql','delete_user',$databaseUserParameters);
            }

            $object->forceDelete();
            $notification = array(
                'message' => 'تم الحذف بنجاح. ',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);

    }
}
