<?php

namespace Database\Seeders;

use App\Models\Advertiser;
use Illuminate\Database\Seeder;

class AdvertiserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertiser::create([
            'name' => 'Mohamed Tawfik',
            'phone' => '010277777777',
            'email' => 'email@gmail.com',
            'company_name' => 'Smart Influence LLC',
            'website' => 'si.com',
            'country_id' => 1,
            'city_id' => 1,
            'address' => 'Riayd SAudia Arabia',
            'status' => 'approved',
        ]);
    }
}
