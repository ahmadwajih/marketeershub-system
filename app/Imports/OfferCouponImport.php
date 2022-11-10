<?php

namespace App\Imports;

use App\Models\Coupon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OfferCouponImport implements ToCollection, WithChunkReading, ShouldQueue, WithStartRow
{
    public $offerId;
    public $totlaUploadedSuccessfully = 0;

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
                $this->totlaUploadedSuccessfully++;
            }
            
        }
        session(['totlaUploadedSuccessfully' => 100]);
    }

    public function chunkSize(): int
    {
        return 10;
    }

    public function startRow(): int
    {
        return 2;
    }
}
