<?php

namespace App\Classes\Reports\Crm\LandingProdengi;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Request;

class LandingProdengi extends Connectors implements Report
{
    public $scoreGateClass;

    /**
     * @param     $reportType
     * @param int $page
     * @param int $perPage
     * @param     $from
     * @param     $to
     *
     * @return mixed
     */
    public function report($reportType, $page, $perPage, $from, $to)
    {
        $this->scoreGateClass = new GetFromScoreGate;
        $excel['data']        = $this->scoreGateClass->getData($from, $to);
        $currentPage          = Paginator::resolveCurrentPage();
        $col                  = collect($excel['data']);
        $currentPageItems     = $col->slice(($currentPage - 1) * $perPage, $perPage)
                                    ->all()
        ;
        $result               = new Paginator($currentPageItems, count($col), $perPage);
        $result->setPath(Request::url());
        $result            = json_decode(json_encode($result), true);
        $result['headers'] = __('report.reports.LandingProdengi.headers');

        if (!empty($result['data'])) {
            foreach ($result['headers'] as $key => $value) {
                $excel['columns'][$value] = $value;
            }
        }

        $result['excel'] = $excel;

        return $result;
    }
}
