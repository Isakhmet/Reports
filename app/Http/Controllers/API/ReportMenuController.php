<?php

namespace App\Http\Controllers\API;

use App\CategoriesReport;
use App\Http\Controllers\Controller;

class ReportMenuController extends Controller
{

    /**
     * Метод выгружает категории с их отчетами. Предназначен для меню.
     *
     * @return array
     * @api                 {post}
     * @apiSampleRequest    https://reporting.prodengi.kz/api/reports/getCategory
     * @apiName             getCategory
     * @apiDescription      Запрос выгружает категории с их отчетами.
     *                      P.S. Запрос не содержит параметров.
     *
     */
    public function index()
    {
        $data = CategoriesReport::with('getReports')
                                ->get()
        ;

        return $data;
    }
}
