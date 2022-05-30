<?php

namespace App\Exports;

use App\Models\PivotReport;
use Maatwebsite\Excel\Concerns\FromCollection;

class PivotReportExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $report;
    
    public function __construct(PivotReport $report)
    {
        $this->report = $report;
    }
    public function collection()
    {
        return PivotReport::all();
        
    }

    
}
