<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Facades\SallaFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SallaInfoController extends Controller
{
    public function installApp(Request $request){
        try {
            // Store Salla Auth info
            $sallaAuth = SallaFacade::storeAuthData($request->code);

            // Store salla store info
            SallaFacade::storeUserInfo($sallaAuth->id);

            return redirect()->route('salla.installed.successfully');

        } catch (\Throwable $th) {
            Log::errot($th);
            return redirect()->route('salla.installed.failed');
        }
    }
}
