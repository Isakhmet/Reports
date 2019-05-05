<?php

namespace App\Http\Controllers;

use App\Classes\GeneratorReport;
use App\Http\Resources\ReportResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDO;

class ReportController extends Controller
{
    public function getReport(Request $request){

        $data = $request->toArray();

        if(isset($data['type'])){
            (new GeneratorReport)->generate($data);
        }
    }
}
