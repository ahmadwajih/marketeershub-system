<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\SocialMediaLink;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class InfluencerImport extends Import implements ToCollection, WithChunkReading, WithEvents, WithStartRow, ShouldQueue
{
    public string $team;
    public $status;
    public $countryId = null;
    public $cityId = null;
    public $accouManagerId = null;
    public $currrencyId = null;
    public string $module_name = 'publishers';
    private int $columns_count = 28;

    private $colName;
    private $colEmail;
    private $colPhone;
    private $colAccountManager;
    private $colGender;
    private $colStatus;
    private $colCountry;
    private $colCity;
    private $colAddress;
    private $colCategory;
    private $colBankAccountTitle;
    private $colBankName;
    private $colBankBranchCode;
    private $colSwiftCode;
    private $colIBAN;
    private $colCurrency;
    private $colInfluencerType;
    private $colInfluencerRating;
    private $colSocialMediaLinks;

    public string $exportClass = 'Influencers';

    public function __construct($team, $id)
    {
        $this->team = $team;
        $this->id = $id;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        //unset($collection[0]);
        foreach ($collection as $col) {

            $this->colName = $col[0];
            $this->colEmail = $col[1];
            $this->colPhone = $col[2];
            $this->colGender = $col[3];
            $this->colCountry = $col[4];
            $this->colStatus = $col[5];
            $this->colAccountManager = $col[6];
            $this->colCategory = $col[7];
            $this->colCity = $col[8];
            $this->colAddress = $col[9];
            $this->colInfluencerType = $col[10];
            $this->colInfluencerRating = $col[11];
            $this->colSocialMediaLinks = $col[12];
            $this->colIBAN = $col[13];
            $this->colSwiftCode = $col[14];
            $this->colBankAccountTitle = $col[15];
            $this->colBankName = $col[16];
            $this->colBankBranchCode = $col[17];
            $this->colCurrency = $col[18];

            // todo: refactor - remove the duplicated code
            // todo fix method not found
            $col_array = $col->toArray();
            $row = array_slice($col_array, 0, $this->columns_count, true);
            if ($this->containsOnlyNull($row)) {
                continue;
            }
            if (Storage::has($this->module_name . '_importing_counts.json')) {
                $this->importing_counts = json_decode(Storage::get($this->module_name . '_importing_counts.json'), true);
            }
            if (Storage::has($this->module_name . '_failed_rows.json')) {
                $this->failed_rows = json_decode(Storage::get($this->module_name . '_failed_rows.json'), true);
            }
            if (Storage::has($this->module_name . '_duplicated_rows.json')) {
                $this->duplicated_rows = json_decode(Storage::get($this->module_name . '_duplicated_rows.json'), true);
            }
            $this->importing_counts['rows_num']++;

            $valid_email = true;
            if (!filter_var($this->colEmail, FILTER_VALIDATE_EMAIL)) {
                $valid_email = false;
            }
            if (isset($this->colEmail) && $valid_email && $this->colEmail != 'info@marketeershub.com') {
                // Get Account Manager
                $accountManager = User::select('id')->where('email', trim($this->colAccountManager))->first();
                if ($accountManager) {
                    $this->accouManagerId = $accountManager->id;
                }
                // Get Country ID
                $country = Country::select('id')->where('name_en', 'like', '%' . trim($this->colCountry) . '%')->orWhere('name_ar', 'like', '%' . trim($this->colCountry) . '%')->first();
                if ($country) {
                    $this->countryId = $country->id;
                }
                // Get City ID
                $city = City::select('id')->where('name_en', 'like', '%' . trim($this->colCity) . '%')->orWhere('name_ar', 'like', '%' . trim($this->colCity) . '%')->first();
                if ($city) {
                    $this->cityId = $city->id;
                }
                // Get Status
                $this->status = 'active';
                $this->colStatus = strtolower($this->colStatus);
                if ($this->colStatus) {
                    $this->status = $this->colStatus;
                }
                if ($this->colStatus == 'live') {
                    $this->status = 'active';
                } elseif ($this->colStatus == 'paused') {
                    $this->status = 'pending';
                }
                // Get Category ID
                $category = Category::select('id')->where('title_ar', 'like', '%' . trim($this->colCategory) . '%')->orWhere('title_en', 'like', '%' . trim($this->colCategory) . '%')->first();
                $publisher = User::whereEmail($this->colEmail)->first();
                if ($publisher) {
                    // Count Updated
                    $publisher->name = $publisher->name ??  $this->colName;
                    $publisher->phone = $publisher->phone ??  $this->colPhone;
                    // $publisher->password = $publisher->password ??  Hash::make('hhgEDfvgbhKmJhMjnBNKM');
                    $publisher->parent_id = $publisher->parent_id ??  $this->accouManagerId;
                    $publisher->gender = $publisher->gender ??  $this->colGender ?? 'male';
                    if ($this->status != $publisher->status) {
                        $publisher->status = $this->status;
                    }
                    $publisher->country_id = $publisher->country_id ??  $this->countryId;
                    $publisher->city_id = $publisher->city_id ??  $this->cityId;
                    $publisher->address = $publisher->address ??  $this->colAddress ?? null;
                    $publisher->account_title = $publisher->account_title ??  $this->colBankAccountTitle;
                    $publisher->bank_name = $publisher->bank_name ??  $this->colBankName;
                    $publisher->iban = $publisher->iban ??  $this->colIBAN;
                    $publisher->bank_branch_code = $publisher->bank_branch_code ??  $this->colBankBranchCode;
                    $publisher->swift_code = $publisher->swift_code ??  $this->colSwiftCode;
                    $publisher->currency_id = $publisher->currency_id ??  $this->currrencyId;
                    $publisher->team = $publisher->team ??  $this->team;
                    $publisher->influencer_type = $publisher->influencer_type ??  $this->colInfluencerType;
                    $publisher->influencer_rating = $publisher->influencer_rating ??  $this->colInfluencerRating;
                    $publisher->currency = $publisher->currency ??  $this->colCurrency;
                    $publisher->update();
                    if ($publisher->wasChanged()) {
                        $this->importing_counts['updated']++;
                    } else {
                        // already updated
                        $this->importing_counts['duplicated']++;
                        $this->duplicated_rows[] = $col_array;
                    }
                    Log::debug(json_encode(['status' => 'Yes_Exists', 'publisher' => $publisher]));
                } else {
                    // count added
                    $publisher = User::create(
                        [
                            'name' => $this->colName,
                            'phone' => $this->colPhone,
                            'email' => $this->colEmail,
                            'password' => Hash::make('hhgEDfvgbhKmJhMjnBNKM'),
                            'parent_id' => $this->accouManagerId,
                            'gender' => $this->colGender ?? 'male',
                            'status' => $this->status,
                            'country_id' => $this->countryId,
                            'city_id' => $this->cityId,
                            'address' => $this->colAddress ?? null,
                            'account_title' => $this->colBankAccountTitle,
                            'bank_name' => $this->colBankName,
                            'iban' => $this->colIBAN,
                            'bank_branch_code' => $this->colBankBranchCode,
                            'swift_code'  => $this->colSwiftCode,
                            'currency_id' => $this->currrencyId,
                            'team' => $this->team,
                            'influencer_type' => $this->colInfluencerType,
                            'influencer_rating' => $this->colInfluencerRating,
                            'currency' => $this->colCurrency,
                        ]
                    );
                    $this->importing_counts['new']++;
                    //Log::debug( ['status' => 'No_Exists', 'publisher' => $publisher]);
                }
                $role = Role::whereLabel('publisher')->first();
                $publisher->roles()->sync($role);
                $category ? $publisher->categories()->sync($category->id) : '';

                if (isset($this->colSocialMediaLinks)) {

                    $trim = trim($this->colSocialMediaLinks);
                    $removesemicolumn = str_replace(';', '', $trim);
                    $removeSpaces = str_replace('  ', ' ', $removesemicolumn);
                    $links = explode(' ', $removeSpaces);
                    $links = array_filter($links);
                    foreach ($links as $link) {
                        $fullLink = explode('=', $link);
                        SocialMediaLink::updateOrCreate(
                            [
                                'platform' => strtolower($fullLink[0]),
                                'user_id' => $publisher->id
                            ],
                            [
                                'link' => $fullLink[1],
                                'followers' => $this->colInfluencerRating ?? 0,
                            ]
                        );
                    }

                }

                $this->countryId = null;
                $this->cityId = null;
                // $this->accouManagerId = null;
                $this->currrencyId = null;
            } else {
                $this->importing_counts['failed']++;
                $this->failed_rows[] = $col_array;
            }
            Storage::put($this->module_name . '_importing_counts.json', json_encode($this->importing_counts));
            Storage::put($this->module_name . '_failed_rows.json', json_encode($this->failed_rows));
            Storage::put($this->module_name . '_duplicated_rows.json', json_encode($this->duplicated_rows));
        }
    }
    public function chunkSize(): int
    {
        return 20;
    }
    public function startRow(): int
    {
        return 2;
    }
}
