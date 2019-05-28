<?php

namespace App\Classes\Reports\Oracle\ScoreClients;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Oracle\OracleReportService;
use App\Classes\Reports\Oracle\ScoreClients\Transformer\ScoreClientsTransformer;
use App\Classes\Reports\Report;
use Illuminate\Support\Facades\Request;

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
        $transformer = new ScoreClientsTransformer();
        $service     = new OracleReportService();
        $connect     = $this->connect($reportType);
        $query       = $connect->table('score_results')
                               ->where('created_at', '>=', $from . ' 00:00:00')
                               ->where('created_at', '<=', $to . ' 23:59:59')
                               ->get()
        ;

        if ($query->isEmpty()) {
            return response()->json(['Нет данных за указанный период'], 500);
        }

        $headers = __('report.reports.scoreClients.headers');
        $keys    = array_keys($headers);
        $headers = array_values($headers);
        $chunks  = $query->chunk(700000);
        $data    = $service->transformData($chunks->toArray()[0]);

        foreach ($data as $key => $row) {
            $data[$key] = $transformer->transformCommon($row, $keys);
        }

        $data             = collect($data);
        $array            = $service->paginate(
            $data, $perPage, $page, [
                     'path'     => Request::url(),
                     'pageName' => 'page',
                 ]
        )
                                    ->toArray()
        ;
        $array['headers'] = $headers;
        $array['data']    = $service->paginateOrder($array['data']);

        return $array;
    }
}
