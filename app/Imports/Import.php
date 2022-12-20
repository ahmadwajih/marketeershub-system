<?php

namespace App\Imports;

use Exception;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Row;

class Import implements WithEvents,OnEachRow
{
    public int $id;

    public string $module_name;
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
                Storage::delete($this->module_name.'_import_file.json');
            },
        ];
    }
}
