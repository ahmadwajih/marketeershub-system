<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Role;
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

class PublishersImportNasedOnAcountManagerAndTeam implements ToCollection
{
    public $team;
    public $status;
    public $countryId = null;
    public $nationalityId = null;
    public $cityId = null;
    public $accouManagerId = null;
    public $currrencyId = null;
    public $data = [];
    public function __construct($team, $accouManagerId)
    {
        $this->team = $team;
        $this->accouManagerId = $accouManagerId;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        foreach ($collection as $index => $col) {

            if (!is_null($col[0]) && !is_null($col[3]) && $col[3] != 'info@marketeershub.com') {
   
                try {
                    // Get Country Id
                    $country = Country::select('id')->where('name_en', 'like', '%' . trim($col[11]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[11]) . '%')->orWhere('code',  'like', '%' . trim($col[11]) . '%')->first();
                    if ($country) {
                        $this->countryId = $country->id;
                    }

                    // Get Nationality Id
                    $nationality = Country::select('id')->where('name_en', 'like', '%' . trim($col[12]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[12]) . '%')->orWhere('code',  'like', '%' . trim($col[12]) . '%')->first();
                    if ($nationality) {
                        $this->nationalityId = $nationality->id;
                    }

                    // Get City Id
                    $city = City::select('id')->where('name_en', 'like', '%' . trim($col[15]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[15]) . '%')->first();
                    if ($city) {
                        $this->cityId = $city->id;
                    }

                    // Get Status
                    // Get Status
                    $this->status = 'paused';
                    if ($col[9] == 'live') {
                        $this->status = 'active';
                    } elseif ($col[9] == 'paused') {
                        $this->status = 'pending';
                    } elseif ($col[9] == 'closed') {
                        $this->status = 'closed';
                    }


                    // Get Category Id 
                    $category = Category::select('id')->where('title_ar', 'like', '%' . trim($col[5]) . '%')->orWhere('title_en', 'like', '%' . trim($col[5]) . '%')->first();
                } catch (\Throwable $th) {
                    Log::debug($th);
                }
     
                $publisher = User::whereEmail($col[3])->first();
                if ($publisher) {
                    $publisher->ho_id           = $this->team == 'affiliate' ? 'aff-' . $col[0] : 'inf-' . $col[0];
                    $publisher->password        = $publisher->password ?? Hash::make('hhgEDfvgbhKmJhMjnBNKM');
                    $publisher->email           = $col[3];
                    $publisher->name            = $publisher->name ?? $col[1];
                    $publisher->gender          = $col[16] ?? 'male';
                    $publisher->status          = $this->status;
                    $publisher->country_id      = $publisher->country_id ?? $this->countryId;
                    $publisher->nationality      = $publisher->nationality ?? $this->nationalityId;
                    $publisher->city_id         = $publisher->city_id ?? $this->cityId;
                    $publisher->phone               = $publisher->phone ?? $col[2];
                    $publisher->traffic_sources     = $publisher->traffic_sources ?? $col[10];
                    $publisher->currency_id         = Currency::whereCode('USD')->first()->id;
                    $publisher->team                = $this->team;
                    $publisher->parent_id           = $this->accouManagerId;
                    $publisher->save();

                    Log::debug(['status' => 'Yes_Exists', 'publisher' => $publisher]);
                } else {

                    $publisher = User::create([
                        'ho_id'         => $this->team == 'affiliate' ? 'aff-' . $col[0] : 'inf-' . $col[0],
                        'password'      => Hash::make('hhgEDfvgbhKmJhMjnBNKM'),
                        'email'         => $col[3],
                        'name'          => $col[1],
                        'gender'        => $col[16] ?? 'male',
                        'status'        => $this->status,
                        'country_id'    => $this->countryId,
                        'nationality'   => $this->nationalityId,
                        'city_id'       => $this->cityId,
                        'phone'         => $col[2],
                        'traffic_sources' => $col[10],
                        'currency_id'   =>  Currency::whereCode('USD')->first()->id,
                        'team'          => $this->team,
                        'parent_id'     => $this->accouManagerId
                    ]);
                    Log::debug(['status' => 'not_Exist', 'publisher' => $publisher]);
                }
                $role = Role::whereLabel('publisher')->first();
                $publisher->roles()->sync($role);
                $category ? $publisher->categories()->sync($category->id) : '';

                $this->countryId = null;
                $this->cityId = null;
            }
        }
    }
}
