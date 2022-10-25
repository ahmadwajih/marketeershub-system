<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            array('id' => '1', 'name_ar' => 'المملكة العربية السعودية', 'name_fr' => 'Arabie Saoudite', 'name_en' => 'Saudi Arabia', 'code' => 'sa'),
            array('id' => '2', 'name_ar' => 'مصر', 'name_fr' => 'Egypte', 'name_en' => 'Egypt', 'code' => 'eg'),
            array('id' => '3', 'name_ar' => 'دولة قطر', 'name_fr' => 'Qatar', 'name_en' => 'Qatar', 'code' => 'qa'),
            array('id' => '4', 'name_ar' => 'الكويت', 'name_fr' => 'Koweit', 'name_en' => 'Kuwait', 'code' => 'kw'),
            array('id' => '5', 'name_ar' => 'الإمارات العربية المتحدة', 'name_fr' => 'Emirats Arabes Unis', 'name_en' => 'United Arab Emirates', 'code' => 'ae'),

        ];

        DB::table('countries')->insert($countries);
    }
}
