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
        $superAdmin = Role::get()->first();

        $models = [
            'countries',
            'cites',
            'users',
            'roles',
            'advertisers',
            'offers',
            'coupons',
            'currencies',
            'publishers',
            'pivot_report',
            'categories',
            'offer_requests',
            'user_activities',
            'targets',
            'payments',
            'helps',
            'trashed',
        ];

        $names = 
        [
            ['label' => "view", 'name' => 'view'],
            ['label' => "create", 'name' => 'create'],
            ['label' => "update", 'name' => 'update'],
            ['label' => "delete", 'name' => 'delete'],
        ];

        foreach ($models as $model) {
            foreach ($names as $name) {
               $ability =  Ability::create([
                    'name'  => $name['name'] .'_'. $model,
                    'label' => $name['label'] .' '. strtolower(trim(str_replace('_',' ', trim($model)))),
                    'action' => $name['name'],
                    'category' => $model
                ]);
                $superAdmin->allowTo($ability);
            }
        }

        // Special Apilities
        $models = [
            'reports',
            'dashboard',
        ];

        $names = 
        [
            ['label' => "view", 'name' => 'view'],
        ];

        foreach ($models as $model) {
            foreach ($names as $name) {
               $ability =  Ability::create([
                    'name'  => $name['name'] .'_'. $model,
                    'label' => $name['label'] .' '. strtolower(trim(str_replace('_',' ', trim($model)))),
                    'action' => $name['name'],
                    'category' => $model
                ]);
                $superAdmin->allowTo($ability);
            }
        }
        
    }
}
