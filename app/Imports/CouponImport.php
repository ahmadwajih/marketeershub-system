<?php

namespace App\Imports;

use App\Models\Coupon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

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
        foreach ($collection as $col) 
        {
            if(!is_null($col[0])){
                Coupon::create([
                    'coupon' => $col[0],
                    'offer_id' => $this->offerId,
                ]);
            }
            
        }
    }
}
