<?php

namespace App\Repository\Eloquent;

use App\Repository\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BaseRepository implements EloquentRepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    protected $request;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     * @param Request $request
     */
    public function __construct(
        Model $model,
        Request $request
    ) {
        $this->model   = $model;
        $this->request = $request;
    }

    /**
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->model->with($relations)->get($columns);
    }

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * Find model by id.
     *
     * @param int $id
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model
     */
    public function findById(
        int $id,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->findOrFail($id)->append($appends);
    }

    /**
     * Find trashed model by id.
     *
     * @param int $id
     * @return Model
     */
    public function findTrashedById(int $id): ?Model
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    /**
     * Find only trashed model by id.
     *
     * @param int $id
     * @return Model
     */
    public function findOnlyTrashedById(int $id): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($id);
    }

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model
    {
        $model = $this->model->create($payload);

        return $model->fresh();
    }

    /**
     * Update existing model.
     *
     * @param int $id
     * @param array $payload
     * @return bool
     */
    public function update(int $id, array $payload): bool
    {
        $model = $this->findById($id);

        return $model->update($payload);
    }

    /**
     * Delete model by id.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool
    {
        return $this->findById($id)->delete();
    }

    /**
     * Restore model by id.
     *
     * @param int $id
     * @return bool
     */
    public function restoreById(int $id): bool
    {
        return $this->findOnlyTrashedById($id)->restore();
    }

    /**
     * Permanently delete model by id.
     *
     * @param int $id
     * @return bool
     */
    public function permanentlyDeleteById(int $id): bool
    {
        return $this->findTrashedById($id)->forceDelete();
    }

    /**
     * @param $options
     * @return array|mixed
     */
    public function getDataTable(array $options)
    {
        $options = array_merge([
            'filter' => [['id', '!=', 0]],
            'relation' => [],
            'columns' => [],
            'trashed' => false
        ], $options);

        $request  = $this->request;
        $filter   = $options['filter'];
        $relation = $options['relation'];
        $trashed  = $options['trashed'];

        if (empty($options['columns'])) {
            $columns = $this->model->getConnection()->getSchemaBuilder()->getColumnListing($this->model->getTable());
        } else {
            $columns = $options['columns'];
        }

        $model = $this->model->where($filter);

        if ($trashed) {
            $model->onlyTrashed();
        }

        if (!empty($relation)) {
            $model->with($relation);
        }

        // Define the page and number of items per page
        $page     = 1;
        $per_page = 10;

        // Define the default order
        $order_field = 'id';
        $order_sort  = 'desc';

        // Get the request parameters
        $params = $request->all();

        // Set the search filter
        if (isset($params['query']['generalSearch'])) {
            $model->where(function ($query) use ($params, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere([[$column, 'LIKE', "%" . $params['query']['generalSearch'] . "%"]]);
                }
            });
        }

        // Set the current page
        if (isset($params['pagination']['page'])) {
            $page = $params['pagination']['page'];
        }

        // Set the number of items
        if (isset($params['pagination']['perpage'])) {
            $per_page = $params['pagination']['perpage'];
            $model->limit($per_page);
        }

        // Set the sort order and field
        if (isset($params['sort']['field'])) {
            $order_field = $params['sort']['field'];
            $order_sort  = $params['sort']['sort'];
            $model->orderBy($order_field, $order_sort);
        }

        // Get how many items there should be
        $total = $model->count();

        return [
            'meta' => [
                "page" => $page,
                "pages" => ceil($total / $per_page),
                "perpage" => $per_page,
                "total" => $total,
                "sort" => $order_sort,
                "field" => $order_field
            ],
            'data' => empty($options['transform']) ? $model->get() : $model->get()->transform($options['transform'])
        ];
    }
}
