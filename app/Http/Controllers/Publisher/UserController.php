<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function profile()
    {
        $user = auth()->user();
        return view('publishers.users.profile', ['user' => $user]);
    }

}
