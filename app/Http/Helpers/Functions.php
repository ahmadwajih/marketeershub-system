
<?php

use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\OfferRequest;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

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
        $orderFieldIsRelation = strpos($order_field, ".") !== false;


        if ($orderFieldIsRelation){

            $orderRelation = explode(".", $order_field)[0];
            $orderField = explode(".", $order_field)[1];

            $model->whereHas($orderRelation, function (Builder $query) use ($orderField ,$order_sort){
                $query->orderBy($orderField, $order_sort);
            });

        }else{

            $model->orderBy($order_field, $order_sort);
        }


        $results = $model->skip(($page - 1) * $per_page)
            ->where($where)
            ->take($per_page)
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

            'data' => $model->with($relations)->where($where)->get()
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
    function userActivity($object, $objectId, $mission, $data = [], $oldObject = null,  $note = null, $userId=null){

        if(!$userId){
            $userId = auth()->user()->id;
        }
        $fieldsistory = [] ;
        if($oldObject){
            $history = array_diff_assoc($data, $oldObject->toArray());
            $chachedFields  = array_keys($history);
            foreach($chachedFields as $field){
                $fieldsistory[$field]['old'] = $oldObject[$field];
                $fieldsistory[$field]['new'] = $history[$field];

            }
        }

        $exists = UserActivity::where([
            ['user_id' , '=', $userId],
            ['mission' , '=', $mission],
            ['object' , '=', $object],
            ['object_id' , '=', $objectId],
            ['history' , '=', serialize($fieldsistory)],
        ])->first();
        if(!$exists){
            UserActivity::create([
                'user_id' => $userId,
                'mission' => $mission,
                'object' => $object,
                'object_id' => $objectId,
                'note' => $note,
                'history' => serialize($fieldsistory),
            ]);
        }

        return true;
    }
}

/**
 * Function Name : userActivity
 * Authr: Wageh
 * create at : 3/11/2021
 * Usage: create user activity
 * parameters : object_name, object_id
 */
if(!function_exists('getActivity')){
    function getActivity($object, $objectId){
        $activitiees = UserActivity::where([
            ['object' , '=', $object],
            ['object_id' , '=', $objectId],
        ])->orderBy('id', 'desc')->get();

        return $activitiees;
    }
}

if(!function_exists('getCountryId')){
    function getCountryId($countryName):int
    {
        $country = Country::where('name_en', 'like', '%'.$countryName.'%')->orWhere('name_ar', 'like', '%'.$countryName.'%')->first();
        if($country){
            return $country->id;
        }
        return Country::first()->id;
    }
}

if(!function_exists('getCityId')){
    function getCityId($cityName):int
    {
        $city = City::where('name_en', 'like', '%'.$cityName.'%')->orWhere('name_ar', 'like', '%'.$cityName.'%')->first();
        if($city){
            return $city->id;
        }
        return City::first()->id;
    }
}

if(!function_exists('getCurrency')){
    function getCurrency($currencyName):int
    {
        $currency = Currency::where('name_en', 'like', '%'.$currencyName.'%')
        ->orWhere('name_ar', 'like', '%'.$currencyName.'%')
        ->orWhere('code', 'like', '%'.$currencyName.'%')
        ->orWhere('sign', 'like', '%'.$currencyName.'%')
        ->first();

        if($currency){
            return $currency->id;
        }
        return Currency::first()->id;
    }
}

if(!function_exists('assetsId')) {
    function assetsId()
    {
        $cacheKey = 'static_assets_id';
        $id       = now()->timestamp;

        if (env('APP_ENV') === 'production' and Cache::has($cacheKey)) {
            return Cache::get('static_assets_id');
        }

        Cache::put($cacheKey, $id, now()->addYear());
        return $id;
    }
}
