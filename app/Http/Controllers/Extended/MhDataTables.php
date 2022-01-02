<?php
/**
 *
 * Created by PhpStorm.
 * User: Abdul Shakoor
 * Date: 12/28/21
 * Time: 12:05 PM
 */

namespace App\Http\Controllers\Extended;

use Yajra\DataTables\DataTables;
use Yajra\DataTables\QueryDataTable;

class MhDataTables extends DataTables
{
    public function query($builder)
    {
        dd($builder);
        return QueryDataTable::create($builder);
    }
}
