
<?php

use App\Exports\PivotReportErrorsExport;
use App\Models\Category;
use App\Models\Chat;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\OfferRequest;
use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Get Model Data To data Table .
 * Author : Wageh
 * created By Wageh
 */
if (!function_exists('getModelData')) {
    function getModelData($model, Request $request, $relations = [], $where = array(['id', '!=', 0]), $trashed = false)
    {

        $model = app('\\App\Models\\' . $model);
        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        $model   = $model->query();
        if ($trashed) {
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
        if (isset($params['pagination']['page'])) {
            $page = $params['pagination']['page'];
        }

        // Set the number of items
        if (isset($params['pagination']['perpage'])) {
            $per_page = $params['pagination']['perpage'];
        }

        // Set the search filter
        if (isset($params['query']['generalSearch'])) {
            foreach ($columns as $column) {
                $model->orWhere($column, 'LIKE', "%" . $params['query']['generalSearch'] . "%");
            }
        }

        // Set the search filter
        if (isset($request['query']['offer_id'])) {
            $model->orWhere('offer_id', $request['query']['offer_id']);
        }


        // Set the sort order and field
        if (isset($params['sort']['field'])) {
            $order_field = $params['sort']['field'];
            $order_sort = $params['sort']['sort'];
        }

        // Get how many items there should be
        $total = $model->count();
        $total = $model->where($where)->limit($per_page)->count();
        //            ->where($where['column'], $where['operation'], $where['value'])

        // Get the items defined by the parameters
        $orderFieldIsRelation = strpos($order_field, ".") !== false;


        if ($orderFieldIsRelation) {

            $orderRelation = explode(".", $order_field)[0];
            $orderField = explode(".", $order_field)[1];

            $model->whereHas($orderRelation, function (Builder $query) use ($orderField, $order_sort) {
                $query->orderBy($orderField, $order_sort);
            });
        } else {

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
if (!function_exists('getOfferRequest')) {
    function getOfferRequest(int $offerId)
    {
        $offerRequest = OfferRequest::where('user_id', auth()->user()->id)->where('offer_id', $offerId)->first();
        return $offerRequest;
    }
}

if (!function_exists('getImagesPath')) {
    function getImagesPath($model, $imageName = null)
    {
        $model =  Str::ucfirst(Str::plural($model));
        if (!$imageName) {
            $imageName = 'default.png';
        }
        return asset('/storage/Images') . '/' . $model . '/' . $imageName;
    }
}



if (!function_exists('uploadImage')) {

    function uploadImage($request, $model, $isPrefixed = true)
    {
        $path         = "/Images/" . $model;
        $originalName =  $request->getClientOriginalName(); // Get file Original Name
        $prefix = null;
        if($isPrefixed){
            $prefix = 'MH-' . time() . rand(11111, 99999);
        }
        $imageName    = $prefix . $originalName;  // Set Image name based on user name and time
        $request->storeAs($path, $imageName, 'public');
        return $imageName;
    }
}

if (!function_exists('deleteImage')) {

    function deleteImage($imageName, $model)
    {
        $path = "/Images/" . $model . '/' . $imageName;
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
if (!function_exists('userActivity')) {
    function userActivity($object, $objectId, $mission, $data = [], $oldObject = null,  $note = null, $approved = true, $userId = null)
    {

        if (!$userId) {
            $userId = auth()->user()->id;
        }
        $fieldsistory = [];
        if ($oldObject) {
            $history = array_diff_assoc($data, $oldObject->toArray());
            $chachedFields  = array_keys($history);
            foreach ($chachedFields as $field) {
                $fieldsistory[$field]['old'] = $oldObject[$field];
                $fieldsistory[$field]['new'] = $history[$field];
            }
        }

        $exists = UserActivity::where([
            ['user_id', '=', $userId],
            ['mission', '=', $mission],
            ['object', '=', $object],
            ['object_id', '=', $objectId],
            ['approved', '=', $approved],
            ['history', '=', serialize($fieldsistory)],
        ])->first();
        if (!$exists) {
            UserActivity::create([
                'user_id' => $userId,
                'mission' => $mission,
                'object' => $object,
                'object_id' => $objectId,
                'note' => $note,
                'approved' => $approved,
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
if (!function_exists('getActivity')) {
    function getActivity($object, $objectId)
    {
        $activitiees = UserActivity::where([
            ['object', '=', $object],
            ['object_id', '=', $objectId],
        ])->orderBy('id', 'desc')->get();

        return $activitiees;
    }
}

if (!function_exists('getCountryId')) {
    function getCountryId($countryName): int
    {
        $country = Country::where('name_en', 'like', '%' . $countryName . '%')->orWhere('name_ar', 'like', '%' . $countryName . '%')->first();
        if ($country) {
            return $country->id;
        }
        return Country::first()->id;
    }
}

if (!function_exists('getCategoryId')) {
    function getCategoryId($categoryName)
    {
        $category = Category::where('title_en', 'like', '%' . $categoryName . '%')->orWhere('title_ar', 'like', '%' . $categoryName . '%')->first();
        if ($category) {
            return $category->id;
        }
        return null;
    }
}

if (!function_exists('getCityId')) {
    function getCityId($cityName)
    {
        $city = City::where('name_en', 'like', '%' . $cityName . '%')->orWhere('name_ar', 'like', '%' . $cityName . '%')->first();
        if ($city) {
            return $city->id;
        }
        return null;
    }
}

if (!function_exists('getCountryName')) {
    function getCountryName($countryId): int
    {
        $country = Country::find($countryId);
        if ($country) {
            return $country->name;
        }
        return Country::first()->name;
    }
}

if (!function_exists('getCityName')) {
    function getCityName($cityId): int
    {
        $city = City::find($cityId);
        if ($city) {
            return $city->name;
        }
        return City::first()->name;
    }
}

if (!function_exists('getCurrency')) {
    function getCurrency($currencyName): int
    {
        $currency = Currency::where('name_en', 'like', '%' . $currencyName . '%')
            ->orWhere('name_ar', 'like', '%' . $currencyName . '%')
            ->orWhere('code', 'like', '%' . $currencyName . '%')
            ->orWhere('sign', 'like', '%' . $currencyName . '%')
            ->first();

        if ($currency) {
            return $currency->id;
        }
        return Currency::first()->id;
    }
}

if (!function_exists('assetsId')) {
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


if (!function_exists('unSeenMessages')) {
    function unSeenMessages()
    {
        $unSeenMessagesCount = Chat::where([
            ['receiver_id', '=', auth()->user()->id],
            ['seen', '=', false],
        ])->count();
        return $unSeenMessagesCount;
    }
}

if (!function_exists('marketersHubPublisherInfo')) {
    function marketersHubPublisherInfo()
    {
        $marketersHubPublisherInfo = User::whereEmail('info@marketeershub.com')->first();
        return $marketersHubPublisherInfo;
    }
}

if (!function_exists('userChildrens')) {
    function userChildrens($user = null, $childrens = [], bool $provideMyId = true)
    {
        $user = ($user == null) ? auth()->user() : $user;

        $index = 0;
        if ($user->childrens->count() > 0) {
            while ($index < $user->childrens->count()) {
                $childrens[] = $user->childrens[$index]['id'];
                userChildrens($user->childrens[$index]) ?  $childrens = array_merge($childrens, userChildrens($user->childrens[$index])) : '';
                $index++;
            }
        } else {
            return [];
        }


        if ($provideMyId) {
            array_push($childrens, auth()->user()->id);
        }

        return $childrens;
    }
}

if (!function_exists('usersCounter')) {
    function usersCounter()
    {
        $secends = 60 * 60 * 15;
        if (!cache('usersCount')) {
            $all =  User::count();
            $inReview = User::where('account_status', 'in_review')->count();
            $approved = User::where('account_status', 'approved')->count();
            $rejected = User::where('account_status', 'rejected')->count();
            $data = [
                'all' => $all,
                'in_review' => $inReview,
                'approved' => $approved,
                'rejected' => $rejected,
            ];
            cache(['usersCount' => $data], $secends);
        }

        return cache('usersCount');
    }
}

if (!function_exists('positionRankCheck')) {
    function positionRankCheck($position1, $position2)
    {
        $super_admin = 0;
        $head = -1;
        $team_leader = -2;
        $account_manager = -3;
        $employee = -4;
        $publisher = -5;

        if ($$position1 >= $$position2) {
            return true;
        } else {
            return false;
        }
    }
}

