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
     * @param $report_type
     * @param $page
     * @param $per_page
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function report($report_type, $page, $per_page, $from, $to);
}
