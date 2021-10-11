<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PublishersUpdateHasofferIdByEmail implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        foreach ($collection as $index => $col) 
        {
            // dd($col);
            if(!is_null($col[0])){

                $existsPublisher = User::whereEmail($col[1])->first();
                if($existsPublisher){
                    $existsPublisher->update([
                        'ho_id' => $col[0],
                    ]);
                }
                
            }
        }
    }
}
