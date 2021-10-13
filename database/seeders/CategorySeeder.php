<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Fashions',
            'Furniture',
            'Smart Phones',
            'Daily',
            'Activties',
            'Games',
            'Sport',
            'Tech',
            'Entertaimnet',
            'News',
            'Travel',
            'Culture',
            'History',
            'Parental',
            'Shopping',
            'Fashion',
            'Beauty',
            'Health',
            'Food',
            'Home & Decor',
            'Life Style',
            'Other'
        ];
        foreach($categories as $category){
            Category::create([
                'title' => $category
            ]);
        }
        

       
    }
}
