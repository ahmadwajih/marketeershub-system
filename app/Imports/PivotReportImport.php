<?php

namespace App\Imports;

use App\Models\Coupon;
use App\Models\PivotReport;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
class PivotReportImport implements ToCollection
{
    public $offerId;
    public $type;
    public $date;
    public $team;
    public $completeMission;

    public $test = [];
    public $totalOrders = 0;
    public $falses = [];
    public function __construct($offerId, $type, $date, $team)
    {
        $this->offerId = $offerId;
        $this->type = $type;
        $this->date = $date;
        $this->team = $team;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        
        unset($collection[0]);
        Validator::make($collection->toArray(), [
                '*.0' => 'nullable|max:20',
                '*.1' => 'nullable|numeric',
                '*.2' => 'nullable|numeric',
                '*.3' => 'nullable|numeric',
                '*.4' => 'nullable|numeric',
            ])->validate();

        foreach ($collection as $index => $col) 
        {
            

            if(!is_null($col[0])){

                // Get coupon code 
                $coupon  = Coupon::where([
                    ['coupon', '=', $col[0]],
                    ['offer_id', '=', $this->offerId]
                ])->first();
                
                // Check if this coupons is belong to user in the same team 
                if($coupon){
                    if($coupon->user){
                        $this->completeMission = false;
                        if($this->team == $coupon->user->team || $coupon->user->email == 'info@marketeershub.com'){
                            $this->completeMission = true;
                        }
                    }else{
                        $coupon->user_id = marketersHubPublisherInfo()->id;
                        $coupon->update();
                        $this->completeMission = true;

                    }
                    
                }else{
                    $coupon = Coupon::create([
                        'coupon' => $col[0],
                        'offer_id' => $this->offerId,
                        'user_id' => marketersHubPublisherInfo()->id // here add marketeers hub affiliate default publisher account 
                    ]);
                    $this->completeMission = true;
                }


                if($this->completeMission){

                    $pivotReport  = PivotReport::where([
                        ['coupon_id', '=',$coupon->id],
                        ['date', '=',$this->date],
                    ])->first();

                    $this->test[$index]['coupon_code'] = $coupon->coupon; 
                    $this->test[$index]['coupon_user_id'] = $coupon->user_id; 
                    $this->test[$index]['coupon_user_old_id'] = $coupon->user? $coupon->user->ho_id : null; 
                    $this->test[$index]['coupon_user_name'] = $coupon->user ? $coupon->user->name : ''; 
                    $this->test[$index]['orders'] = $col[1]; 
                    $this->test[$index]['sales'] = $col[2]; 
                    $this->totalOrders = $this->totalOrders + $col[1];
                    if($pivotReport){
                        $pivotReport->update([
                            'orders' => $col[1],
                            'sales' => $col[2],
                            'revenue' => $col[3],
                            'payout' => $col[4],
                            'type' => $this->type,
                            'offer_id' => $this->offerId,
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
                            'offer_id' => $this->offerId,
                        ]);
                    }
                }else{
                    $this->falses[] = $col;
                }
                
                
                
            }
        }
        

        Log::debug($this->test);
        Log::debug(['totalOrders' => $this->totalOrders]);
        Log::debug(['falses' => $this->falses]);
    }


}
