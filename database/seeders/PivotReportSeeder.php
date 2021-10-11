<?php

namespace Database\Seeders;

use App\Models\PivotReport;
use Illuminate\Database\Seeder;

class PivotReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PivotReport::create([
            'coupon_id' => 1,
            'orders' => '4',
            'sales' => '1483.03',
            'revenue' => '118.65',
            'payout' => '62.29'
        ]);
    }
}
