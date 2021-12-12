<?php

namespace Database\Seeders;

use App\Models\PublisherCategory;
use Illuminate\Database\Seeder;

class PublisherCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enCategories = [
            'Daily ',
            'Activties',
            'Games',
            'Sport',
            'Tech',
            'Entertaimnet ',
            'News',
            'Travel',
            'Culture',
            'History',
            'Other',
            'Parental',
            'Shopping ',
            'Fashion',
            'Beauty',
            'Health',
            'Food',
            'Home & Decor',
            'Life style',
        ];

        $arCategories = [
            'يومي',
            'انشطة',
            'ألعاب',
            'رياضي',
            'تقني',
            'ترفيهي',
            'اخبار',
            'سفر',
            'ثقافي',
            'تاريخي',
            'اخرى',
            'امومة و أسرة',
            'تسوق',
            'أزياء',
            'تجميل',
            'صحي',
            'أطعمه وطبخ',
            'منزل',
            'نمط حياة',
        ];

        foreach($enCategories as $index => $category){
            PublisherCategory::create([
                'title_ar' => $arCategories[$index],
                'title_en' => $enCategories[$index]
            ]);
        }
        

    }
}
