<?php

namespace App\Classes\Reports\Oracle\Hcb\Long;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Oracle\Hcb\Transformer\HcbLongTransformer;
use App\Classes\Reports\Report;

/**
 * Class HcbLong
 *
 * @package App\Classes\Reports\Oracle\Hcb\Long
 */
class HcbLong extends Connectors implements Report
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
    public function report($reportType, $page, $perPage, $from, $to)
    {
        $transformer = new HcbLongTransformer();
        $connect     = $this->connect($reportType);
        $query       = $connect->table('pre_approve_leads')
                               ->where('created_at', '>=', $from . ' 00:00:00')
                               ->where('created_at', '<=', $to . ' 23:59:59')
        ;
        $excelData = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $columns     = __('report.reports.hcb.columns');
        $keys        = array_keys($columns);
        $headers     = array_values($columns);
        $results     = json_decode(json_encode($query->paginate($perPage)), true);
        $excel['columns'] = array_flip($columns);

        foreach ($results['data'] as $key => $result) {
            $results['data'][$key] = $transformer->transform($result, $keys);
        }

        foreach ($excelData as $key => $result) {
            $excel['data'][$key] = $transformer->transform($result, $keys);
        }

        $results['headers'] = $headers;
        $results['excel']   = $excel;
        
        return $results;
    }
}
