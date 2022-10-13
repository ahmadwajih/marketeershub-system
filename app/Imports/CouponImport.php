<?php

namespace App\Imports;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
class CouponImport implements ToCollection
{
    public $offerId;
    public $oldId = null;
    public $test = [];

    public function __construct($offerId)
    {
        $this->offerId = $offerId;
    }
    /**
    * @param Collection $collection
*/
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        Validator::make($collection->toArray(), [
            '*.0' => 'required|max:20',
        ])->validate();

        foreach ($collection as $index => $col) 
        {

           
            if(!is_null($col[0])){
                $userId = null;
                if(!is_null($col[1])){
                    if($col[1] == 1000 || $col[1] == 'inf-1000' || $col[1] == 'aff-1000'){
                        $publisher = User::where('email', 'info@marketeershub.com')->first();
                        if($publisher){
                            $userId = $publisher->id;
                        }
                    }else{
                        $publisher = User::where('ho_id', $this->oldId)->first();
                        if($publisher){
                            $userId = $publisher->id;
                        }
                    }
                    
                }
                
                $coupon = Coupon::updateOrCreate(
                    [
                        'coupon' => $col[0],
                        'offer_id' => $this->offerId,
                        
                    ],
                    [
                        'user_id' => $userId,
                    ]);
                    $this->test[$index]['old_id'] = $this->oldId; 
                    if($coupon){
                        $this->test[$index]['code'] = $coupon->coupon; 
                        $this->test[$index]['user_id'] = $coupon->user_id; 
                    }else{
                        $this->test[$index]['code_null'] = $col[0]; 
                        $this->test[$index]['user_id_null'] = $col[1]; 
                    }
                    
            }

           
            
        }

        Log::debug($this->test);
    }
}
