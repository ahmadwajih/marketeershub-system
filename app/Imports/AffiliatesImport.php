<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\DigitalAsset;
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
    public string $exportClass = 'Affiliates';
    private int $columns_count = 21;

    private $colName;
    private $colEmail;
    private $colPhone;
    private $colGender;
    private $colCountry;
    private $colStatus;
    private $colAccountManager;
    private $colCity;
    private $colCategory;
    private $colYearsOfExperience;
    private $colTrafficSources;
    private $colDigitalAssets;
    private $colIBAN;
    private $colSwiftCode;
    private $colBankAccountTitle;
    private $colBankName;
    private $colBankBranchCode;
    private $colCurrency;


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
            $this->colName = $col[0];
            $this->colEmail = $col[1];
            $this->colPhone = $col[2];
            $this->colGender = $col[3];
            $this->colCountry = $col[4];
            $this->colStatus = $col[5];
            $this->colAccountManager = $col[6];
            $this->colCategory = $col[7];
            $this->colYearsOfExperience = $col[8];
            $this->colTrafficSources = $col[9];
            $this->colDigitalAssets = $col[10];
            $this->colIBAN = $col[11];
            $this->colSwiftCode = $col[12];
            $this->colBankAccountTitle = $col[13];
            $this->colBankName = $col[14];
            $this->colBankBranchCode = $col[15];
            $this->colCurrency = $col[16];

            // todo remove duplicated code
            $col_array = $col->toArray();
            $row = array_slice($col_array, 0, $this->columns_count, true);
            if($this->containsOnlyNull($row))continue;
            /** @noinspection PhpUndefinedMethodInspection */
            if (Storage::has($this->module_name.'_importing_counts.json')){
                $this->importing_counts = json_decode(Storage::get($this->module_name.'_importing_counts.json'),true);
            }
            /** @noinspection PhpUndefinedMethodInspection */
            if (Storage::has($this->module_name.'_failed_rows.json')){
                $this->failed_rows = json_decode(Storage::get($this->module_name.'_failed_rows.json'),true);
            }
            /** @noinspection PhpUndefinedMethodInspection */
            if (Storage::has($this->module_name.'_duplicated_rows.json')){
                $this->duplicated_rows = json_decode(Storage::get($this->module_name.'_duplicated_rows.json'),true);
            }
            $this->importing_counts['rows_num']++;
            $this->data['publisher_email'] = $this->colEmail;
            $valid_email = true;
            if (!filter_var($this->colEmail, FILTER_VALIDATE_EMAIL)) {
                $valid_email = false;
            }
            if(!is_null($col[0]) && $this->colEmail != 'info@marketeershub.com' && $valid_email)
            {
                try {
                    // Get Account Manager
                    $accountManager = User::select('id')->where('email',trim($this->colAccountManager))->first();
                    if($accountManager){
                        $this->accouManagerId = $accountManager->id;
                        $this->data['accountManager'] = $accountManager->id;
                    }
                    if(trim($this->colAccountManager) == 'MarketeersHub'){
                        $this->accouManagerId = User::whereEmail('info@marketeershub.com')->orWhere('name', 'MarketeersHub')->first()->id;
                    }
                    // Get Country ID
                    $country = Country::select('id')->where('name_en', 'like', '%'.trim($this->colCountry).'%')->orWhere('name_ar', 'like', '%'.trim($this->colCountry).'%')->first();
                    if($country){$this->countryId = $country->id;}
                    
                    // Get Status
                    $this->status = 'pending';
                    $this->colStatus = strtolower($this->colStatus);
                    if ($this->colStatus){$this->status=$this->colStatus;}
                    if($this->colStatus == 'live'){
                        $this->status = 'active';
                    }elseif($this->colStatus == 'paused'){
                        $this->status = 'pending';
                    }elseif($this->colStatus == 'closed'){
                        $this->status = 'closed';
                    }
                    // Get Category ID
                    $category = Category::select('id')->where('title_ar', 'like', '%'.trim($this->colCategory).'%')->orWhere('title_en', 'like', '%'.trim($this->colCategory).'%')->first();
                }
                catch (\Throwable) {
                    $this->importing_counts['failed']++;
                    $this->failed_rows[] = $col_array;
                }
                $this->data['accouManagerId'] = $this->accouManagerId;
                // Log::debug( $this->data);
                $publisher = User::whereEmail($this->colEmail)->first();
                if($publisher){
                    $publisher->password        = $publisher->password ?? Hash::make('hhgEDfvgbhKmJhMjnBNKM');
                    $publisher->email           = $this->colEmail;
                    $publisher->name            = $publisher->name ?? $this->colName;
                    $publisher->gender          = strtolower($this->colGender) ?? 'male';
                    if ($this->status != $publisher->status){
                        $publisher->status = $this->status;
                    }
                    $publisher->account_title   = $publisher->account_title ?? $this->colBankAccountTitle;
                    $publisher->country_id      = $publisher->country_id ?? $this->countryId;
                    $publisher->city_id         = $publisher->city_id ?? $this->cityId;
                    $publisher->owened_digital_assets   = $publisher->owened_digital_assets ?? $this->colDigitalAssets;
                    $publisher->bank_branch_code        = $publisher->bank_branch_code ?? $this->colBankBranchCode;
                    $publisher->bank_name               = $publisher->bank_name ?? $this->colBankName;
                    $publisher->years_of_experience     = $publisher->years_of_experience ?? $this->colYearsOfExperience;
                    $publisher->iban                    = $publisher->iban ?? $this->colIBAN;
                    $publisher->swift_code              = $publisher->swift_code ?? $this->colSwiftCode;
                    $publisher->phone               = $publisher->phone ?? $this->colPhone;
                    $publisher->traffic_sources     = $publisher->traffic_sources ?? $this->colTrafficSources;
                    $publisher->currency         = $this->colCurrency;
                    $publisher->team                = $this->team;
                    $publisher->parent_id           = $this->accouManagerId;
                    $publisher->update();
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
                        'password' => Hash::make('00000000'),
                        'email' => $this->colEmail,
                        'name' => $this->colName,
                        'gender' => $this->colGender ?? 'male',
                        'status' => $this->status,
                        'account_title' => $this->colBankAccountTitle,
                        'country_id' => $this->countryId,
                        'city_id' => $this->cityId,
                        'owened_digital_assets' => $this->colDigitalAssets,
                        'bank_branch_code' => $this->colBankBranchCode,
                        'bank_name' => $this->colBankName,
                        'years_of_experience' => $this->colYearsOfExperience,
                        'iban' => $this->colIBAN,
                        'swift_code' => $this->colSwiftCode,
                        'phone' => $this->colPhone,
                        'traffic_sources' => $this->colTrafficSources,
                        'currency' => $this->colCurrency,
                        'team' => $this->team,
                        'parent_id' => $this->accouManagerId
                    ]);
                    Log::debug( implode(['status' => 'not_Exist', 'publisher' => $publisher]));
                    $this->importing_counts['new']++;
                }
                $role = Role::whereLabel('publisher')->first();
                $publisher->roles()->sync($role);
                $category ? $publisher->categories()->sync($category->id):"";

                if (isset($this->colDigitalAssets)) {

                    $trim = trim($this->colDigitalAssets);
                    $removesemicolumn = str_replace(';', '', $trim);
                    $removeSpaces = str_replace('  ', ' ', $removesemicolumn);
                    $links = explode(' ', $removeSpaces);
                    $links = array_filter($links);
                    foreach ($links as $link) {
                        $fullLink = explode('=', $link);
                        DigitalAsset::updateOrCreate(
                            [
                                'platform' => strtolower($fullLink[0]),
                                'user_id' => $publisher->id
                            ],
                            [
                                'link' => $fullLink[1],
                            ]
                        );
                    }

                }

                $this->countryId = null;
                $this->cityId = null;
                $this->accouManagerId = null;
                $this->currrencyId = null;
            }
            else{
                $this->importing_counts['failed']++;
                $this->failed_rows[] = $col_array;
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
