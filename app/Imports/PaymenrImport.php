<?php

namespace App\Imports;

use App\Exports\NotFoundUsersInInUploadPayemntSheetExport;
use App\Models\Payment;
use App\Models\User;
use App\Notifications\NewPaymentPaid;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class PaymenrImport implements ToCollection
{
    public $unFoundPublishers = [];
    public $export;

    /**
    * @param Collection $collection
    */
    
    public function collection(Collection $collection)
    {

         unset($collection[0]);
        //  dd();
         Validator::make($collection->toArray(), [
            '*.0' => 'required|numeric',
            '*.2' => 'required|numeric',
            '*.3' => 'required',
            '*.4' => 'required',
            '*.5' => 'required|in:Validation,Update',
            '*.6' => 'nullable|string|max:255',
            '*.7' => 'nullable|string|max:255',
        ])->validate();

         foreach ($collection as $col) 
         {
            $userId = null;
            if(!is_null($col[0])){
                $publisher = User::where('ho_id', $col[0])->first();
                if($publisher){
                    $userId = $publisher->id;
                }
                if(!is_null($userId)){
                    $payment = Payment::create([
                            'publisher_id'  => $userId,
                            'amount_paid'   => $col[2],
                            'from'          => Carbon::createFromFormat('d/m/Y', $col[3])->format('Y-m-d'),
                            'to'            => Carbon::createFromFormat('d/m/Y', $col[4])->format('Y-m-d'),
                            'type'          => $col[5],
                            'slip'          => $col[6],
                            'note'          => $col[7],
                            'user_id'       => auth()->user()->id,
                        ]);

                        Notification::send($publisher, new NewPaymentPaid($payment));

                    }else{
                        $this->unFoundPublishers[] = $col;
                    }
            }

         }
         if(count($this->unFoundPublishers) > 0){
            $this->export = new NotFoundUsersInInUploadPayemntSheetExport($this->unFoundPublishers);
        
            Excel::download($this->export, 'invoices.csv');
         }

    }
}
