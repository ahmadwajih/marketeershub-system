<?php

namespace App\Imports;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CouponImport implements ToCollection, WithChunkReading, ShouldQueue, WithStartRow
{
    public $offerId;
    public $oldId = null;
    public $test = [];
    public $totlaUploadedSuccessfully = 0;
    public $totlaUpdatedSuccessfully = 0;
    public $totlaCreatedSuccessfully = 0;

    public function __construct($offerId)
    {
        $this->offerId = $offerId;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        Validator::make($collection->toArray(), [
            '*.0' => 'required|max:20',
        ])->validate();

        foreach ($collection as $index => $col) {

            if (!is_null($col[0])) {
                $userId = null;
                // if (!is_null($col[1]) && isset($col[1])) {
                //     if ($col[1] == 1000 || $col[1] == 'inf-1000' || $col[1] == 'aff-1000') {
                //         $publisher = User::where('email', 'info@marketeershub.com')->first();
                //         if ($publisher) {
                //             $userId = $publisher->id;
                //         }
                //     } else {
                //         $publisher = User::where('ho_id', $this->oldId)->first();
                //         if ($publisher) {
                //             $userId = $publisher->id;
                //         }
                //     }
                // }
                $coupon = Coupon::where([
                    ['coupon', '=',  $col[0]],
                    ['offer_id', '=', $this->offerId]
                ])->first();
                if ($coupon) {
                    $coupon->user_id = $userId;
                    $coupon->save();
                    $this->totlaUpdatedSuccessfully++;
                } else {
                    Coupon::create([
                        'coupon' => $col[0],
                        'offer_id' => $this->offerId,
                        'user_id' => $userId,
                    ]);
                    $this->totlaCreatedSuccessfully++;
                }
                $this->totlaUploadedSuccessfully++;
            }
        }
        session(['upload_coupon_report' => [
            'totlaUpdatedSuccessfully' => $this->totlaUpdatedSuccessfully++,
            'totlaCreatedSuccessfully' => $this->totlaCreatedSuccessfully++,
            'totlaUploadedSuccessfully' => $this->totlaUploadedSuccessfully++,
        ] ]);

    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function startRow(): int
    {
        return 2;
    }
}
