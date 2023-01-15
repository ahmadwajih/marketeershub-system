<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PivotReportErrorsExport implements FromArray, WithHeadings
{
    public $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
    }
    public function array(): array
    {
        return $this->errors;
    }
    public function headings(): array
    {
        return [
            'Date',
            'Coupon',
            'Orders',
            'Sales',
            'New',
            'Old',
            'Country',
            'Error Message',
        ];
    }
}
