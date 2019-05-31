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
                               ->paginate($perPage)
        ;
        $columns     = __('report.reports.hcb.columns');
        $keys        = array_keys($columns);
        $results     = json_decode(json_encode($query), true);
        $headers     = [];

        foreach ($results['data'] as $key => $result) {
            $results['data'][$key] = $transformer->transform($result, $keys);
        }

        foreach ($results['data'][0] as $key => $result) {
            $headers[] = $columns[$key];
        }

        $array            = $results;
        $array['headers'] = $headers;

        return $array;
    }
}
