<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;

class HandJobLeads extends Connectors implements Report
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
            ->leftJoin('crm_company', 'crm_company.id', '=', 'crm_request_in.company_id')
            ->leftJoin('crm_product', 'crm_product.id', '=', 'crm_request_in.product_id')
            ->leftJoin('crm_utm_source', 'crm_utm_source.id', '=', 'crm_request_in.registration_utm_source_id')
            ->where('registration_utm_source_id', 36)
            ->where('crm_request_in.registration_date', '>=', $from . ' 00:00:00')
            ->where('crm_request_in.registration_date', '<=', $to . ' 23:59:59')
            ->orderBy('crm_request_in.registration_date')
            ->select(
                'crm_request_in.id as ID заявки',
                'crm_request_in.registration_date as Дата отправки',
                'crm_request_in.name_full as ФИО',
                'crm_request_in.phone_mob as Мобильный',
                'crm_company.name as Компания',
                'crm_request_in.document_inn as ИИН',
                'crm_product.name as Продукт',
                'crm_request_in.amount_product as Сумма',
                'crm_request_in.address_region_name_arch as Регион',
                'crm_utm_source.name as Источник создания клиента'
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
