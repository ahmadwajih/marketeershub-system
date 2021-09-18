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
            'coupon_code' => 'MH1',
            'number_of_orders' => '4',
            'sum_of_sales' => '1483.03',
            'sum_of_revenue' => '118.65',
            'sum_of_payout' => '62.29'
        ]);
    }
}
