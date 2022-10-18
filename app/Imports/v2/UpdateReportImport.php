<?php

namespace App\Imports\V2;

use App\Exports\PivotReportErrorsExport;
use App\Models\Country;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\PivotReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Facades\Excel;

class UpdateReportImport implements ToCollection
{
    public $offerId;
    public $coupon;
    public $type;
    public $revenue;
    public $payout;
    public $columnHaveIssue = [];

    public function __construct($offerId, $type)
    {
        $this->offerId = $offerId;
        $this->type = $type;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        unset($collection[0]);
        Validator::make($collection->toArray(), [
            '*.0' => 'required',
            '*.1' => 'required|numeric',
            '*.2' => 'required|numeric',
            '*.3' => 'nullable|numeric',
            '*.4' => 'nullable|numeric',
            '*.6' => 'required',
        ])->validate();
        foreach ($collection as $index => $col) {
            $col[6] = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($col[6]));
            // 1- Fixed Model 
            if ($col[0]) {
                $coupon  = Coupon::where([
                    ['coupon', '=', $col[0]],
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
                    ['date', '=', $col[6]],
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
                        'orders' => $col[1],
                        'sales' => $col[2],
                        'revenue' => $this->calcRevenue($col),
                        'payout' => $this->calcPayout($col),
                        'type' => $this->type,
                        'date' => $col[6],
                        'offer_id' => $this->offerId,
                    ]);
                } else {
                   
                    if(gettype($this->calcRevenue($col)) != 'int'){
                        $col[] = $this->calcRevenue($col);
                        $this->columnHaveIssue[] = $col;
                    }
                    if(gettype($this->calcPayout($col)) != 'int'){
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
        // Get payout_cps_type ('static', 'new_old', 'slaps')
        $payout_cps_type = $this->offer()->payout_cps_type;
        if ($payout_cps_type == 'static') {
            return $this->static('payout', $col);
        }
        if ($payout_cps_type == 'new_old') {
            return $this->new_old('payout', $col);
        }
        if ($payout_cps_type == 'slaps') {
            return  $this->slaps('payout', $col);
        }
    }

    public function offer()
    {
        return Offer::where('id', $this->offerId)->first();
    }


    public function static($type, $col)
    {
        // Get Revenu details 
        $revenue_details = $this->offer()->cps->where('type', $type)->where('cps_type', 'static');

        $haveDateRange = $revenue_details->where('date_range', 1)->where('from_date', '!=', null)->where('to_date', '!=', null)->first();
        $haveCountries = $revenue_details->where('countries', 1)->where('countries_ids', '!=', null)->first();

        // Validate same dates 
        if ($haveDateRange && !$haveCountries) {
            $dateRangeOptions = $revenue_details->where('from_date', '<=', $col[6]->format('Y-m-d'))->where('to_date', '>=', $col[6]->format('Y-m-d'))->first();

            if ($dateRangeOptions) {
                if ($dateRangeOptions->amount_type == 'flat') {
                    $revenue = $col[1] * $dateRangeOptions->amount;
                } else {
                    $revenue = $col[2] * $dateRangeOptions->amount / 100;
                }
                return $revenue;
            } else {
                return 'The date range condition was not match 1';
            }
        }


        // Validate same country 
        if ($haveCountries && !$haveDateRange) {
            $countriesOptions = $revenue_details->where('countries', 1)->where('countries_ids', '!=', null);
            foreach ($countriesOptions as $option) {
                $optionCountriesArr = json_decode($option->countries_ids, true);
                $codeCountry = Country::select('id')->where('name_en', 'like', '%' . trim($col[5]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[5]) . '%')->orWhere('code', 'like', '%' . trim($col[5]) . '%')->first();
                if ($codeCountry && in_array($codeCountry->id, $optionCountriesArr)) {
                    if ($option->amount_type == 'flat') {
                        $revenue = $col[1] * $option->amount;
                    } else {
                        $revenue = $col[2] * $option->amount / 100;
                    }
                    return $revenue;
                    break;
                }
            }

            return 'The country condition was not match';
        }

        // Validate same country and same dates 
        if ($haveCountries && $haveDateRange) {
            $options = $revenue_details->where('from_date', '<=', $col[6]->format('Y-m-d'))->where('to_date', '>=', $col[6]->format('Y-m-d'))->where('countries', 1)->where('countries_ids', '!=', null);
            if ($options) {

                foreach ($options as $option) {
                    $optionCountriesArr = json_decode($option->countries_ids, true);
                    $codeCountry = Country::select('id')->where('name_en', 'like', '%' . trim($col[5]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[5]) . '%')->orWhere('code', 'like', '%' . trim($col[5]) . '%')->first();
                    if ($codeCountry && in_array($codeCountry->id, $optionCountriesArr)) {
                        if ($option->amount_type == 'flat') {
                            $revenue = $col[1] * $option->amount;
                        } else {
                            $revenue = $col[2] * $option->amount / 100;
                        }
                        return $revenue;
                        break;
                    }
                }
            }
            return 'The country condition and date range condition was not match';
        }

        // No date no countries  
        if (!$haveDateRange && !$haveCountries) {
            $dateRangeOptions = $revenue_details->first();

            if ($dateRangeOptions) {
                if ($dateRangeOptions->amount_type == 'flat') {
                    $revenue = $col[1] * $dateRangeOptions->amount;
                } else {
                    $revenue = $col[2] * $dateRangeOptions->amount / 100;
                }
                return $revenue;
            } else {
                return 'The date range condition was not match 2';
            }
        }


    }

    public function new_old($type, $col)
    {
        $revenue = 0;
        // Get Revenu details 
        $revenue_details = $this->offer()->cps->where('type', $type)->where('cps_type', 'new_old');
        $haveDateRange = $revenue_details->where('date_range', 1)->where('from_date', '!=', null)->where('to_date', '!=', null)->first();
        $haveCountries = $revenue_details->where('countries', 1)->where('countries_ids', '!=', null)->first();
      
        // Validate same dates 
        if ($haveDateRange && !$haveCountries) {
            $dateRangeOptions = $revenue_details->where('from_date', '<=', $col[6]->format('Y-m-d'))->where('to_date', '>=', $col[6]->format('Y-m-d'))->first();

            if ($dateRangeOptions) {
                if ($dateRangeOptions->amount_type == 'flat') {
                    $revenue += $col[3] * $dateRangeOptions->new_amount;
                    $revenue += $col[4] * $dateRangeOptions->old_amount;
                } else {
                    $revenue += $col[3] * $dateRangeOptions->new_amount / 100;
                    $revenue += $col[4] * $dateRangeOptions->old_amount / 100;
                }
                return $revenue;
            } else {
                return 'The date range condition was not match 3';
            }
        }


        // Validate same country 
        if ($haveCountries && !$haveDateRange) {
    
            $countriesOptions = $revenue_details->where('countries', 1)->where('countries_ids', '!=', null);
            foreach ($countriesOptions as $option) {
                $optionCountriesArr = json_decode($option->countries_ids, true);
                $codeCountry = Country::select('id')->where('name_en', 'like', '%' . trim($col[5]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[5]) . '%')->orWhere('code', 'like', '%' . trim($col[5]) . '%')->first();
               
                
                if ($codeCountry && in_array($codeCountry->id, $optionCountriesArr)) {
                    if ($option->amount_type == 'flat') {
                        $revenue += $col[3] * $option->new_amount;
                        $revenue += $col[4] * $option->old_amount;
                    } else {
                        $revenue += $col[3] * $option->new_amount / 100;
                        $revenue += $col[4] * $option->old_amount / 100;
                    }
                    return $revenue;
                    break;
                }
            }

            return 'The country condition was not match';
        }

        // Validate same country and same dates 

        if ($haveCountries && $haveDateRange) {
            $options = $revenue_details->where('from_date', '<=', $col[6]->format('Y-m-d'))->where('to_date', '>=', $col[6]->format('Y-m-d'))->where('countries', 1)->where('countries_ids', '!=', null);
            if ($options) {
                foreach ($options as $option) {
                    $optionCountriesArr = json_decode($option->countries_ids, true);
                    $codeCountry = Country::select('id')->where('name_en', 'like', '%' . trim($col[5]) . '%')->orWhere('name_ar', 'like', '%' . trim($col[5]) . '%')->orWhere('code', 'like', '%' . trim($col[5]) . '%')->first();
                    if ($codeCountry && in_array($codeCountry->id, $optionCountriesArr)) {
                        if ($option->amount_type == 'flat') {
                            $revenue += $col[3] * $option->new_amount;
                            $revenue += $col[4] * $option->old_amount;
                        } else {
                            $revenue += $col[3] * $option->new_amount / 100;
                            $revenue += $col[4] * $option->old_amount / 100;
                        }
                        return $revenue;
                        break;
                    }
                }
            }
            return 'The country condition and date range condition was not match';
        }

        // No date no countries  
        if (!$haveDateRange && !$haveCountries) {
            $dateRangeOptions = $revenue_details->first();

            if ($dateRangeOptions) {
                if ($dateRangeOptions->amount_type == 'flat') {
                    $revenue = $col[1] * $dateRangeOptions->amount;
                } else {
                    $revenue = $col[2] * $dateRangeOptions->amount / 100;
                }
                return $revenue;
            } else {
                return 'The date range condition was not match 4';
            }
        }
        
    }

    public function slaps($type, $col)
    {
        $revenue = 0;
        $slaps = $this->offer()->cps->where('type', $type)->where('cps_type', 'slaps');
        foreach ($slaps as $slap) {
            if ($col[2] > $slap->from && $slap->to) {
                $revenue = $slap->amount;
                return $revenue;
            }
        }

        return 'Slabs dosen`t match';
    }
    
}
