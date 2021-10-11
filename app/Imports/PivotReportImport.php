<?php

namespace App\Imports;

use App\Models\Coupon;
use App\Models\PivotReport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
class PivotReportImport implements ToCollection
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
        unset($collection[0]);
        foreach ($collection as $index => $col) 
        {
            Validator::make($collection->toArray(), [
                '*.0' => 'nullable|max:255',
                '*.1' => 'nullable|numeric',
                '*.2' => 'nullable|numeric',
                '*.3' => 'nullable|numeric',
                '*.4' => 'nullable|numeric',
            ])->validate();

            if(!is_null($col[0])){
                $coupon  = Coupon::firstOrCreate([
                    'coupon' => $col[0],
                    'offer_id' => $this->offerId,
                ]);

                $pivotReport  = PivotReport::where('coupon_id', $coupon->id)->first();
                if($pivotReport){
                    $pivotReport->update([
                        'coupon_id' => $coupon->id,
                        'orders' => $col[1],
                        'sales' => $col[2],
                        'revenue' => $col[3],
                        'payout' => $col[4],
                    ]);
                }else{
                    PivotReport::create([
                        'coupon_id' => $coupon->id,
                        'orders' => $col[1],
                        'sales' => $col[2],
                        'revenue' => $col[3],
                        'payout' => $col[4],
                    ]);
                }
                
            }
        }
    }


}
