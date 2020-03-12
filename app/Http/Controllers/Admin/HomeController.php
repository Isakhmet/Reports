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
        $countDeletedUsers    = User::withTrashed()
                                    ->whereNotNull('deleted_at')
                                    ->count()
        ;
        $countDisabledReports = Report::all()
                                      ->where('is_active', '=', false)
                                      ->count()
        ;
        $lastAddedUser        = User::all()
                                    ->last()
                                    ->first()
        ;

        $data = [
            'countUsers'           => $countUsers,
            'countReports'         => $countReports,
            'countDeletedUsers'    => $countDeletedUsers,
            'countDisabledReports' => $countDisabledReports,
            'lastAddedUser'        => $lastAddedUser->name,
        ];

        return view('admin.home', compact('data'));
    }

}
