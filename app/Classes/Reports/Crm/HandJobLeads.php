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

        $query = $connect
            ->table('crm_request_in')
            ->leftJoin('crm_company', 'crm_company.id', '=', 'crm_request_in.company_id')
            ->leftJoin('crm_product', 'crm_product.id', '=', 'crm_request_in.product_id')
            ->leftJoin('crm_utm_source', 'crm_utm_source.id', '=', 'crm_request_in.registration_utm_source_id')
            ->where('registration_utm_source_id', 36)
            ->where('crm_request_in.registration_date', '>=', $from . ' 00:00:00')
            ->where('crm_request_in.registration_date', '<=', $to . ' 23:59:59')
            ->orderBy('crm_request_in.registration_date')
            ->select(
                'crm_request_in.registration_date as created_at',
                'crm_request_in.name_full as fio',
                'crm_request_in.phone_mob as mobile_phone',
                'crm_company.name as company_name',
                'crm_request_in.document_inn as iin',
                'crm_product.name as product',
                'crm_request_in.amount_product as credit_amount',
                'crm_request_in.address_region_name_arch as delivery_town',
                'crm_utm_source.name as utm_source_name'
            )
        ;

        $requestLeads = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );

        $queryForSberLeads = $connect
            ->table('sber_leads')
            ->where('sber_leads.created_at', '>=', $from . ' 00:00:00')
            ->where('sber_leads.created_at', '<=', $to . ' 23:59:59')
            ->orderBy('sber_leads.created_at')
            ->select(
                'sber_leads.created_at',
                'sber_leads.firstname',
                'sber_leads.lastname',
                'sber_leads.middlename',
                'sber_leads.mobile_phone',
                'sber_leads.iin',
                'sber_leads.product',
                'sber_leads.credit_amount',
                'sber_leads.delivery_town'
            )
        ;
        $sberLeads         = json_decode(
            json_encode(
                $queryForSberLeads->get()
                                  ->toArray()
            ), true
        );

        foreach ($sberLeads as $lead) {
            $temp['created_at'] = $lead['created_at'];
            if ($lead['firstname'] === $lead['lastname'] && $lead['firstname'] === $lead['middlename'] && $lead['lastname'] === $lead['middlename']) {
                $temp['fio'] = $lead['firstname'];
            } else {
                $temp['fio'] = $lead['firstname'] . ' ' . $lead['lastname'] . ' ' . $lead['middlename'];
            }
            $temp['mobile_phone']    = $lead['mobile_phone'];
            $temp['company_name']    = 'Сбербанк';
            $temp['iin']             = $lead['iin'];
            $temp['product']         = $lead['product'];
            $temp['credit_amount']   = $lead['credit_amount'];
            $temp['delivery_town']   = $lead['delivery_town'];
            $temp['utm_source_name'] = 'ручная отправка';


            $reportData[] = $temp;
        }

        $data = array_merge_recursive($requestLeads, $reportData);

        $excel['data']     = json_decode(
            json_encode(
                $data
            ), true
        );
        $columns           = __('report.reports.handJobLeads.columns');
        $result            = json_decode(json_encode($query->paginate($perPage)), true);
        $result['headers'] = array_values($columns);
        $excel['columns']  = $columns;
        $result['excel']   = $excel;

        return $result;
    }
}
