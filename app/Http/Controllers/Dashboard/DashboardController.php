<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index(){
        $this->authorize('view_countries');
        dd('ddddddddd');
        // dd(Gate::allows('admin'));
        // dd(request()->user()->can('admin'));
        return view('dashboard.home');
    }
}
