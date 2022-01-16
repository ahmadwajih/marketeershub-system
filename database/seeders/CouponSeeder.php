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
        $offers = Offer::all();
        foreach($offers as $offer){
            // Add 6 coupons for one offer
            for($i = 1; $i <= 6; $i++){
                Coupon::create([
                    'coupon' => 'MH'.$i.$offer->id,
                    'offer_id' => $offer->id,
                    'user_id' => ($i == 1 || $i == 2) ? 11 : ($i == 3 || $i == 4 ? 12 : ($i == 5 || $i == 6 ? 13 : null))
                ]);
            }
        }
    }
}
