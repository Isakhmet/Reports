<?php

namespace App\Http\Controllers\API;

use App\CategoriesReport;
use App\Classes\GeneratorReport;
use App\Http\Controllers\Controller;
use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class APIReportController extends Controller
{
    protected function getData($table)
    {
        //$data['category'] = DB::table($table)->where()->select()->get()->toArray();

        $data['report'] = DB::table($table)->select('*')->get()->toArray();

        return $data;
    }

    public function index()
    {
        $categories = CategoriesReport::with('getReports')->get()->toArray();

        return $categories;
    }

    public function getCategories()
    {
        $categories = CategoriesReport::all();

        return $categories;
    }

    public function getReports()
    {
        $reports = Report::all();
        $data = json_decode(json_encode($reports), true);

        return $data;
    }
}
