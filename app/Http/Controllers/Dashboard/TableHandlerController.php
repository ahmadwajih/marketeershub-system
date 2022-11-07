<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TableHandlerController extends Controller
{
    public function setTableLength(Request $request){
        $request->validate([
            'table_length' => 'required|numeric'
        ]);
        if (isset($request->table_length) && $request->table_length  != null) {
            session()->put('table_length', $request->table_length);
        }
        if (session()->has('table_length') == false) {
            session()->put('table_length', config('app.pagination_pages'));
        }
        return redirect()->back();
    }
}
