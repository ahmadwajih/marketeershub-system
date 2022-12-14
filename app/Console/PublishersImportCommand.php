<?php

namespace App\Console;

use App\Imports\InfluencerImport;
use App\Imports\PublishersImport;
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
        $data = ["id" => $id];
        Storage::put('publishers_import_data.json', json_encode($data));
        $import_file = Storage::get("publishers_import.json");
        $team = $this->argument('team');
        if ($team == 'affiliate') {
            Excel::import(new PublishersImport($team,$id), $import_file);
        }
        if ($team == 'influencer') {
            Excel::import(new InfluencerImport($team,$id), $import_file);
        }
        return 1;
    }
}
