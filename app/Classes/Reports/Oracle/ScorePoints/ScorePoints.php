<?php

namespace App\Classes\Reports\Oracle\ScorePoints;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Oracle\OracleReportService;
use App\Classes\Reports\Oracle\ScorePoints\Transformer\ScorePointsTransformer;
use App\Classes\Reports\Report;
use Illuminate\Support\Facades\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

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
        $transformer = new ScorePointsTransformer();
        $connect     = $this->connect($reportType);
        $first       = $connect->table('score_results')
                               ->first()
        ;
        $fields      = array_keys(json_decode($first->fields, true));
        $fields      = array_unique($fields);

        $columns = __('report.reports.scorePoints.headers');
        $data    = $connect->table('fields')
                           ->whereIn('name', $fields)
                           ->pluck('title', 'name')
                           ->toArray()
        ;
        $columns = $transformer->exclusionOfExtraFields(array_merge($columns, $data));
        $keys    = array_keys($columns);
        $headers = array_values($columns);
        $query   = $connect->table('score_results')
                           ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                           ->orderBy('id')
        ;

        $excelData = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );

        $scoreIds = array_map(
            function ($item) {
                return $item['id'];
            }, $excelData
        );

        $crmConnect = $this->connect('crm');
        $ga         = $crmConnect->table('crm_request_in')
                                 ->whereIn('oracle_id', $scoreIds)
                                 ->join(
                                     'google_client_ids', 'crm_request_in.id', '=', 'google_client_ids.request_in_id'
                                 )
                                 ->select('crm_request_in.oracle_id', 'google_client_ids.ga')
                                 ->get()
                                 ->keyBy('oracle_id')
                                 ->toArray()
        ;
        $ga         = json_decode(json_encode($ga), true);

        if (count($ga) > 0) {
            $excelData = array_map(
                function ($item) use ($ga) {
                    $newItem       = $item;
                    $newItem['ga'] = array_key_exists($item['id'], $ga) ? $ga[$item['id']]['ga'] : '';

                    return $newItem;
                }, $excelData
            );
        }

        $currentPage      = Paginator::resolveCurrentPage();
        $col              = collect($excelData);
        $currentPageItems = $col->slice(($currentPage - 1) * $perPage, $perPage)
                                ->all()
        ;
        $result           = new Paginator($currentPageItems, count($col), $perPage);
        $result->setPath(Request::url());
        $result = json_decode(json_encode($result), true);

        $excel   = [];
        $results = [];

        foreach ($result['data'] as $value) {
            $array     = $transformer->availableProducts($service->transformData($value), $keys);
            $results[] = $transformer->transformCommon($array, $headers);
        }

        foreach ($excelData as $row) {
            $array           = $transformer->availableProducts($service->transformData($row), $keys);
            $excel['data'][] = $transformer->transformCommon($array, $headers);
        }

        $excel['columns']  = $columns;
        $result['data']    = $results;
        $result['headers'] = $headers;
        $result['excel']   = $excel;

        return $result;
    }
}
