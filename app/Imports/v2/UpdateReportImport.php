<?php

namespace App\Imports\v2;

use App\Exports\PivotReportErrorsExport;
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

class UpdateReportImport implements OnEachRow, WithEvents, ToCollection, WithChunkReading
{
    public $offerId;
    public $coupon;
    public $type;
    public $revenue;
    public $payout;
    public $columnHaveIssue = [];
    public $id;

    public function __construct($offerId, $type,int $id)
    {
        ini_set('max_execution_time', 120000);
        ini_set('post_max_size', 120000);
        ini_set('upload_max_filesize', 100000);
        ini_set('memory_limit', '2048M');

        $this->offerId = $offerId;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        $cpsType = $this->offer()->payout_cps_type;
        if ($cpsType == 'static' || $cpsType == 'slaps') {
            Validator::make($collection->toArray(), [
                '*.0' => 'required',
                '*.1' => 'required',
                '*.2' => 'required|numeric',
                '*.3' => 'required|numeric',
            ])->validate();
        }

        if ($cpsType == 'new_old') {
            Validator::make($collection->toArray(), [
                '*.0' => 'required',
                '*.1' => 'required',
                '*.2' => 'required|numeric',
                '*.3' => 'required|numeric',
                '*.4' => 'required|numeric',
                '*.5' => 'required|numeric',
            ])->validate();
        }
        foreach ($collection as $index => $col) {
            try {
                $col[0] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($col[0]));

            } catch (\Throwable $th) {
                $this->columnHaveIssue[] = ['Please make sure the first column is valid date.'];
                session(['columnHaveIssue' => $this->columnHaveIssue]);
                return false;
            }

            // 1- Fixed Model
            if ($col[1]) {
                $coupon  = Coupon::where([
                    ['coupon', '=', $col[1]],
                    ['offer_id', '=', $this->offerId]
                ])->first();
            }

            // Check if this coupons is belong to user in the same team
            if ($coupon) {
                if (!$coupon->user) {
                    $coupon->user_id = marketersHubPublisherInfo()->id;
                    $coupon->update();
                    $col[] = 'Coupons Not assigned';
                    $this->columnHaveIssue[] = $col;
                }

                $this->coupon = $coupon;

                //Cheeck If exists
                $pivotReport  = PivotReport::where([
                    ['coupon_id', '=', $coupon->id],
                    ['date', '=', $col[0]],
                ])->first();


                if ($pivotReport) {
                    // $pivotReport->update([
                    //     'orders' => $col[1],
                    //     'sales' => $col[2],
                    //     'revenue' => $this->calcRevenue($col[1] , $col[2], $col[5]),
                    //     'payout' => $this->calcPayout($col[1] , $col[2], $col[5]),
                    //     'type' => $this->type,
                    //     'offer_id' => $this->offerId,
                    // ]);
                    $col[] = "Dublicate date for same coupon in same day";
                    $this->columnHaveIssue[] = $col;
                }

                if (gettype($this->calcRevenue($col)) != 'string' && gettype($this->calcPayout($col)) != 'string') {
                    PivotReport::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => $coupon->user_id,
                        'orders' => $col[2],
                        'sales' => $col[3],
                        'revenue' => $this->calcRevenue($col),
                        'payout' => $this->calcPayout($col),
                        'type' => $this->type,
                        'date' => now(),
                        'offer_id' => $this->offerId,
                    ]);
                } else {

                    if (gettype($this->calcRevenue($col)) != 'int') {
                        $col[] = $this->calcRevenue($col);
                        $this->columnHaveIssue[] = $col;
                    }
                    if (gettype($this->calcPayout($col)) != 'int') {
                        $col[] = $this->calcPayout($col);
                        $this->columnHaveIssue[] = $col;
                    }
                }
            } else {

                // $coupon = Coupon::create([
                //     'coupon' => $col[0],
                //     'offer_id' => $this->offerId,
                //     'user_id' => marketersHubPublisherInfo()->id // here add marketeers hub affiliate default publisher account
                // ]);
                $col[] = "Coupons doesn't exists";
                $this->columnHaveIssue[] = $col;
            }
        }
        session(['columnHaveIssue' => $this->columnHaveIssue]);
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
        return 50;
    }
    /**
     * @throws Exception
     */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        cache()->forever("current_row_{$this->id}", $rowIndex);
        //sleep(2.2);
    }
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $totalRows = $event->getReader()->getTotalRows();
                if (filled($totalRows)) {
                    cache()->forever("total_rows_{$this->id}", array_values($totalRows)[0]);
                    cache()->forever("start_date_{$this->id}", now()->unix());
                }
            },
            AfterImport::class => function () {
                cache(["end_date_{$this->id}" => now()], now()->addMinute());
                cache()->forget("total_rows_{$this->id}");
                cache()->forget("start_date_{$this->id}");
                cache()->forget("current_row_{$this->id}");
                Storage::delete('pivot_report_import.txt');
            },
        ];
    }
}
