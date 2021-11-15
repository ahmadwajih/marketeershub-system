<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected $model;
    protected $request;

    /**
     * BaseRepository constructor.
     *
     * @param User $user
     * @param Request $request
     */
    public function __construct(
        User $user,
        Request $request
    ) {
        $this->model   = $user;
        $this->request = $request;
    }

    /**
     * @param string $position
     * @return array|mixed
     */
    public function getDataTableByPosition(string $position)
    {
        return $this->getDataTable([
            'filter' => [['position', $position]],
            'relation' => ['parent', 'offers'],
            'transform' => function ($item) {
                $offers = $item->offers();
                $categories = $offers->with('categories')
                    ->get()
                    ->transform(function ($item) {
                        return $item->categories()->select('title', 'id')->pluck('title')->implode(', ');
                    });
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'type' => 'aaa',
                    'traffic_sources' => 'sss',
                    'category' => $categories,
                    'offers' => __('<a href=":route" data-remote="false" data-toggle="modal" data-target="#bs_modal" class="btn btn-sm btn-default" style="padding-bottom: 0.3em">:count</a>',
                        [
                            'count' => $offers->count(),
                            'route' => route('dashboard.ajax.view.offers', $item->id)
                        ]
                    ),
                    'manager' => $item->parent->name,
                    'status' => $item->status,
                ];
            }
        ]);
    }
}
