<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Super Admin
        $superAdmin = User::create([
            'name'                  => 'Ahmed Wageh',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '7',
            'parent_id'             => null,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'management',
            'position'              => 'super_admin',
            'email'                 => 'admin@gmail.com',
            'phone'                 => '01027887897',
            'status'                => 'active'
        ]);
        $superAdmin->assignRole(Role::get()->first());
        
        //Marketeers Hub
        $user = User::create([
            'name'                  => 'Marketeers Hub',
            'password'              => Hash::make('JGKJSK#@#@#dsfsdfFFSFsgd4545'),
            'ho_id'                 => '1000',
            'years_of_experience'   => '5',
            'gender'                => 'male',
            'team'                  => 'media_buying',
            'position'              => 'publisher',
            'email'                 => 'info@marketeershub.com',
            'phone'                 => '123456789',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'media buying networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('publisher')->first());

        // Head 
        //Influencer Head
        $user = User::create([
            'name'                  => 'Influencer Head',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => null,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'influencer',
            'position'              => 'head',
            'email'                 => 'influencer_head@gmail.com',
            'phone'                 => '01027777111',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'affiliate networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('account_manager')->first());

        //Affiliate head
        $user = User::create([
            'name'                  => 'Affiliate Head',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => null,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'affiliate',
            'position'              => 'head',
            'email'                 => 'affiliate_head@gmail.com',
            'phone'                 => '01027555222',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'affiliate networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('account_manager')->first());

         //Medi Buying head
         $user = User::create([
            'name'                  => 'Media Buying Head',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => null,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'media_buying',
            'position'              => 'head',
            'email'                 => 'media_buying_head@gmail.com',
            'phone'                 => '01027555533',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'media buying networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('account_manager')->first());

         //Prepaid head
         $user = User::create([
            'name'                  => 'Prepaid Head',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => null,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'prepaid',
            'position'              => 'head',
            'email'                 => 'prepaid_head@gmail.com',
            'phone'                 => '01027555741',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'prepaid networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('account_manager')->first());

        // Account manager 

        //Influencer Account Manager
        $user = User::create([
            'name'                  => 'Influencer Account Manager',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => 2,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'influencer',
            'position'              => 'account_manager',
            'email'                 => 'influencer_account_manager@gmail.com',
            'phone'                 => '01027777744',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'affiliate networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('account_manager')->first());

        //Affiliate Account Manager
        $user = User::create([
            'name'                  => 'Affiliate Account Manager',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => 3,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'affiliate',
            'position'              => 'account_manager',
            'email'                 => 'affiliate_account_manager@gmail.com',
            'phone'                 => '01027555555',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'affiliate networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('account_manager')->first());

         //Medi Buying Account Manager
         $user = User::create([
            'name'                  => 'Media Buying Account Manager',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => 4,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'media_buying',
            'position'              => 'account_manager',
            'email'                 => 'media_buying_account_manager@gmail.com',
            'phone'                 => '01027555666',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'media buying networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('account_manager')->first());

         //Prepaid Account Manager
         $user = User::create([
            'name'                  => 'Prepaid Account Manager',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => 5,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'prepaid',
            'position'              => 'account_manager',
            'email'                 => 'prepaid_account_manager@gmail.com',
            'phone'                 => '01027555852',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'prepaid networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('account_manager')->first());

        $user = User::create([
            'name'                  => 'Nora Elsubaie AM',
            'password'              => Hash::make('920033874'),
            'years_of_experience'   => '5',
            'parent_id'             => 2,
            'country_id'            => 1,
            'gender'                => 'female',
            'team'                  => 'influencer',
            'position'              => 'account_manager',
            'email'                 => 'nora@marketeershub.com',
            'phone'                 => '920033874',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'affiliate networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('account_manager')->first());

        // Publisher 
        //Influencer Publisher
        $user = User::create([
            'name'                  => 'Influencer Publisher',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => 6,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'influencer',
            'position'              => 'publisher',
            'email'                 => 'influencer_publisher@gmail.com',
            'phone'                 => '01027777777',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'affiliate networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('publisher')->first());

        //Affiliate Publisher
        $user = User::create([
            'name'                  => 'Affiliate Publisher',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => 7,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'affiliate',
            'position'              => 'publisher',
            'email'                 => 'affiliate_publisher@gmail.com',
            'phone'                 => '01027555888',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'affiliate networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('publisher')->first());

         //Medi Buying Publisher
         $user = User::create([
            'name'                  => 'Media Buying Publisher',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => 8,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'media_buying',
            'position'              => 'publisher',
            'email'                 => 'media_buying_publisher@gmail.com',
            'phone'                 => '01027555999',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'media buying networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('publisher')->first());

         //Prepaid Publisher
         $user = User::create([
            'name'                  => 'Prepaid Publisher',
            'password'              => Hash::make('12345678'),
            'years_of_experience'   => '5',
            'parent_id'             => 9,
            'country_id'            => 1,
            'gender'                => 'male',
            'team'                  => 'prepaid',
            'position'              => 'publisher',
            'email'                 => 'prepaid_publisher@gmail.com',
            'phone'                 => '01027555963',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'prepaid networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('publisher')->first());

        $user = User::create([
            'name'                  => 'Nora Elsubaie Publisher',
            'password'              => Hash::make('920033874'),
            'years_of_experience'   => '5',
            'parent_id'             => 10,
            'country_id'            => 1,
            'gender'                => 'female',
            'team'                  => 'influencer',
            'position'              => 'publisher',
            'email'                 => 'nora@athrco.com',
            'phone'                 => '05920033874',
            'traffic_sources'       => 'traffic sources',
            'affiliate_networks'    => 'affiliate networks',
            'owened_digital_assets' => 'owened digital assets',
            'account_title'         => 'account_title',
            'bank_name'             => 'bank_name',
            'bank_branch_code'      => 'bank_branch_code',
            'swift_code'            => 'swift_code',
            'iban'                  => 'iban',
            'currency_id'           => 1,
            'status'                => 'active'
        ]);
        $user->assignRole(Role::whereLabel('publisher')->first());

    }

}
