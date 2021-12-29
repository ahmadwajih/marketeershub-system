<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::create([
            'coupon' => 'MH1',
            'offer_id' => 1,
            'user_id' => 11,
        ]);
        Coupon::create([
            'coupon' => 'MH2',
            'offer_id' => 1,
            'user_id' => 12,
        ]);
        Coupon::create([
            'coupon' => 'MH3',
            'offer_id' => 1,
            'user_id' => 13,
        ]);
        Coupon::create([
            'coupon' => 'MH4',
            'offer_id' => 2,
            'user_id' => 11,
        ]);
        Coupon::create([
            'coupon' => 'MH5',
            'offer_id' => 2,
            'user_id' => 12,
        ]);
        Coupon::create([
            'coupon' => 'MH6',
            'offer_id' => 2,
            'user_id' => 13,
        ]);
    }
}
