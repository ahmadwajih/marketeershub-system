<?php

namespace App\Imports;

use App\Exports\AffiliatesExport;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Row;

class Import implements WithEvents,OnEachRow
{
    public int $id;

    public array $importing_counts = [
        'new'=>0,
        'updated'=>0,
        'failed'=>0,
        'duplicated'=>0,
        'rows_num' =>0,
    ];

    public string $module_name;
    /**
     * @throws Exception
     */
    protected array $failed_rows = [];
    protected array $duplicated_rows = [];

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        cache()->forever("current_row_{$this->id}", $rowIndex);
        Log::debug($rowIndex);
//        sleep(0.1);
    }
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $files = Storage::allFiles("public/missing/$this->module_name");
                Storage::delete($files);
                Storage::delete($this->module_name.'_importing_counts.json');
                Storage::delete($this->module_name.'_failed_rows.json');
                Storage::delete($this->module_name.'_duplicated_rows.json');

                ini_set('max_execution_time', 0);
                ini_set('memory_limit', "4095M");
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
                //Storage::delete($this->module_name.'_import_file.json');
                //todo check if it's a good practice to save all this data in the session or not
                $publishers_failed_rows = json_decode(Storage::get($this->module_name.'_failed_rows.json'),true);
                if(count($publishers_failed_rows)){
                    Excel::store(new AffiliatesExport($publishers_failed_rows),
                        "public/missing/$this->module_name/failed/failed_{$this->module_name}_rows_".date('m-d-Y_hia').".xlsx"
                    );
                }
                $publishers_duplicated_rows = json_decode(Storage::get($this->module_name.'_duplicated_rows.json'),true);
                if(count($publishers_duplicated_rows)){
                    Excel::store(new AffiliatesExport($publishers_duplicated_rows),
                        "public/missing/$this->module_name/duplicated/duplicated_{$this->module_name}_rows_".date('m-d-Y_hia').".xlsx"
                    );
                }
            },
        ];
    }
    function containsOnlyNull($input): bool
    {
        return empty(array_filter(
            $input,
            function ($a) {return $a !== null;}
        ));
    }
    protected function getCurrentCount()
    {
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
            $this->failed_rows = json_decode(Storage::get($this->module_name.'_duplicated_rows.json'),true);
        }
        $this->importing_counts['rows_num'] = $this->importing_counts['rows_num']++;
    }
}

