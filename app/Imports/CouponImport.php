<?php

namespace App\Imports;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
class CouponImport implements ToCollection
{
    public $offerId;

    public function __construct($offerId)
    {
        $this->offerId = $offerId;
    }
    /**
    * @param Collection $collection
*/
    public function collection(Collection $collection)
    {
        // unset($collection[0]);
        foreach ($collection as $col) 
        {
            if(!is_null($col[0])){
                // $userId = null;
                // if(!is_null($col[0])){
                //     $publisher = User::where('ho_id', $col[0])->first();
                //     if($publisher){
                //         $userId = $publisher->id;
                //     }
                // }
    
                Coupon::updateOrCreate(
                    [
                        'coupon' => $col[0],
                        'offer_id' => $this->offerId,
                    ],
                    [
                        
                    ]);
            }
            
        }
    }
}
