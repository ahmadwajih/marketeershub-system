<?php

namespace App\Repository;

interface UserRepositoryInterface extends EloquentRepositoryInterface {
    public function getDataTableByPosition(string $position);
}
