<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    /**
     * Get all models.
     *
     * @param array $columns
     * @param array $relations
     * @return Collection
     */
    public function all(array $columns = ['*'], array $relations = []): Collection;

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection;

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
    ): ?Model;

    /**
     * Find trashed model by id.
     *
     * @param int $id
     * @return Model
     */
    public function findTrashedById(int $id): ?Model;

    /**
     * Find only trashed model by id.
     *
     * @param int $id
     * @return Model
     */
    public function findOnlyTrashedById(int $id): ?Model;

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model;

    /**
     * Update existing model.
     *
     * @param int $id
     * @param array $payload
     * @return bool
     */
    public function update(int $id, array $payload): bool;

    /**
     * Delete model by id.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * Restore model by id.
     *
     * @param int $id
     * @return bool
     */
    public function restoreById(int $id): bool;

    /**
     * Permanently delete model by id.
     *
     * @param int $id
     * @return bool
     */
    public function permanentlyDeleteById(int $id): bool;


    /**
     * @param array $options
     * @return mixed
     */
    public function getDataTable(array $options);
}
