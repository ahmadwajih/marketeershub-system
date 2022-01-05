<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class InfluencerImport implements ToCollection
{
    public $team;
    public $status;
    public $countryId;
    public function __construct($team)
    {
        $this->team = $team;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        foreach ($collection as $index => $col) 
        {
        //     if(!is_null($col[0])){

        //         // Get Country Id
        //         $this->countryId = null;
        //         $country = Country::where('name_en', 'like', '%'.$col[9].'%')->orWhere('name_ar', 'like', '%'.$col[9].'%')->first();
        //         if($country){
        //             $this->countryId = $country->id;
        //         }
        //         // Get Status
        //         $this->status = 'pending';
        //         if($col[2] == 'approved'){
        //             $this->status = 'active';
        //         }elseif($col[2] == 'rejected'){
        //             $this->status = 'closed';
        //         }

        //         // Get Cerrency Id 
        //         $currency = Currency::where('name_en', 'like', '%'.$col[10].'%')
        //             ->orWhere('name_ar', 'like', '%'.$col[10].'%')
        //             ->orWhere('code', $col[10])
        //             ->orWhere('sign', $col[10])
        //             ->first();


        //         $existsPublisher = User::whereEmail($col[1])->first();
        //         if($existsPublisher){
        //             $existsPublisher->update([
        //                 'ho_id' => $col[0],
        //                 'email' => $col[1],
        //                 'name' => $col[2],
        //                 'account_title' => $col[4],
        //                 'address' => $col[5],
        //                 'affiliate_networks' => $col[6],
        //                 'bank_branch_code' => $col[7],
        //                 'bank_name' => $col[8],
        //                 'currency_id' => $currency ? $currency->id : null,
        //                 'years_of_experience' => $col[11],
        //                 'iban' => $col[12],
        //                 'owened_digital_assets' => $col[13],
        //                 'phone' => $col[14],
        //                 'swift_code' => $col[16],
        //                 'traffic_sources' => $col[17],
        //                 'status' => $this->status,
        //                 'team' => $this->team,
        //                 'country_id' => $this->countryId,
        //             ]);
        //         }else{
        //             User::create([
        //                 'ho_id' => $col[0],
        //                 'email' => $col[1],
        //                 'name' => $col[2],
        //                 'account_title' => $col[4],
        //                 'address' => $col[5],
        //                 'affiliate_networks' => $col[6],
        //                 'bank_branch_code' => $col[7],
        //                 'bank_name' => $col[8],
        //                 'currency_id' => $currency ? $currency->id : null,
        //                 'years_of_experience' => $col[11],
        //                 'iban' => $col[12],
        //                 'owened_digital_assets' => $col[13],
        //                 'phone' => $col[14],
        //                 'swift_code' => $col[16],
        //                 'traffic_sources' => $col[17],
        //                 'status' => $this->status,
        //                 'team' => $this->team,
        //                 'country_id' => $this->countryId,
        //                 'password' => Hash::make('12345678')
        //             ]);
        //         }
                
        //     }
        // }
    }
}
