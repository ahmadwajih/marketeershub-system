<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Super Admin
        Role::create([
            'name' => 'Super Admin',
            'label' => 'super_admin',
        ]);

        // Head
        Role::create([
            'name' => 'Head',
            'label' => 'head',
        ]);

        // Account Manager
        Role::create([
            'name' => 'Account Manager',
            'label' => 'account_manager',
        ]);

        // Publisher
        Role::create([
            'name' => 'Publisher',
            'label' => 'publisher',
        ]);
    }
}
