
<?php 

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
    function getModelData($model, Request $request , $relations = [], $trashed = false)
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
        $order_sort = 'desc';

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
        $total = $model->limit($per_page)->count();

        // Get the items defined by the parameters
        $results = $model->skip(($page - 1) * $per_page)
            ->take($per_page)->orderBy($order_field, $order_sort)
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
            'data' => $model->with($relations)->get()
        ];

        return $response;
    }
}