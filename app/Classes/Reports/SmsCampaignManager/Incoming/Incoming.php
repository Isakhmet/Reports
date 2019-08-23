<?php

namespace App\Classes\Reports\SmsCampaignManager\Incoming;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;
use App\Classes\Reports\SmsCampaignManager\Incoming\Transformer\IncomingTransformer;

/**
 * Class Transformer
 *
 * @package App\Classes\Reports\SmsCampaignManager
 */
class Incoming extends Connectors implements Report
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
        $transformer       = new IncomingTransformer();
        $connect           = $this->connect($reportType);
        $query             = $connect
            ->table('sms_incoming')
            ->where('sms_incoming.created_at', '>=', $from . ' 00:00:00')
            ->where('sms_incoming.created_at', '<=', $to . ' 23:59:59')
            ->select(
                'sms_incoming.created_at',
                'sms_incoming.received_at',
                'sms_incoming.from',
                'sms_incoming.to',
                'sms_incoming.sms_count',
                'sms_incoming.price',
                'sms_incoming.text'
            )
        ;
        $excelData         = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $result            = json_decode(json_encode($query->paginate($perPage)), true);
        $result['headers'] = __('report.reports.sms.incoming.headers');
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
