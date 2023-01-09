<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public string $module_name = '';

    protected function bulk_import_result(&$import_file): ?string
    {
        /** @noinspection PhpUndefinedMethodInspection */
        if (Storage::has($this->module_name.'_importing_counts.json')){
            $import_file = Storage::get($this->module_name.'_importing_counts.json');
        }
        $directory = "public/missing/$this->module_name";
        $files = Storage::allFiles($directory);
        if($files){
            return route("admin.$this->module_name.files.download");
        }
        return null;
    }
}
