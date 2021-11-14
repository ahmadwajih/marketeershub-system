
<?php

use App\Models\OfferRequest;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
/**
 * Get Model Data To data Table .
 * Author : Wageh
 * created By Wageh
 */
if(!function_exists('getModelData')){
    function getModelData($model, Request $request , $relations = [], $where = array( ['id', '!=', 0]), $trashed = false)
    {
        $model = app('\\App\Models\\' . $model);
        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        $model   = $model->query();
        if($trashed){
            $model = $model->onlyTrashed();
        }

        // Define the page and number of items per page
        $page = 1;
        $per_page = 10;

        // Define the default order
        $order_field = 'id';
        $order_sort = 'DESC';

        // Get the request parameters
        $params = $request->all();
        // Set the current page
        if(isset($params['pagination']['page'])) {
            $page = $params['pagination']['page'];
        }

        // Set the number of items
        if(isset($params['pagination']['perpage'])) {
            $per_page = $params['pagination']['perpage'];
        }

        // Set the search filter
        if(isset($params['query']['generalSearch'])) {
            foreach ($columns as $column){
                $model->orWhere($column, 'LIKE', "%" . $params['query']['generalSearch'] . "%");
            }
        }


        // Set the sort order and field
        if(isset($params['sort']['field'])) {
            $order_field = $params['sort']['field'];
            $order_sort = $params['sort']['sort'];
        }

        // Get how many items there should be
        $total = $model->count();
        $total = $model->where($where)->limit($per_page)->count();
//            ->where($where['column'], $where['operation'], $where['value'])

        // Get the items defined by the parameters
        $results = $model->skip(($page - 1) * $per_page)
            ->where($where)
            ->take($per_page)->orderBy('id', 'DESC')
            ->get();


        $response = [
            'meta' => [
                "page" => $page,
                "pages" => ceil($total / $per_page),
                "perpage" => $per_page,
                "total" => $total,
                "sort" => $order_sort,
                "field" => $order_field
            ],
            
            'data' => $model->with($relations)->where($where)->orderBy('id', 'ASC')->get()
        ];

        return $response;
    }
}
/*
    * Return offer request data
     * @param  String Route Namw 
     * @return array
     * Author : Wageh 
     * created By Wageh
*/
if(!function_exists('getOfferRequest')){
    function getOfferRequest(int $offerId){
        $offerRequest = OfferRequest::where('user_id', auth()->user()->id)->where('offer_id', $offerId)->first();
        return $offerRequest;
    }
}

if(!function_exists('getImagesPath')){
    function getImagesPath($model, $imageName = null){
        $model =  Str::ucfirst(Str::plural($model));
        if(!$imageName){
            $imageName = 'default.png';
        }
        return asset('/storage/Images').'/'.$model.'/'.$imageName;
    }
}



if(!function_exists('uploadImage')){

    function uploadImage($request, $model){
        $path         = "/Images/".$model;
        $originalName =  $request->getClientOriginalName(); // Get file Original Name
        $imageName    = 'MH-'.time().rand(11111,99999).$originalName;  // Set Image name based on user name and time
        $request->storeAs($path, $imageName,'public');
        return $imageName;
    }
}

if(!function_exists('deleteImage')){

    function deleteImage($imageName, $model){
        $path = "/Images/".$model.'/'.$imageName;
        Storage::disk('public')->delete($path);
    }
}


/**
 * Function Name : userActivity 
 * Authr: Wageh
 * create at : 3/11/2021
 * Usage: create user activity 
 * parameters : object_name, object_id
 */
if(!function_exists('userActivity')){
    function userActivity($object, $objectId, $mission, $note = null, $userId=null){
        if(!$userId){
            $userId = auth()->user()->id;
        }
        $exists = UserActivity::where([
            ['user_id' , '=', $userId],
            ['mission' , '=', $mission],
            ['object' , '=', $object],
            ['object_id' , '=', $objectId],
        ])->first();
        if(!$exists){
            UserActivity::create([
                'user_id' => $userId,
                'mission' => $mission,
                'object' => $object,
                'object_id' => $objectId,
                'note' => $note,
            ]);
        }
        
        return true;
    }
}