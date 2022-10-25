<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            AbilitySeeder::class,
            CountrySeeder::class,
            CitySeeder::class,
            CurrencySeeder::class,
            UserSeeder::class,
            AdvertiserSeeder::class,
            OfferSeeder::class,
            CouponSeeder::class,
            PivotReportSeeder::class,
            CategorySeeder::class,
            AdvertiserCategorySeeder::class,
            PublisherCategorySeeder::class,
        ]);
    }
}

