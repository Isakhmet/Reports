<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;

class AlfaBankLanding extends Connectors implements Report
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
        $query   = $connect
            ->table('alpha_bank_leads')
            ->orderBy('created_at')
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->select(
                'name as "Имя"',
                'iin as "ИИН"',
                'phone as "Телефон"',
                'city as "Город"',
                'status as "Статус"',
                'description as "Описание"',
                'created_at as "Дата подачи"',
                'ga as "Google Client Id"'
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
