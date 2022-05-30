<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Role;
use App\Models\SocialMediaLink;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
class InfluencerImport implements ToCollection, WithChunkReading, ShouldQueue
{
    public $team;
    public $status;
    public $countryId = null;
    public $cityId = null;
    public $accouManagerId = null;
    public $currrencyId = null;
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
            if(isset($col[3]) && isset($col[1])){

                // Get Account Manager 
                $accountManager = User::select('id')->where('email',trim($col[4]))->first();
                if($accountManager){
                    $this->accouManagerId = $accountManager->id;
                }

                // Get Country Id
                $country = Country::select('id')->where('name_en', 'like', '%'.trim($col[7]).'%')->orWhere('name_ar', 'like', '%'.trim($col[7]).'%')->first();
                if($country){
                    $this->countryId = $country->id;
                }
                // Get City Id
                $city = City::select('id')->where('name_en', 'like', '%'.trim($col[8]).'%')->orWhere('name_ar', 'like', '%'.trim($col[8]).'%')->first();
                if($city){
                    $this->cityId = $city->id;
                }

                // Get Status
                $this->status = 'paused';
                if($col[6] == 'live'){
                    $this->status = 'active';
                }elseif($col[6] == 'paused'){
                    $this->status = 'pending';
                }elseif($col[6] == 'closed'){
                    $this->status = 'closed';
                }

                // Get Cerrency Id 
                $currency = Currency::select('id')->where('name_en', 'like', '%'.trim($col[16]).'%')
                    ->orWhere('name_ar', 'like', '%'.trim($col[16]).'%')
                    ->orWhere('code', trim($col[16]))
                    ->orWhere('sign', trim($col[16]))
                    ->first();
                    if($currency){
                        $this->currrencyId = $currency->id;
                    }

                // Get Category Id 
                $category = Category::select('id')->where('title_ar', 'l~ike', '%'.trim($col[10]).'%')->orWhere('title_en', 'like', '%'.trim($col[10]).'%')->first();

                $publisher = User::updateOrCreate(
                    ['email' => $col[3]],
                    [
                        'ho_id' => $col[0] ? 'inf-' . $col[0] : null,
                        'name' => $col[1],
                        'phone' => $col[2],
                        'password' => Hash::make('00000000'),
                        'parent_id' => $this->accouManagerId,
                        'gender' => $col[5] ?? 'male',
                        'status' => $this->status,
                        'country_id' => $this->countryId,  
                        'city_id' => $this->cityId,  
                        'address' => $col[9] ?? null,
                        'account_title' => $col[11],
                        'bank_name' => $col[12],
                        'iban' => $col[15],
                        'bank_branch_code' => $col[13],
                        'swift_code' => $col[14],
                        'currency_id' => $this->currrencyId,
                        'team' => $this->team,
                    ]
                );

                $publisher->roles()->sync(4);
                $category ? $publisher->categories()->sync($category->id) : '';

                // Facebook
                if(!is_null($col[17])){
                    SocialMediaLink::updateOrCreate([
                        'platform' => 'facebook',
                        'user_id' => $publisher->id
                    ],
                    [
                        'link' => $col[17],
                        'followers' => $col[18] ?? 0,
                    ]);
                }
                 // Instagram
                 if(!is_null($col[19])){
                    SocialMediaLink::updateOrCreate([
                        'platform' => 'instagram',
                        'user_id' => $publisher->id
                    ],[
                        'link' => $col[19],
                        'followers' => $col[20] ?? 0,
                    ]);
                }

                // Twitter
                if(!is_null($col[21])){
                    SocialMediaLink::updateOrCreate([
                        'platform' => 'twitter',
                        'user_id' => $publisher->id
                    ],[
                        'link' => $col[21],
                        'followers' => $col[22] ?? 0,
                    ]);
                }

                // Snapchat
                if(!is_null($col[23])){
                    SocialMediaLink::updateOrCreate([
                        'platform' => 'snapchat',
                        'user_id' => $publisher->id,
                    ],
                    [
                        'link' => $col[23],
                        'followers' => $col[24] ?? 0,
                    ]);
                }
               
                // Tiktok
                if(!is_null($col[25])){
                    SocialMediaLink::updateOrCreate([
                        'platform' => 'tiktok',
                        'user_id' => $publisher->id
                    ],[
                        'link' => $col[25],
                        'followers' => $col[26] ?? 0,
                    ]);
                }
                // Youtube
                if(!is_null($col[27])){
                    SocialMediaLink::updateOrCreate([
                        'platform' => 'youtube',
                        'user_id' => $publisher->id
                    ],[
                        'link' => $col[27],
                        'followers' => $col[28] ?? 0,
                    ]);
                }

                $this->countryId = null;
                $this->cityId = null;
                $this->accouManagerId = null;
                $this->currrencyId = null;
                
            }

        }
    }
    public function chunkSize(): int
    {
        return 100;
    }
}
