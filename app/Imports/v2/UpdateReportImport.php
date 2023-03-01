<?php

namespace App\Imports\v2;

use App\Exports\PivotReportErrorsExport;
use App\Imports\Import;
use App\Models\Country;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\PivotReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UpdateReportImport extends Import implements OnEachRow, ToCollection, WithChunkReading, ShouldQueue, WithStartRow
{
    public $offerId;
    public $coupon;
    public $type;
    public $revenue;
    public $payout;
    public $columnHaveIssue = [];
    public string $module_name = "pivot_report";

    public string $exportClass = 'PivotReportErrors';

    public function __construct($offerId, $type, int $id)
    {
        $this->offerId = $offerId;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {

        foreach ($collection as  $col) {
            $col = $col->toArray();
            $col = array_slice($col, 0, 8, true);

            // skip if contains null only
            if ($this->containsOnlyNull($col)) continue;
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
            /** @noinspection PhpUndefinedMethodInspection */
            if (Storage::has($this->module_name.'_issues_rows.json')){
                $this->columnHaveIssue = json_decode(Storage::get($this->module_name.'_issues_rows.json'),true);
            }
            $this->importing_counts['rows_num']++;

            $organic = false;
            $issue = "";
            try {
                if (is_int($col[0])) {
                    $col[0] = Carbon::instance(Date::excelToDateTimeObject($col[0]));
                } else {
                    $col[0] = str_replace("\\", "/", $col[0]);
                    $col[0] = date('Y-m-d', strtotime($col[0]));
                }
                Log::info(implode(['date' =>  $col[0]]));
                try {
                    $coupon = null;
                    // 1- Fixed Model
                    if ($col[1]) {
                        $coupon  = Coupon::where([
                            ['coupon', '=', $col[1]],
                            ['offer_id', '=', $this->offerId]
                        ])->first();
                    }
                    // Check if these coupons belong to user in the same team
                    if ($coupon) {
                        // 1- coupon_exist
                        if (!$coupon->user) {
                            $coupon->user_id = marketersHubPublisherInfo()->id;
                            $coupon->update();
                            $issue .= 'Coupons Not assigned - ';
                            $organic = true;
                            $this->importing_counts['issues']++;
                            $col[] = $issue;
                            $this->columnHaveIssue[] = $col;
                        }
                        $this->coupon = $coupon;
                        //Check If exists
                        $pivotReport  = PivotReport::where([
                            ['coupon_id', '=', $coupon->id],
                            ['date', '=', $col[0]->format('Y-m-d')],
                        ])->first();
                        // 2- pivot not exist
                        if (gettype($this->calcRevenue($col)) != 'string' && gettype($this->calcPayout($col)) != 'string') {
                                // 1- calculation is correct
                                PivotReport::create([
                                    'coupon_id' => $coupon->id,
                                    'user_id' => $coupon->user_id,
                                    'orders' => $col[2],
                                    'sales' => $col[3],
                                    'revenue' => $this->calcRevenue($col),
                                    'payout' => $this->calcPayout($col),
                                    'type' => $this->type,
                                    'date' => $col[0]->format('Y-m-d'),
                                    'offer_id' => $this->offerId,
                                ]);
                                if (!$organic) {
                                    $this->importing_counts['updated']++;
                                }
                            } else {
                                // 2- calculation is not correct
                                if (gettype($this->calcRevenue($col)) != 'int') {
                                    $issue .= $this->calcRevenue($col) . " - ";
                                }
                                if (gettype($this->calcPayout($col)) != 'int') {
                                    $issue .= $this->calcPayout($col) ." - ";
                                }
                                $col[] = $issue;
                                $this->failed_rows[] = $col;
                                $this->importing_counts['failed']++;
                            }
                    }
                    else {
                        // 2- coupon_exist
                        $col[] = "Coupons doesn't exists";
                        $this->importing_counts['failed']++;
                        $this->failed_rows[] = $col;
                    }
                } catch (\Throwable $th) {
                    $col[] = $th->getMessage();
                    Log::debug( $th->getMessage());
                    Log::debug( $th->getTraceAsString());
                    Log::debug( implode(['status' => 'error', '$col' => $col]));
                    $this->importing_counts['failed']++;
                    $this->failed_rows[] = $col;
                }
            } catch (\Throwable $th) {
                Log::debug( $th->getTraceAsString());
                $col[] = $th->getMessage();
                $this->importing_counts['failed']++;
                $this->failed_rows[] = $col;
            }
            Storage::put($this->module_name.'_issues_rows.json', json_encode($this->columnHaveIssue));
            Storage::put($this->module_name.'_importing_counts.json', json_encode($this->importing_counts));
            Storage::put($this->module_name.'_failed_rows.json', json_encode($this->failed_rows));
            Storage::put($this->module_name.'_duplicated_rows.json', json_encode($this->duplicated_rows));
        }
    }

    public function calcRevenue($col)
    {
        // Get revenue_cps_type ('static', 'new_old', 'slaps')
        $revenue_cps_type = $this->offer()->revenue_cps_type;

        if ($revenue_cps_type == 'static') {
            return $this->static('revenue', $col);
        }
        if ($revenue_cps_type == 'new_old') {
            return $this->new_old('revenue', $col);
        }
        if ($revenue_cps_type == 'slaps') {
            return  $this->slaps('revenue', $col);
        }

        return 'Error';
    }

    public function calcPayout($col)
    {
        $haveCustomPayout = false;
        $payout_cps_type = $this->offer()->payout_cps_type;

        if ($this->coupon->have_custom_payout && count($this->coupon->cps) > 0) {
            $haveCustomPayout = true;
            $payout_cps_type = $this->coupon->payout_cps_type;
        }

        // Get payout_cps_type ('static', 'new_old', 'slaps')
        if ($payout_cps_type == 'static') {
            return $this->static('payout', $col, $haveCustomPayout);
        }
        if ($payout_cps_type == 'new_old') {
            return $this->new_old('payout', $col, $haveCustomPayout);
        }
        if ($payout_cps_type == 'slaps') {
            return  $this->slaps('payout', $col, $haveCustomPayout);
        }
    }

    public function offer()
    {
        return Offer::where('id', $this->offerId)->first();
    }


    public function static($type, $col, $haveCustomPayout = false)
    {
        // Get Revenu details
        if ($haveCustomPayout) {
            $revenue_details = $this->coupon->cps->where('type', $type)->where('cps_type', 'static');
        } else {
            $revenue_details = $this->offer()->cps->where('type', $type)->where('cps_type', 'static');
        }

        $haveDateRange = $revenue_details->where('date_range', 1)->where('from_date', '!=', null)->where('to_date', '!=', null)->first();
        $haveCountries = $revenue_details->where('countries', 1)->where('countries_ids', '!=', null)->first();

        // Validate same dates
        if ($haveDateRange && !$haveCountries) {
            $dateRangeOptions = $revenue_details->where('from_date', '<=', $col[0]->format('Y-m-d'))->where('to_date', '>=', $col[0]->format('Y-m-d'))->first();

            if ($dateRangeOptions) {
                if ($dateRangeOptions->amount_type == 'flat') {
                    $revenue = $col[2] * $dateRangeOptions->amount;
                } else {
                    $revenue = $col[3] * $dateRangeOptions->amount / 100;
                }
                return $revenue;
            } else {
                return 'The date range condition was not match type => ' . $type;
            }
        }


        // Validate same country
        if ($haveCountries && !$haveDateRange) {
            $countriesOptions = $revenue_details->where('countries', 1)->where('countries_ids', '!=', null);
            foreach ($countriesOptions as $option) {
                $optionCountriesArr = json_decode($option->countries_ids, true);
                $codeCountry = Country::select('id')->where('name_en', 'like', '%' . trim($col[4]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[4]) . '%')->orWhere('code', 'like', '%' . trim($col[4]) . '%')->first();
                if ($codeCountry && in_array($codeCountry->id, $optionCountriesArr)) {
                    if ($option->amount_type == 'flat') {
                        $revenue = $col[2] * $option->amount;
                    } else {
                        $revenue = $col[3] * $option->amount / 100;
                    }
                    return $revenue;
                    break;
                }
            }

            return 'The country condition was not match type => ' . $type;
        }

        // Validate same country and same dates
        if ($haveCountries && $haveDateRange) {
            $options = $revenue_details->where('from_date', '<=', $col[0]->format('Y-m-d'))->where('to_date', '>=', $col[0]->format('Y-m-d'))->where('countries', 1)->where('countries_ids', '!=', null);
            if ($options) {
                foreach ($options as $option) {
                    $optionCountriesArr = json_decode($option->countries_ids, true);
                    $codeCountry = Country::select('id')->where('name_en', 'like', '%' . trim($col[4]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[4]) . '%')->orWhere('code', 'like', '%' . trim($col[4]) . '%')->first();
                    if ($codeCountry && in_array($codeCountry->id, $optionCountriesArr)) {
                        if ($option->amount_type == 'flat') {
                            $revenue = $col[2] * $option->amount;
                        } else {
                            $revenue = $col[3] * $option->amount / 100;
                        }
                        return $revenue;
                        break;
                    }
                }
            }
            return 'The country condition and date range condition was not match type => ' . $type;
        }

        // No date no countries
        if (!$haveDateRange && !$haveCountries) {
            $option = $revenue_details->where('date_range', 0)->where('countries', 0)->first();
            if ($option) {
                if ($option->amount_type == 'flat') {
                    $revenue = $col[2] * $option->amount;
                } else {
                    $revenue = $col[3] * $option->amount / 100;
                }
                return $revenue;
            } else {
                return 'The date range condition was not match  type => ' . $type;
            }
        }
    }

    public function new_old($type, $col, $haveCustomPayout = false)
    {
        $revenue = 0;
        // Get Revenu details
        if ($haveCustomPayout) {
            $revenue_details = $this->coupon->cps->where('type', $type)->where('cps_type', 'new_old');
        } else {
            $revenue_details = $this->offer()->cps->where('type', $type)->where('cps_type', 'new_old');
        }
        $haveDateRange = $revenue_details->where('date_range', 1)->where('from_date', '!=', null)->where('to_date', '!=', null)->first();
        $haveCountries = $revenue_details->where('countries', 1)->where('countries_ids', '!=', null)->first();

        // Validate same dates
        if ($haveDateRange && !$haveCountries) {
            $dateRangeOptions = $revenue_details->where('from_date', '<=', $col[0]->format('Y-m-d'))->where('to_date', '>=', $col[0]->format('Y-m-d'))->first();

            if ($dateRangeOptions) {
                if ($dateRangeOptions->amount_type == 'flat') {
                    $revenue += $col[4] * $dateRangeOptions->new_amount;
                    $revenue += $col[5] * $dateRangeOptions->old_amount;
                } else {
                    $revenue += $col[4] * $dateRangeOptions->new_amount / 100;
                    $revenue += $col[5] * $dateRangeOptions->old_amount / 100;
                }
                return $revenue;
            } else {
                return 'The date range condition was not match  type => ' . $type;
            }
        }


        // Validate same country
        if ($haveCountries && !$haveDateRange) {
            $countriesOptions = $revenue_details->where('countries', 1)->where('countries_ids', '!=', null);
            foreach ($countriesOptions as $option) {
                $optionCountriesArr = json_decode($option->countries_ids, true);
                $codeCountry = Country::select('id')->where('name_en', 'like', '%' . trim($col[6]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[6]) . '%')->orWhere('code', 'like', '%' . trim($col[6]) . '%')->first();


                if ($codeCountry && in_array($codeCountry->id, $optionCountriesArr)) {
                    if ($option->amount_type == 'flat') {
                        $revenue += $col[4] * $option->new_amount;
                        $revenue += $col[5] * $option->old_amount;
                    } else {
                        $revenue += $col[4] * $option->new_amount / 100;
                        $revenue += $col[5] * $option->old_amount / 100;
                    }
                    return $revenue;
                    break;
                }
            }

            return 'The country condition was not match type => ' . $type;
        }

        // Validate same country and same dates

        if ($haveCountries && $haveDateRange) {
            $options = $revenue_details->where('from_date', '<=', $col[0]->format('Y-m-d'))->where('to_date', '>=', $col[0]->format('Y-m-d'))->where('countries', 1)->where('countries_ids', '!=', null);
            if ($options) {
                foreach ($options as $option) {
                    $optionCountriesArr = json_decode($option->countries_ids, true);
                    $codeCountry = Country::select('id')->where('name_en', 'like', '%' . trim($col[6]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[6]) . '%')->orWhere('code', 'like', '%' . trim($col[6]) . '%')->first();
                    if ($codeCountry && in_array($codeCountry->id, $optionCountriesArr)) {
                        if ($option->amount_type == 'flat') {
                            $revenue += $col[4] * $option->new_amount;
                            $revenue += $col[5] * $option->old_amount;
                        } else {
                            $revenue += $col[4] * $option->new_amount / 100;
                            $revenue += $col[5] * $option->old_amount / 100;
                        }
                        return $revenue;
                        break;
                    }
                }
            }
            return 'The country condition and date range condition was not match type => ' . $type;
        }

        // No date no countries
        if (!$haveDateRange && !$haveCountries) {
            $option = $revenue_details->where('date_range', 0)->where('countries', 0)->first();
            if ($option) {
                if ($option->amount_type == 'flat') {
                    $revenue += $col[4] * $option->new_amount;
                    $revenue += $col[5] * $option->old_amount;
                } else {
                    $revenue += $col[4] * $option->new_amount / 100;
                    $revenue += $col[5] * $option->old_amount / 100;
                }
                return $revenue;
            } else {
                return 'No conditions  type => ' . $type;
            }
        }
    }
    public function slaps($type, $col,  $haveCustomPayout = false): string
    {
        if ($haveCustomPayout) {
            $slaps = $this->coupon->cps->where('type', $type)->where('cps_type', 'slaps');
        } else {
            $slaps = $this->offer()->cps->where('type', $type)->where('cps_type', 'slaps');
        }
        foreach ($slaps as $slap) {
            if ($col[3] > $slap->from && $slap->to) {
                $revenue = $slap->amount;
                return $revenue;
            }
        }
        return "Slabs doesn't match type => " . $type;
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
