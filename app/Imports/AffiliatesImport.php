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
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AffiliatesImport extends Import implements ToCollection, WithChunkReading, ShouldQueue,WithStartRow
{
    public string $team;
    public string $status;
    public int|null $countryId = null;
    public int|null $cityId = null;
    public int|null $accouManagerId = null;
    public int|null $currrencyId = null;
    public array $data = [];
    public string $module_name = 'publishers';
    private int $columns_count = 21;

    public function __construct($team,$id)
    {
        $this->team = $team;
        $this->id = $id;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $category = null;
        foreach ($collection as $col)
        {
            // todo remove duplicated code
            $col_array = $col->toArray();
            $row = array_slice($col_array, 0, $this->columns_count, true);
            if($this->containsOnlyNull($row))continue;
            $this->getCurrentCount();
            $this->data['publisher_ho_id'] = $col[0];
            $this->data['publisher_email'] = $col[1];
            if(!is_null($col[0]) && !is_null($col[1]) && $col[1] != 'info@marketeershub.com')
            {
                try {
                    // Get Account Manager
                    $accountManager = User::select('id')->where('email',trim($col[20]))->first();
                    if($accountManager){
                        $this->accouManagerId = $accountManager->id;
                        $this->data['accountManager'] = $accountManager->id;
                    }
                    if(trim($col[20]) == 'MarketeersHub'){
                        $this->accouManagerId = User::whereEmail('info@marketeershub.com')->orWhere('name', 'MarketeersHub')->first()->id;
                    }
                    // Get Country ID
                    $countryName = $col[6] ?? $col[7];
                    $country = Country::select('id')->where('name_en', 'like', '%'.trim($countryName).'%')->orWhere('name_ar', 'like', '%'.trim($countryName).'%')->first();
                    if($country){$this->countryId = $country->id;}
                    // Get City ID
                    $city = City::select('id')->where('name_en', 'like', '%'.trim($col[8]).'%')->orWhere('name_ar', 'like', '%'.trim($col[8]).'%')->first();
                    if($city){
                        $this->cityId = $city->id;
                    }
                    // Get Status
                    $this->status = 'pending';
                    $col[4] = strtolower($col[4]);
                    if ($col[4]){$this->status=$col[4];}
                    if($col[4] == 'live'){
                        $this->status = 'active';
                    }elseif($col[4] == 'paused'){
                        $this->status = 'pending';
                    }elseif($col[4] == 'closed'){
                        $this->status = 'closed';
                    }
                    // Get Currency
                    $currency = Currency::where('name_en', 'like', '%'.$col[11].'%')
                        ->orWhere('name_ar', 'like', '%'.$col[11].'%')
                        ->orWhere('code', $col[14])
                        ->orWhere('sign', $col[14])
                        ->first()
                    ;
                    // Get Category ID
                    $category = Category::select('id')->where('title_ar', 'like', '%'.trim($col[11]).'%')->orWhere('title_en', 'like', '%'.trim($col[11]).'%')->first();
                }
                catch (\Throwable $th) {
                    $this->importing_counts['failed']++;
                    $this->failed_rows[] = $col_array;
                }
                $this->data['accouManagerId'] = $this->accouManagerId;
                // Log::debug( $this->data);
                $publisher = User::whereEmail($col[1])->first();
                if($publisher){
                    if ($publisher->ho_id !=  'aff-'.$col[0]){
                        $publisher->ho_id           = $col[0] ? 'aff-'.$col[0] : null;
                    }
                    $publisher->password        = $publisher->password ?? Hash::make('hhgEDfvgbhKmJhMjnBNKM');
                    $publisher->email           = $col[1];
                    $publisher->name            = $publisher->name ?? $col[2];
                    $publisher->gender          = strtolower($col[3]) ?? 'male';
                    if ($this->status != $publisher->status){
                        $publisher->status = $this->status;
                    }
                    $publisher->account_title   = $publisher->account_title ?? $col[5];
                    $publisher->country_id      = $publisher->country_id ?? $this->countryId;
                    $publisher->city_id         = $publisher->city_id ?? $this->cityId;
                    $publisher->owened_digital_assets   = $publisher->owened_digital_assets ?? $col[9];
                    $publisher->affiliate_networks      = $publisher->affiliate_networks ?? $col[10];
                    $publisher->bank_branch_code        = $publisher->bank_branch_code ?? $col[12];
                    $publisher->bank_name               = $publisher->bank_name ?? $col[13];
                    $publisher->years_of_experience     = $publisher->years_of_experience ?? $col[15];
                    $publisher->iban                    = $publisher->iban ?? $col[16];
                    $publisher->swift_code              = $publisher->swift_code ?? $col[17];
                    $publisher->phone               = $publisher->phone ?? $col[18];
                    $publisher->traffic_sources     = $publisher->traffic_sources ?? $col[19];
                    $publisher->currency_id         = $currency ? $currency->id : null;
                    $publisher->team                = $this->team;
                    $publisher->parent_id           = $this->accouManagerId;
                    $publisher->save();
                    if ($publisher->wasChanged()){
                        $this->importing_counts['updated']++;
                    }else{
                        // already updated
                        $this->importing_counts['duplicated']++;
                        $this->duplicated_rows[] = $col_array;
                    }
                    Log::debug(implode(['status' => 'Yes_Exists', 'publisher' => $publisher]));
                }
                else{
                    $publisher = User::create([
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
                    Log::debug( implode(['status' => 'not_Exist', 'publisher' => $publisher]));
                    $this->importing_counts['new']++;
                }
                $role = Role::whereLabel('publisher')->first();
                $publisher->roles()->sync($role);
                $category ? $publisher->categories()->sync($category->id):"";
                $this->countryId = null;
                $this->cityId = null;
                $this->accouManagerId = null;
                $this->currrencyId = null;
            }
            else{
                if (!$this->containsOnlyNull($col_array)){
                    $this->importing_counts['failed']++;
                    $this->failed_rows[] = $col_array;
                }
            }
            Storage::put($this->module_name.'_importing_counts.json', json_encode($this->importing_counts));
            Storage::put($this->module_name.'_failed_rows.json', json_encode($this->failed_rows));
            Storage::put($this->module_name.'_duplicated_rows.json', json_encode($this->duplicated_rows));
        }
    }
    public function chunkSize(): int
    {
        return 10;
    }
    public function startRow(): int
    {
        return 2;
    }
}
