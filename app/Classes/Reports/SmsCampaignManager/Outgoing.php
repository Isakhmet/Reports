<?php


namespace App\Classes\Reports\SmsCampaignManager;


use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;

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
        $connect = $this->connect($reportType);
        $query   = $connect
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
            ->paginate($perPage)
        ;

        $result            = json_decode(json_encode($query), true);
        $result['headers'] = __('report.reports.sms.headers');

        $array = [];
        foreach ($result['data'] as $key => $data){
            $array[$key]['sent_at'] = $data['sent_at'];
            $array[$key]['done_at'] = strtotime($data['done_at']) - strtotime($data['sent_at']);
            $array[$key]['status_id'] = $data['status_id'];
            $array[$key]['author'] = '';
            $array[$key]['from'] = $data['from'];
            $array[$key]['to'] = $data['to'];
            $array[$key]['sms_count'] = $data['sms_count'];
            $array[$key]['price'] = $data['price'];
            $array[$key]['sum'] = $data['sms_count'] * $data['price'];
            $array[$key]['text'] = $data['text'];
        }

        $result['data'] = $array;

        return $result;
    }
}
