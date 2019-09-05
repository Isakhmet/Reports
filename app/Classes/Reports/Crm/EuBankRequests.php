<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;

class EuBankRequests extends Connectors implements Report
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
            ->table('crm_request_in')
            ->orderBy('send_product_date')
            ->where('send_product_date', '>=', $from . ' 00:00:00')
            ->where('send_product_date', '<=', $to . ' 23:59:59')
            ->where('company_id', '=', '8')
            ->where('registration_utm_source_id', '=', '35')
            ->select(
                'document_inn as "Документ ИИН"',
                'name_full as "ФИО"',
                'phone_mob as "Телефон"',
                'registration_date as "Дата"',
                'address_region_name_arch as "Город"'
            )
        ;
        $excel['data']   = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $result  = json_decode(json_encode($query->paginate($perPage)), true);
        $result['headers'] = [];

        if(!empty($result['data'])){
            foreach ($result['data'][0] as $key => $value) {
                $excel['columns'][$key] = $key;
            }
            $result['headers'] = array_keys($result['data'][0]);
        }

        $result['excel']   = $excel;

        return $result;
    }
}
