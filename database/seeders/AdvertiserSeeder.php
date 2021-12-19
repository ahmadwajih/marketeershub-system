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
            'name' => 'Mohamed Mahmoud',
            'phone' => '010277777777',
            'email' => 'info@marketeershub.com',
            'company_name_ar' => 'ماركتيرزهاب',
            'company_name_en' => 'Marketeers Hub',
            'website' => 'marketeershub.com',
            'country_id' => 1,
            'currency_id' => 1,
            'city_id' => 1,
            'address' => 'Riayd SAudia Arabia',
            'status' => 'approved',
        ]);
    }
}
