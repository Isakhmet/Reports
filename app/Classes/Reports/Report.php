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
     * @param $type
     * @param $report_type
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function report($type, $report_type, $from, $to);
}
