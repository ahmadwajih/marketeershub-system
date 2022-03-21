<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class NotFoundUsersInInUploadPayemntSheetExport implements FromArray
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $publishers;

    public function __construct(array $publishers)
    {
        $this->publishers = $publishers;
    }

    public function array(): array
    {
        return $this->publishers;
    }
}
