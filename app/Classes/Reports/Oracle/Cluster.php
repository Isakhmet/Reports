<?php

namespace App\Classes\Reports\Oracle;

use App\Classes\Connectors\Connectors;
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
        $connect = $this->connect($reportType);
        $query   = $connect->table('clusters')
                           ->where('created_at', '>=', $from . ' 00:00:00')
                           ->where('created_at', '<=', $to . ' 23:59:59')
                           ->paginate($perPage)
        ;
        $result  = json_decode(json_encode($query), true);

        return $result;
    }
}
