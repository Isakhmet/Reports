<?php

namespace App\Http\Controllers\Admin;

use App\Report;
use App\User;

class HomeController
{
    public function index()
    {
        $countUsers           = User::all()
                                    ->count()
        ;
        $countReports         = Report::all()
                                      ->count()
        ;

        $data = [
            'countUsers'           => $countUsers,
            'countReports'         => $countReports,
        ];

        return view('admin.home', compact('data'));
    }

}
