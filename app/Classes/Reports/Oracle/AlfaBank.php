<?php

namespace App\Classes\Reports\Oracle;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;

/**
 * Class AlfaBank
 *
 * @package App\Classes\Reports\Oracle
 */
class AlfaBank extends Connectors implements Report
{

    /**
     * @param     $report_type
     * @param int $page
     * @param int $per_page
     * @param     $from
     * @param     $to
     *
     * @return mixed
     */
    public function report($report_type, $page, $per_page, $from, $to)
    {
        $connect = $this->connect($report_type);
        $query   = $connect->table('alpha_bank_leads')
                           ->where('created_at', '>=', $from . ' 00:00:00')
                           ->where('created_at', '<=', $to . ' 23:59:59')
                           ->paginate($per_page)
        ;
        $result  = json_decode(json_encode($query), true);

        return $result;
    }
}
