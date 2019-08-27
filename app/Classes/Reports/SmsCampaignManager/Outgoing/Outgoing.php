<?php

namespace App\Classes\Reports\SmsCampaignManager\Outgoing;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;
use App\Classes\Reports\SmsCampaignManager\Outgoing\Transformer\OutgoingTransformer;

/**
 * Class Outgoing
 *
 * @package App\Classes\Reports\SmsCampaignManager
 */
class Outgoing extends Connectors implements Report
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
        $transformer       = new OutgoingTransformer();
        $connect           = $this->connect($reportType);
        $query             = $connect
            ->table('sms_outgoing')
            ->leftJoin('sms_outgoing_status as status', 'status.message_id', '=', 'sms_outgoing.message_id')
            ->where('sms_outgoing.created_at', '>=', $from . ' 00:00:00')
            ->where('sms_outgoing.created_at', '<=', $to . ' 23:59:59')
            ->select(
                'status.sent_at',
                'status.done_at',
                'status.status_id',
                'status.from',
                'sms_outgoing.to',
                'status.sms_count',
                'status.price',
                'sms_outgoing.text'
            )
        ;
        $excelData         = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $result            = json_decode(json_encode($query->paginate($perPage)), true);
        $result['headers'] = __('report.reports.sms.outgoing.headers');
        $excel             = [];
        $result['data']    = $transformer->transform($result['data']);
        $excel['data']     = $transformer->transform($excelData);

        if (!empty($excel['data'])) {

            $keys  = array_keys($excel['data'][0]);
            $count = 0;

            foreach ($keys as $value) {
                $excel['columns'][$result['headers'][$count]] = $value;
                $count++;
            }
        }

        $result['excel'] = $excel;

        return $result;
    }
}
