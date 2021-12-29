<?php

namespace Database\Seeders;

use App\Models\Offer;
use Illuminate\Database\Seeder;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Offer::create([
            'name_ar' => 'نمشي',
            'name_en' => 'Namshi',
            'description_ar' => 'عرض نمشي',
            'description_en' => 'Namshi offer',
            'website' => 'https://www.namshi.com/',
            'offer_url' => 'https://ar-sa.namshi.com/men/under-armour-exclusives/',
            'payout' => '10',
            'revenue' => '5',
            'status' => 'active',
            'expire_date' => now(),
            'advertiser_id' => 1,
            'currency_id' => 1,
            'discount_type' => 'flat',
            'discount' => 10,
        ]);

        Offer::create([
            'name_ar' => ' 2 نمشي',
            'name_en' => 'Namshi 2',
            'description_ar' => 'عرض  2 نمشي',
            'description_en' => 'Namshi 2 offer',
            'website' => 'https://www.namshi.com/',
            'offer_url' => 'https://ar-sa.namshi.com/men/under-armour-exclusives/',
            'payout' => '10',
            'revenue' => '5',
            'status' => 'active',
            'expire_date' => now(),
            'advertiser_id' => 1,
            'currency_id' => 1,
            'discount_type' => 'flat',
            'discount' => 10,
        ]);

        Offer::create([
            'name_ar' => ' 3 نمشي',
            'name_en' => 'Namshi 3',
            'description_ar' => 'عرض  3 نمشي',
            'description_en' => 'Namshi 3 offer',
            'website' => 'https://www.namshi.com/',
            'offer_url' => 'https://ar-sa.namshi.com/men/under-armour-exclusives/',
            'payout' => '10',
            'revenue' => '5',
            'status' => 'active',
            'expire_date' => now(),
            'advertiser_id' => 1,
            'currency_id' => 1,
            'discount_type' => 'flat',
            'discount' => 10,
        ]);
    }
}
