<?php

namespace App\Classes\Reports\Oracle\ScorePoints;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Oracle\OracleReportService;
use App\Classes\Reports\Oracle\ScorePoints\Transformer\ScorePointsTransformer;
use App\Classes\Reports\Report;
use Illuminate\Support\Facades\Request;

/**
 * Class ScorePoints
 *
 * @package App\Classes\Reports\Oracle\ScorePoints
 */
class ScorePoints extends Connectors implements Report
{
    /**
     * @param $reportType
     * @param $page
     * @param $perPage
     * @param $from
     * @param $to
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function report($reportType, $page, $perPage, $from, $to)
    {
        $service     = new OracleReportService();
        $connect     = $this->connect($reportType);
        $first       = $connect->table('score_results')
                               ->first()
        ;
        $fields      = array_keys(json_decode($first->fields, true));
        $fields      = array_unique($fields);
        $columns     = __('report.reports.scorePoints.headers');
        $data        = $connect->table('fields')
                               ->whereIn('name', $fields)
                               ->pluck('title', 'name')
                               ->toArray()
        ;
        $columns     = array_merge($columns, $data);
        $keys        = array_keys($columns);
        $headers     = array_values($columns);
        $transformer = new ScorePointsTransformer();
        $query       = $connect->table('score_results')
                               ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                               ->orderBy('id')
        ;

        $excelData = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $result    = json_decode(json_encode($query->paginate($perPage)), true);
        $excel = [];
        $results = [];

        foreach ($result['data'] as $key => $value) {
            $array         = $transformer->availableProducts($service->transformData($value), $keys);
            $results[$key] = $transformer->transformCommon($array);
        }

        foreach ($excelData as $id => $row) {
            $array              = $transformer->availableProducts($service->transformData($row), $keys);
            $excel['data'][$id] = $transformer->transformExcel($array);
        }

        $excel['columns']  = array_flip($columns);
        $result['data']    = $results;
        $result['headers'] = $headers;
        $result['excel']   = $excel;

        return $result;
    }
}
