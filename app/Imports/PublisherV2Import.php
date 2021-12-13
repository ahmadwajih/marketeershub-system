<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\PublisherCategory;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PublisherV2Import implements ToCollection
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

                // Get Country Id
                $this->category = null;
                $category = PublisherCategory::where('title_en', 'like', '%'.$col[4].'%')->orWhere('title_ar', 'like', '%'.$col[4].'%')->first();
      
                // Get Status
                $this->status = 'active';
            
                $existsPublisher = User::whereEmail($col[0])->first();
                if($existsPublisher){
                    $existsPublisher->update([
                        'ho_id' => $col[0],
                        'name' => $col[1],
                        'phone' => $col[2],
                        'email' => $col[3],
                        'parent_id' => User::whereId()->first() ? User::whereId($col[5])->first()->id : null,
                        'status' => 'active',
                        'team' => $this->team,
                    ]);
                    if($category){
                        $existsPublisher->categories()->sync($category->id);
                    }
                }else{
                    $publisher = User::create([
                        'ho_id' => $col[0],
                        'name' => $col[1],
                        'phone' => $col[2],
                        'email' => $col[3],
                        'parent_id' => User::whereId()->first() ? User::whereId($col[5])->first()->id : null,
                        'status' => 'active',
                        'team' => $this->team,
                    ]);
                    if($category){
                        $publisher->categories()->attach($category->id);
                    }
                }
                
            }
        }
    }
}
