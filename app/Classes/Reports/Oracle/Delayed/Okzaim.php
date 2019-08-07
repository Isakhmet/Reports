<?php

namespace App\Classes\Reports\Oracle\Delayed;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Oracle\Delayed\Transformer\OkzaimTransformer;
use App\Classes\Reports\Report;
use Illuminate\Support\Arr;

class Okzaim extends Connectors implements Report
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
        $transformer = new OkzaimTransformer();
        $connect  = $this->connect($reportType);
        $query    = $connect->table('okzaim_sends as os')
                            ->leftJoin('score_results as sr', 'sr.id', '=', 'os.lead_id')
                            ->leftJoin('send_statuses as ss', 'ss.id', '=', 'os.status_id')
                            ->where('os.created_at', '>=', $from . ' 00:00:00')
                            ->where('os.created_at', '<=', $to . ' 23:59:59')
                            ->select(
                                'os.*',
                                'sr.iin',
                                'sr.firstname',
                                'sr.lastname',
                                'sr.middlename',
                                'sr.mobile_phone',
                                'sr.email',
                                'sr.ore',
                                'ss.name'
                            )
                            ->paginate($perPage)
        ;
        $result   = json_decode(json_encode($query), true);
        $columns   = __('report.reports.okzaim.columns');
        $keys     = array_keys($columns);
        $headers  = array_values($columns);

        foreach ($result['data'] as $key => $row) {

            $result['data'][$key]              = $transformer->transform($row, $keys);
        }

        $array            = $result;
        $array['headers'] = $headers;

        return $array;
    }
}
