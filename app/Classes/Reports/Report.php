<?php

namespace App\Classes\Reports;

/**
 * Interface Report
 *
 * @package App\Classes\Reports
 */
interface Report
{
    /**
     * @param $reportType
     * @param $page
     * @param $perPage
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function report($reportType, $page, $perPage, $from, $to);
}
