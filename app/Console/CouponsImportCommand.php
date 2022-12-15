<?php

namespace App\Console;

use App\Imports\CouponImport;
use App\Imports\InfluencerImport;
use App\Imports\PublishersImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
class CouponsImportCommand extends Command
{
    public string $module_name = 'coupons';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "import:coupons {offer_id}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Importing coupons based on the team offer_id.";

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
        Storage::put($this->module_name.'_import_data.json', json_encode($data));
        $import_file = Storage::get($this->module_name."_import_file.json");
        $offer_id = $this->argument('offer_id');
        Excel::import(new CouponImport($offer_id,$id), $import_file);
        return 1;
    }
}
