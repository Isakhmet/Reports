<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;

class SMS extends Connectors implements Report
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
        $connect           = $this->connect($reportType);
        $query             = $connect
            ->table('crm_sms as sms')
            ->leftJoin('crm_client as client', 'client.id', '=', 'sms.client_id')
            ->leftJoin('crm_sms_status as status', 'status.id', '=', 'sms.sms_status_id')
            ->leftJoin('crm_sms_cabinet as cabinet', 'cabinet.id', '=', 'sms.sms_cabinet_id')
            ->leftJoin('crm_sms_template as template', 'template.id', '=', 'sms.sms_template_id')
            ->where('sms.created_datetime', '>=', $from . ' 00:00:00')
            ->where('sms.created_datetime', '<=', $to . ' 23:59:59')
            ->orderBy('sms.created_datetime')
            ->select(
                'client.name_full as ФИО',
                'sms.phone_number_view as Телефон',
                'sms.date_get as Дата отправки',
                'sms.sms_template_id as ID',
                'sms.text_sms_view as Текст сообщения',
                'cabinet.name as Канал',
                'status.name as Статус отправки'
            )
        ;
        $excel['data']     = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $result            = json_decode(json_encode($query->paginate($perPage)), true);
        $result['headers'] = [];

        if (!empty($result['data'])) {
            foreach ($result['data'][0] as $key => $value) {
                $excel['columns'][$key] = $key;
            }
            $result['headers'] = array_keys($result['data'][0]);
        }

        $result['excel'] = $excel;

        return $result;
    }
}