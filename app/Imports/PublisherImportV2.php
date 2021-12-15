<?php

namespace App\Imports;

use App\Models\Category;
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

class PublisherImportV2 implements ToCollection
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
                $category = Category::where('title_en', 'like', '%'.$col[4].'%')->orWhere('title_ar', 'like', '%'.$col[4].'%')->first();
                
                $parentId = User::where('ho_id', $col[5])->first();
               try {
                $user = User::firstOrCreate([
                    'ho_id' => $col[0],
                    'name' => $col[1],
                    'phone' => $col[2],
                    'email' => $col[3],
                    'email' => $col[3],
                    'parent_id' => $parentId ? $parentId->id : null,
                    'team' => 'influencer',
                    'position' => 'publisher',
                    'status' => 'active',
                    ]);
               } catch (\Throwable $th) {
                   continue;
               }
                try {
                    $user->roles()->attach(4);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                if($category){
                    $user->categories()->attach($category->id);
                }
            }
        }
    }
}
