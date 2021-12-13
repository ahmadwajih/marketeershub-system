<?php

namespace Database\Seeders;

use App\Models\AdvertiserCategory;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AdvertiserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enCategories = [
            'Fashion & Beauty ',
            'Furniture',
            'smart devices',
            'Health',
            'Cosmetics & Perfume ',
            'travel and tourism',
            'wholesale',
            'Marketplace ',
            'Event Managment',
            'Fintech ',
            'Real estate',
            'Finance',
            'Hair and Skin care',
            'Healthy Food',
            'Delivery Application',
            'Travel  Application',
            'Baby care',
            'Pharmacy',
            'Gym',
            'Home Electric Appliances',
            'water',
            'Restaurant & food',
            'Path & Bed',
            'Watches and jewelry',
            'Home & Kitchen',
            'lighting and furniture',
        ];

        $arCategories = [
            'أزياء وجمال',
            'أثاث',
            'أجهزة ذكية',
            'صحة',
            'أدوات تجميل وعطور',
            'سفر وسياحة',
            'متعدد التصنيفات',
            'منصة بيع',
            'إدارة الفعاليات',
            'تقنية مالية',
            'عقارات',
            'تمويل',
            'عناية بالشعر والبشرة',
            'أطعمة صحية',
            'تطبيقات التوصيل',
            'تطبيقات السفر',
            'رعاية اطفال',
            'صيدلية',
            'نوادي رياضية',
            'أجهزة منزلية',
            'مياه',
            'مطاعم وأطعمة',
            'مستلزمات الحمام والغرف',
            'ساعات ومجوهرات',
            'طبخ وأواني منزلية',
            'أنارة واثاث',
        ];

        foreach($enCategories as $index => $category){
            Category::create([
                'title_ar' => $arCategories[$index],
                'title_en' => $enCategories[$index],
                'type' => 'advertisers'
            ]);
        }
        

    }
}
