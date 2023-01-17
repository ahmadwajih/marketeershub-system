<?php

namespace App\Imports;

use App\Exports\PivotReportErrorsExport;
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
        'issues'=>0,
        'rows_num' =>0,
    ];

    public string $module_name;
    public string $exportClass;

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
                $failed_rows = json_decode(Storage::get($this->module_name.'_failed_rows.json'),true);
                $className = 'App\Exports\\'.$this->exportClass.'Export';

                if(count($failed_rows)){
                    Excel::store(new $className($failed_rows),
                        "public/missing/$this->module_name/failed/failed_{$this->module_name}_rows_".date('m-d-Y_hia').".xlsx"
                    );

                }
                $duplicated_rows = json_decode(Storage::get($this->module_name.'_duplicated_rows.json'),true);
                if(count($duplicated_rows)){
                    Excel::store(new $className($duplicated_rows),
                        "public/missing/$this->module_name/duplicated/duplicated_{$this->module_name}_rows_".date('m-d-Y_hia').".xlsx"
                    );
                }

                if (Storage::has($this->module_name.'_issues_rows.json')){
                    $issues_rows = json_decode(Storage::get($this->module_name.'_issues_rows.json'),true);
                    if(count($issues_rows)){
                        Excel::store(new PivotReportErrorsExport($issues_rows),
                            "public/missing/$this->module_name/issues/issues_{$this->module_name}_rows_".date('m-d-Y_hia').".xlsx"
                        );
                    }
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
}

