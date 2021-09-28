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
            'name' => 'Namshi',
            'description' => 'Namshi offer',
            'website' => 'https://www.namshi.com/',
            'offer_url' => 'https://ar-sa.namshi.com/men/under-armour-exclusives/',
            'payout_type' => 'cpa_flat',
            'default_payout' => '2.00',
            'status' => 'active',
            'expire_date' => now(),
            'advertiser_id' => 1,
            'currency_id' => 1
        ]);
    }
}
