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
    public $team;

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
        foreach ($collection as $col) 
        {
            if(!is_null($col[1])){
                $userId = null;
                if(!is_null($col[0])){
                    $publisher = User::where('ho_id', $col[0])->where('team', $this->team)->first();
                    // dd($publisher);
                    if($publisher){
                        $userId = $publisher->id;
                    }
                }
                
                Coupon::updateOrCreate(
                    [
                        'coupon' => $col[1],
                        'offer_id' => $this->offerId,
                        
                    ],
                    [
                        'user_id' => $userId,
                    ]);
            }
            
        }
    }
}
