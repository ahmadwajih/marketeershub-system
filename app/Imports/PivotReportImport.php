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

    public function __construct($offerId, $type, $date)
    {
        $this->offerId = $offerId;
        $this->type = $type;
        $this->date = $date;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        
        unset($collection[0]);
        Validator::make($collection->toArray(), [
                '*.0' => 'required|max:20',
                '*.1' => 'required|numeric',
                '*.2' => 'required|numeric',
                '*.3' => 'required|numeric',
                '*.4' => 'required|numeric',
            ])->validate();

        foreach ($collection as $index => $col) 
        {
            

            if(!is_null($col[0])){
                $coupon  = Coupon::firstOrCreate([
                    'coupon' => $col[0],
                    'offer_id' => $this->offerId,
                ]);

                $pivotReport  = PivotReport::where([
                    ['coupon_id', '=',$coupon->id],
                    ['date', '=',$this->date],
                ])->first();
                if($pivotReport){
                    $pivotReport->update([
                        'orders' => $col[1],
                        'sales' => $col[2],
                        'revenue' => $col[3],
                        'payout' => $col[4],
                        'type' => $this->type,
                    ]);
                }else{
                    PivotReport::create([
                        'coupon_id' => $coupon->id,
                        'orders' => $col[1],
                        'sales' => $col[2],
                        'revenue' => $col[3],
                        'payout' => $col[4],
                        'type' => $this->type,
                        'date' => $this->date,
                    ]);
                }
                
                
                
            }
        }
    }


}
