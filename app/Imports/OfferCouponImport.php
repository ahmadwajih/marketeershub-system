<?php

namespace App\Imports;

use App\Models\Coupon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class OfferCouponImport implements ToCollection
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
            if(!is_null($col[1])){
                Coupon::create([
                    'coupon' => $col[1],
                    'offer_id' => $this->offerId,
                    
                ]);
            }
            
        }
    }
}
