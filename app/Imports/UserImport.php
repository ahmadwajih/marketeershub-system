<?php

namespace App\Imports;

use App\Models\City;
use App\Models\Country;
use App\Models\PublisherCategory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserImport implements ToCollection
{
    public $team;
    public $status;
    public $category;
    public function __construct($team)
    {
        $this->team = $team;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        foreach ($collection as $index => $col) 
        {
            
            if(!is_null($col[0])){
                $this->category = null;
                // $category = PublisherCategory::where('title_en', 'like', '%'.$col[4].'%')->orWhere('title_ar', 'like', '%'.$col[4].'%')->first();
                $country = Country::where('name_en', 'like', '%'.$col[7].'%')->orWhere('name_ar', 'like', '%'.$col[7].'%')->first();
                $city = City::where('name_en', 'like', '%'.$col[8].'%')->orWhere('name_ar', 'like', '%'.$col[8].'%')->first();
               try {
                $user = User::firstOrCreate([
                    'ho_id' => $col[0],
                    'name' => $col[1],
                    'email' => $col[2],
                    'phone' => $col[3],
                    'team' => str_replace(' ', '_', strtolower(trim($col[4]))),
                    'position' => str_replace(' ', '_', strtolower(trim($col[5]))),
                    'gender' => $col[6],
                    'country_id' => $country?$country->id:null,
                    'city_id' => $city?$city->id:null,
                    'status' => 'active',
                    ]);
               } catch (\Throwable $th) {
                   continue;
               }
                  
                    $role = Role::whereLabel(str_replace(' ', '_', strtolower(trim($col[5]))))->first();
                    $user->roles()->attach($role->id);
            }
        }
    }
}
