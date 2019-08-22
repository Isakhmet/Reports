<?php

namespace App\Classes\Reports\Oracle\ScoreClients;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Oracle\OracleReportService;
use App\Classes\Reports\Oracle\ScoreClients\Transformer\ScoreClientsTransformer;
use App\Classes\Reports\Report;

class ScoreClients extends Connectors implements Report
{

    /**
     * @param $reportType
     * @param $page
     * @param $perPage
     * @param $from
     * @param $to
     *
     * @return array|\Illuminate\Http\JsonResponse|mixed
     */
    public function report($reportType, $page, $perPage, $from, $to)
    {
        $transformer      = new ScoreClientsTransformer();
        $service          = new OracleReportService();
        $connect          = $this->connect($reportType);
        $query            = $connect->table('score_results')
                                    ->where('created_at', '>=', $from . ' 00:00:00')
                                    ->where('created_at', '<=', $to . ' 23:59:59')
        ;
        $excelData        = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $headers          = __('report.reports.scoreClients.headers');
        $excel['columns'] = array_flip($headers);
        $keys             = array_keys($headers);
        $headers          = array_values($headers);
        $result           = json_decode(json_encode($query->paginate($perPage)), true);
        $data             = [];

        foreach ($excelData as $key => $row) {
            $row                 = $service->transformData($row);
            $excel['data'][$key] = $transformer->transformCommon($row, $keys);
        }

        foreach ($result['data'] as $key => $value) {
            $value      = $service->transformData($value);
            $data[$key] = $transformer->transformCommon($value, $keys);
        }

        $result['data']    = $data;
        $result['headers'] = $headers;
        $result['excel']   = $excel;

        return $result;
    }
}
