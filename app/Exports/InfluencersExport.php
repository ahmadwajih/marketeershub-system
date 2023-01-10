<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InfluencersExport implements FromCollection, WithHeadings, WithStartRow
{
    public array $data;
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            "Phone (18)",
            'Email',
            'Account Manager Email',
            'Gender',
            'Status',
            'Country',
            'Bank account title',
            'City',
            'Address',
            'Categories',
            "Digital Assets (9)",
            "Affiliate Networks (10)",
            "Category (11)",
            "Bank branch code (12)",
            "Bank name (13)",
            "Currency (14)",
            "Years of e experience (15)",
            "Iban (16)",
            "Swift code (17)",
            "Traffic sources used (19)",
            "AM (Email) (20)"
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
                'ID' => $datum[0],
                'Email' => $datum[1],
                'Full Name' => $datum[2],
                'Gender' => $datum[3],
                'Status' => $datum[4],
                'Bank account title' => $datum[5],
                'Validated Country' => $datum[6],
                'Un Validated Country' => $datum[7],
                'City' => $datum[8],
                'Digital Assets (9)' => $datum[9],
                'Affiliate Networks (10)' => $datum[10],
                'Category (11)' => $datum[11],
                'Bank branch code (12)' => $datum[12],
                'Bank name (13)' => $datum[13],
                "Currency (14)" => $datum[14],
                "Years of e experience (15)" => $datum[15],
                "Iban (16)" => $datum[16],
                "Swift code (17)" => $datum[17],
                "Phone (18)" => $datum[18],
                "Traffic sources used (19)" => $datum[19],
                "AM (Email) (20)" => $datum[20],
            ];
        }
        return collect($data);
    }
    public function startRow(): int
    {
        return 1;
    }
}
