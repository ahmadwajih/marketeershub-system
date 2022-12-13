<?php

namespace App\Console;

use App\Imports\V2\UpdateReportImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class PivotReportImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:pivot_report {offer_id} {type}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing Pivot report.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(): int
    {
        $id = now()->unix();
        session([ 'import' => $id ]);
        $data = [
            "id" => $id,
        ];
        Storage::put('import.json', json_encode($data));
        $import_file = Storage::get("pivot_report_import.txt");
        Excel::queueImport(
            new UpdateReportImport($this->argument('offer_id'), $this->argument('type'),$id),
            $import_file
        );
        return 1;
    }
}
