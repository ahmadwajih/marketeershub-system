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
                'name_ar' => 'ريال سعودي',
                'name_en' => 'Riyal Saudi',
                'code' => 'SAR',
                'sign' => 'SAR',
            ],
            [
                'name_ar' => 'جنيه مصري',
                'name_en' => 'Egyptian pound',
                'code' => 'EGP',
                'sign' => 'EGP',
            ],
            [
                'name_ar' => 'دولار امريكي',
                'name_en' => 'American dollar',
                'code' => 'USD',
                'sign' => 'USD',
            ],
        ];
        DB::table('currencies')->insert($currencies);
    }
}
