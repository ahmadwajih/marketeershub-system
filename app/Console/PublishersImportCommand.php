<?php

namespace App\Console;

use App\Imports\AffiliatesImport;
use App\Imports\InfluencerImport;
use App\Imports\InfluencerImportWithNoQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
class PublishersImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:publishers {team}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing publisher based on the team option.';
    private $module_name = 'publishers';

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
        set_time_limit(0);
        Storage::delete($this->module_name.'_importing_counts.json');
        Storage::delete($this->module_name.'_failed_rows.json');
        $id = now()->unix();
        session([ 'import' => $id ]);
        session()->put('publishers_failed_rows', []);
        $data = ["id" => $id];
        Storage::put('publishers_import_data.json', json_encode($data));
        $import_file = Storage::get("publishers_import_file.json");
        $team = $this->argument('team');
        if ($team == 'affiliate') {
            Excel::import(new AffiliatesImport($team,$id), $import_file);
        }
        if ($team == 'influencer') {
            Excel::import(new InfluencerImportWithNoQueue($team,$id), $import_file);
        }
        return 1;
    }
}
