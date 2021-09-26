
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
//            ->where($where['column'], $where['operation'], $where['value'])

        // Get the items defined by the parameters
        $results = $model->skip(($page - 1) * $per_page)
            ->where($where)
            ->take($per_page)->orderBy('id', 'desc')
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

/*
    * Return rote url text after hosting to use it in js index to make the url daynamic .
     * @param  String Route Namw 
     * @return url
     * Author : Wageh 
     * created By Wagih
*/
if(!function_exists('getUrlAfterDomain')){
    function getUrlAfterDomain(string $route){
        $host = parse_url(request()->root())['host'];
        $scheme = parse_url(request()->root())['scheme'];
        $fullDomain = $scheme."://".$host;
        $url = str_replace($fullDomain,'',$route);
        return $url;
    }
}