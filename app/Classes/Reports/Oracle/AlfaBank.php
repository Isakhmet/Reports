<?php

namespace App\Classes\Reports\Oracle;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;
use Illuminate\Support\Arr;

/**
 * Class AlfaBank
 *
 * @package App\Classes\Reports\Oracle
 */
class AlfaBank extends Connectors implements Report
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
        $connect  = $this->connect($reportType);
        $query    = $connect->table('alpha_bank_leads')
                            ->where('created_at', '>=', $from . ' 00:00:00')
                            ->where('created_at', '<=', $to . ' 23:59:59')
        ;
        $excelData = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $result   = json_decode(json_encode($query->paginate($perPage)), true);
        $statuses = __('report.reports.alfaBank.statuses');
        $cities   = __('report.reports.alfaBank.cities');
        $columns  = __('report.reports.alfaBank.columns');
        $keys     = array_keys($columns);
        $headers  = array_values($columns);
        $excel['columns'] = array_flip($columns);

        foreach ($excelData as $key => $row) {
            $excelData[$key]['status_id'] = $statuses[$row['status_id']];
            $excelData[$key]['towns']     = $cities[$row['towns']];
            $excelData[$key]              = Arr::only($excelData[$key], $keys);
        }

        $excel['data'] = $excelData;

        foreach ($result['data'] as $key => $row) {
            $result['data'][$key]['status_id'] = $statuses[$row['status_id']];
            $result['data'][$key]['towns']     = $cities[$row['towns']];
            $result['data'][$key]              = Arr::only($result['data'][$key], $keys);
        }

        $result['headers'] = $headers;
        $result['excel']   = $excel;

        return $result;
    }
}
