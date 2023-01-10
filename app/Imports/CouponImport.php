<?php

namespace App\Imports;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CouponImport extends Import implements ToCollection, WithStartRow,WithChunkReading,ShouldQueue
{
    public string $module_name = 'coupons';
    public $offerId;
    public $test = [];
    public $totlaUploadedSuccessfully = 0;
    public $totlaUpdatedSuccessfully = 0;
    public int $totlaCreatedSuccessfully = 0;

    public string $exportClass = 'Coupons';

    public function __construct($offerId,$id)
    {
        $this->offerId = $offerId;
        $this->id = $id;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        Validator::make($collection->toArray(), [
            '*.0' => 'required|max:20',
        ])->validate();

        foreach ($collection as $col) {
            $col_array = $col->toArray();
            if($this->containsOnlyNull($col_array))continue;
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
            if (!is_null($col[0])) {
                $userId = null;
                if (isset($col[1])) {
                    if ($col[1] == 1000 || $col[1] == 'inf-1000' || $col[1] == 'aff-1000') {
                        $publisher = User::where('email', 'info@marketeershub.com')->first();
                    } else {
                        $publisher = User::where('id', $col[1])->first();
                    }
                    if ($publisher) {
                        $userId = $publisher->id;
                    }
                }
                $coupon = Coupon::where([
                    ['coupon', '=',  $col[0]],
                    ['offer_id', '=', $this->offerId]
                ])->first();

                $this->test['coupon_code'] = $col[0];
                $this->test['offer_id'] = $this->offerId;
                $this->test['user_id'] = $userId;
                Log::debug($this->test);

                if ($coupon) {
                    $coupon->user_id = $userId;
                    $coupon->save();
                    if ($coupon->wasChanged()){
                        $this->importing_counts['updated']++;
                    }else{
                        // already updated
                        $this->importing_counts['duplicated']++;
                        $this->duplicated_rows[] = $col_array;
                    }
                    $this->totlaUpdatedSuccessfully++;
                } else {
                    Coupon::create([
                        'coupon' => $col[0],
                        'offer_id' => $this->offerId,
                        'user_id' => $userId,
                    ]);
                    $this->importing_counts['new']++;
                    $this->totlaCreatedSuccessfully++;
                }
                $this->totlaUploadedSuccessfully++;
            }else{
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
    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 10;
    }
}
