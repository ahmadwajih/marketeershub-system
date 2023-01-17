<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;


class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = auth()->user();

        return view('publishers.publishers.new_profile', ['user' => $user]);
    }

}
