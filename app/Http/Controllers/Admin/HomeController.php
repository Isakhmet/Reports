<?php

namespace App\Http\Controllers\Admin;

use App\User;

class HomeController
{
    public function index()
    {
        $users = User::all();

        return view('admin.home', compact('users'));
    }

}
