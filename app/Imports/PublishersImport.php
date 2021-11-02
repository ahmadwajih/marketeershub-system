<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
class PublishersImport implements ToCollection
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
            // dd($col);
            if(!is_null($col[0])){

                // Get Country Id
                $this->countryId = null;
                $country = Country::where('name_en', 'like', '%'.$col[8].'%')->orWhere('name_ar', 'like', '%'.$col[8].'%')->first();
                if($country){
                    $this->countryId = $country->id;
                }
                // Get Status
                $this->status = 'pending';
                if($col[2] == 'approved'){
                    $this->status = 'active';
                }elseif($col[2] == 'rejected'){
                    $this->status = 'closed';
                }
                $existsPublisher = User::whereEmail($col[0])->first();
                if($existsPublisher){
                    $existsPublisher->update([
                        'email' => $col[0],
                        'name' => $col[1],
                        'account_title' => $col[3],
                        'address' => $col[4],
                        'affiliate_networks' => $col[5],
                        'bank_branch_code' => $col[6],
                        'bank_name' => $col[7],
                        'currency' => $col[9],
                        'years_of_experience' => $col[10],
                        'iban' => $col[11],
                        'owened_digital_assets' => $col[12],
                        'phone' => $col[13],
                        'swift_code' => $col[15],
                        'traffic_sources' => $col[16],
                        'status' => $this->status,
                        'team' => $this->team,
                        'country_id' => $this->countryId,
                    ]);
                }else{
                    User::create([
                        'email' => $col[0],
                        'name' => $col[1],
                        'account_title' => $col[3],
                        'address' => $col[4],
                        'affiliate_networks' => $col[5],
                        'bank_branch_code' => $col[6],
                        'bank_name' => $col[7],
                        'currency' => $col[9],
                        'years_of_experience' => $col[10],
                        'iban' => $col[11],
                        'owened_digital_assets' => $col[12],
                        'phone' => $col[13],
                        'swift_code' => $col[15],
                        'traffic_sources' => $col[16],
                        'status' => $this->status,
                        'team' => $this->team,
                        'country_id' => $this->countryId,
                    ]);
                }
                
            }
        }
    }
}
