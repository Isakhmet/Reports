<?php

namespace App\Http\Controllers;

use App\Classes\GeneratorReport;
use Illuminate\Http\Request;

/**
 * Class ReportController
 *
 * @package App\Http\Controllers
 */
class ReportController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function getReport(Request $request)
    {
        $data = $request->toArray();

        if (isset($data['type'])) {
            $report = (new GeneratorReport)->generate($data);
            $result = [];

            if ($report['data'] ?? false && !empty($report['data'])) {
                $result['meta']   = [
                    "current_page" => $report['current_page'],
                    "from"         => $report['from'],
                    "last_page"    => $report['last_page'],
                    "path"         => $report['path'],
                    "per_page"     => $report['per_page'],
                    "to"           => $report['to'],
                    "total"        => $report['total'],
                ];
                $result['keys']   = $report['headers'];
                $result['report'] = $report['data'];
            }

            return $result;
        }
    }
}
