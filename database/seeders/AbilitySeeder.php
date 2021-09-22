<?php

namespace Database\Seeders;

use App\Models\Ability;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AbilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            'countries',
            'cites',
            'users',
            'roles',
            'advertisers',
            'offers',
            'coupons',
            'currencies'
        ];

        $names = 
        [
            ['label' => "view", 'name' => 'view'],
            ['label' => "show", 'name' => 'show'],
            ['label' => "create", 'name' => 'create'],
            ['label' => "update", 'name' => 'update'],
            ['label' => "delete", 'name' => 'delete'],
        ];

        $superAdmin = Role::get()->first();
        foreach ($models as $model) {
            foreach ($names as $name) {
               $ability =  Ability::create([
                    'name'  => $name['name'] .'_'. $model,
                    'label' => $name['label'] .' '. $model,
                    'action' => $name['name'],
                    'category' => $model
                ]);
                $superAdmin->allowTo($ability);
            }
        }
    }
}
