<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class PublishersImport implements ToCollection
{
    public $team;
    public $status;
    public $countryId = null;
    public $cityId = null;
    public $accouManagerId = null;
    public $currrencyId = null;
    public $data = [];
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
      
            $this->data['publisher_ho_id'] = $col[1];
            $this->data['publisher_email'] = $col[1];
            if(!is_null($col[0]) && !is_null($col[1]) && $col[1] != 'inof@marketeershub.com'){

                try {
                    // Get Account Manager 
                    $accountManager = User::select('id')->where('email',trim($col[20]))->first();
                    if($accountManager){
                        $this->accouManagerId = $accountManager->id;
                        $this->data['accountManager'] = $accountManager->id;

                    }
                    // Get Country Id
                    $countryName = $col[6] ?? $col[7];
                    $country = Country::select('id')->where('name_en', 'like', '%'.trim($countryName).'%')->orWhere('name_ar', 'like', '%'.trim($countryName).'%')->first();
                    if($country){
                        $this->countryId = $country->id;
                    }

                     // Get City Id
                    $city = City::select('id')->where('name_en', 'like', '%'.trim($col[8]).'%')->orWhere('name_ar', 'like', '%'.trim($col[8]).'%')->first();
                    if($city){
                        $this->cityId = $city->id;
                    }

                    // Get Status
                    // Get Status
                    $this->status = 'paused';
                    if($col[4] == 'live'){
                        $this->status = 'active';
                    }elseif($col[4] == 'paused'){
                        $this->status = 'pending';
                    }elseif($col[4] == 'closed'){
                        $this->status = 'closed';
                    }

                    // Get Cerrency Id 
                    $currency = Currency::where('name_en', 'like', '%'.$col[14].'%')
                        ->orWhere('name_ar', 'like', '%'.$col[14].'%')
                        ->orWhere('code', $col[14])
                        ->orWhere('sign', $col[14])
                        ->first();

                    // Get Category Id 
                    $category = Category::select('id')->where('title_ar', 'like', '%'.trim($col[14]).'%')->orWhere('title_en', 'like', '%'.trim($col[14]).'%')->first();


                } catch (\Throwable $th) {
                    Log::debug($th);
                }
                $this->data['accouManagerId'] = $this->accouManagerId;
                Log::debug( $this->data);
                $publisher = User::updateOrCreate([
                    'email' => $col[1]
                ],[
                    'ho_id' => $col[0] ? 'aff-'.$col[0] : null,
                    'password' => Hash::make('00000000'),
                    'email' => $col[1],
                    'name' => $col[2],
                    'gender' => $col[3] ?? 'male',
                    'status' => $this->status,
                    'account_title' => $col[5],
                    'country_id' => $this->countryId,  
                    'city_id' => $this->cityId, 
                    'owened_digital_assets' => $col[9],
                    'affiliate_networks' => $col[10],
                    'bank_branch_code' => $col[12],
                    'bank_name' => $col[13],
                    'years_of_experience' => $col[15],
                    'iban' => $col[16],
                    'swift_code' => $col[17],
                    'phone' => $col[18],
                    'traffic_sources' => $col[19],
                    'currency_id' => $currency ? $currency->id : null,
                    'team' => $this->team,
                    'parent_id' => $this->accouManagerId
                ]);

                $publisher->roles()->sync(4);
                $category ? $publisher->categories()->sync($category->id) : '';

                $this->countryId = null;
                $this->cityId = null;
                $this->accouManagerId = null;
                $this->currrencyId = null;
            }
        }
    }

}
