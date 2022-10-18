<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Offer;
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
        // $offers = Offer::all();
        // foreach($offers as $offer){
            // Add 6 coupons for one offer
            for($i = 1; $i <= 99999999; $i++){
                Coupon::create([
                    'coupon' => 'Test'.$i,
                    'offer_id' => 1,
                ]);
            // }
        }
    }
}
