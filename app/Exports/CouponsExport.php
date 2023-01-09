<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CouponsExport implements FromCollection, WithHeadings, WithStartRow
{
    public array $data;
    public function headings(): array
    {
        return [
            'Coupon Code (Required)',
            'Publisher ID (optional)',
        ];
    }

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection(): Collection
    {
        $data = [];

        foreach ($this->data as $datum) {
            $data [] = [
                'Coupon Code (Required)' => $datum[0],
                'Publisher ID (optional)' => $datum[1],
            ];
        }
        return collect($data);
    }
    public function startRow(): int
    {
        return 1;
    }
}
