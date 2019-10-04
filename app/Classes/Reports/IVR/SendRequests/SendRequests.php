<?php

namespace App\Classes\Reports\IVR\SendRequests;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;

class SendRequests extends Connectors implements Report
{
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
        $fromFormatted  = $from . ' 09:00:00';
        $toFormatted   = $to . ' 09:02:00';
        $service       = new SendRequestTransformer();
        $crmData       = $service->QueryGeneration('crm', $fromFormatted, $toFormatted);
        $asterData     = $service->QueryGeneration('aster', $fromFormatted, $toFormatted);
        $ivrData       = $service->QueryGeneration('ivr', $fromFormatted, $toFormatted);
        $report_data   = $service->generate($ivrData, $crmData, $asterData);
        $columns       = __('report.reports.ivr.ivr_send.headers');
        $excel['data'] = json_decode(
            json_encode(
                $report_data
            ), true
        );
        $result        = json_decode(
            json_encode(
                $service->paginate($report_data, 15)
            ), true
        );
        $array         = [];
        $count         = 0;

        if ($result['current_page'] > 1) {
            foreach ($result['data'] as $key => $row) {
                $array[$count] = $row;
                $count++;
            }
            $result['data'] = $array;
        }
        $result['headers'] = array_values($columns);
        $excel['columns']  = $columns;
        $result['excel']   = $excel;

        return $result;
    }
}