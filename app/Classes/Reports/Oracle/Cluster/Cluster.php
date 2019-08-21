<?php

namespace App\Classes\Reports\Oracle\Cluster;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Oracle\Cluster\Transformer\ClusterTransformer;
use App\Classes\Reports\Report;

/**
 * Class Cluster
 *
 * @package App\Classes\Reports\Oracle
 */
class Cluster extends Connectors implements Report
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
        $transformer  = new ClusterTransformer();
        $connect      = $this->connect($reportType);
        $query        = $connect->table('clusters')
                                ->where('created_at', '>=', $from . ' 00:00:00')
                                ->where('created_at', '<=', $to . ' 23:59:59')
        ;
        $excelData    = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $result       = json_decode(json_encode($query->paginate($perPage)), true);
        $columns      = __('report.reports.cluster.columns');
        $keys         = array_keys($columns);
        $headers      = array_values($columns);
        $months       = __('report.reports.cluster.months');
        $monthColumns = [];

        foreach ($months as $month) {
            $monthColumns[$month] = "amounts.$month";
        }

        unset($columns['amounts']);
        $excel['columns'] = array_merge(array_flip($columns), $monthColumns);

        foreach ($excelData as $id => $value) {
            $excel['data'][$id] = $transformer->transform($value, $keys);
        }

        foreach ($result['data'] as $key => $row) {
            $result['data'][$key] = $transformer->transform($row, $keys);
        }

        $result['headers'] = $headers;
        $result['excel']   = $excel;

        return $result;
    }
}
