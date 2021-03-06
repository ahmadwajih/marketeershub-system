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
    public $team;

    public $test = [];

    public function __construct($offerId, $team)
    {
        $this->offerId = $offerId;
        $this->team = $team;
    }
    /**
    * @param Collection $collection
*/
    public function collection(Collection $collection)
    {
        // unset($collection[0]);
        foreach ($collection as $index => $col) 
        {
        
            if(!is_null($col[1])){
                $userId = null;
                if(!is_null($col[0])){
                    if($col[0] == 1000 || $col[0] == 'inf-1000' || $col[0] == 'aff-1000' || $this->team == 'media_buying'){
                        $publisher = User::where('email', 'info@marketeershub.com')->first();
                        if($publisher){
                            $userId = $publisher->id;
                        }
                    }else{
                        $publisher = User::where('ho_id', $col[0])->where('team', $this->team)->first();
                        // dd($publisher);
                        if($publisher){
                            $userId = $publisher->id;
                        }
                    }
                    
                }
                
                $coupon = Coupon::updateOrCreate(
                    [
                        'coupon' => $col[1],
                        'offer_id' => $this->offerId,
                        
                    ],
                    [
                        'user_id' => $userId,
                    ]);
                    if($coupon){
                        $this->test[$index]['code'] = $coupon->coupon; 
                        $this->test[$index]['user_id'] = $coupon->user_id; 
                    }else{
                        $this->test[$index]['code_null'] = $col[1]; 
                        $this->test[$index]['user_id_null'] = $col[0]; 
                    }
                    
            }

           
            
        }

        Log::debug($this->test);
    }
}
