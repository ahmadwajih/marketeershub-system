<?php

namespace App\Exports;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Modules\Acl\Entities\Influencer;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AffiliatesExport implements FromCollection, WithHeadings, WithStartRow
{
    public array $data;
    public function headings(): array
    {
        return [
            'English',
            'Arabic',
            'Link',
            'Category',
            'Errors'
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
                'English' => $datum[0],
                'Arabic' => $datum[1],
                'Link' => $datum[2],
                'Category' => $datum[3],
                'Errors' => $datum[4] ?? ""
            ];
        }

        return collect($data);
    }

    public function startRow(): int
    {
        return 1;
    }
}
