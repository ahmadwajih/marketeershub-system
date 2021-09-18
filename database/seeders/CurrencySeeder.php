<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                'name' => 'Riyal Saudi',
                'code' => 'SAR',
                'sign' => 'SAR',
            ],
            [
                'name' => 'Egyptian pound',
                'code' => 'EGP',
                'sign' => 'EGP',
            ],
            [
                'name' => 'American dollar',
                'code' => 'USD',
                'sign' => 'USD',
            ],
        ];
        DB::table('currencies')->insert($currencies);
    }
}
