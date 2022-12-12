<?php

namespace Modules\Basic\Console;

use App\Exports\CompaniesMissingExport;
use App\Imports\V2\UpdateReportImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CompaniesImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'import:companies {offer_id} {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing Companies.';

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
        Excel::queueImport(new UpdateReportImport($this->argument('offer_id'), $this->argument('type'),$id), request()->file('report'));

        Storage::delete('companies_import.txt');

        // serialize your input array (say $array)
        $serializedData = serialize(session()->get('companies'));
        file_put_contents('missing_data_array_companies.txt', $serializedData);
        session()->forget('companies');
        Storage::delete('companies_import_in_progress.txt');
        return 1;
    }
}
