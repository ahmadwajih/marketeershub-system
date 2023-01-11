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
            'City',
            'Address',
            'Categories',
            'Bank Account title ',
            'Bank Name',
            "Bank branch code (12)",
            "Swift code (17)",
            "Iban (16)",
            "Currency (14)",
            'Facebook Link ',
            'Facebook Number Of Followers',

            'Instagram Link',
            "Instagram Number Of Followers",

            'Twitter Link',
            "Twitter Number Of Followers",

            'Snapchat Link',
            "Snapchat Number Of Followers",

            'Tiktok Link',
            "Tiktok Number Of Followers",

            'Youtube Link',
            "Youtube Number Of Followers",
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
                'ID' =>$datum[0],
                'Name' =>$datum[1],
                "Phone (18)" =>$datum[2],
                'Email' =>$datum[3],
                'Account Manager Email' =>$datum[4],
                'Gender' =>$datum[5],
                'Status' =>$datum[6],
                'Country' =>$datum[7],
                'City' =>$datum[8],
                'Address' =>$datum[9],
                'Categories' =>$datum[10],
                'Bank Account title ' =>$datum[11],
                'Bank Name' =>$datum[12],
                "Bank branch code (12)" =>$datum[13],
                "Swift code (17)" =>$datum[14],
                "Iban (16)" =>$datum[15],
                "Currency (14)" =>$datum[16],
                'Facebook Link ' =>$datum[17],
                'Facebook Number Of Followers' =>$datum[18],
                'Instagram Link' =>$datum[19],
                "Instagram Number Of Followers" =>$datum[20],
                'Twitter Link' =>$datum[21],
                "Twitter Number Of Followers" =>$datum[22],

                'Snapchat Link' =>$datum[23],
                "Snapchat Number Of Followers" =>$datum[24],

                'Tiktok Link' =>$datum[25],
                "Tiktok Number Of Followers" =>$datum[26],

                'Youtube Link' =>$datum[27],
                "Youtube Number Of Followers" =>$datum[28],
            ];
        }
        return collect($data);
    }
    public function startRow(): int
    {
        return 1;
    }
}
