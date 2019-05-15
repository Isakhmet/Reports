<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;

/**
 * Class LeadEffectReport
 *
 * @package App\Classes\Reports\Crm
 */
class LeadEffectReport extends Connectors implements Report
{
    /**
     * @param      $type
     * @param      $report_type
     * @param null $from
     * @param null $to
     *
     * @return mixed
     */
    public function report($type, $report_type, $from = null, $to = null)
    {
        $connect = $this->connect($report_type);
        $query   = $connect
            ->table('crm_request_in')
            ->leftJoin('crm_request', 'crm_request.request_in_id', '=', 'crm_request_in.id')
            ->leftJoin('crm_send_product', 'crm_send_product.request_id', '=', 'crm_request.id')
            ->leftJoin(
                'crm_send_product_status', 'crm_send_product_status.id', '=',
                'crm_send_product.send_product_status_id'
            )
            ->leftJoin('crm_company', 'crm_company.id', '=', 'crm_request_in.company_id')
            ->leftJoin('crm_product', 'crm_product.id', '=', 'crm_request_in.product_id')
            ->leftJoin(
                'crm_product_currency', 'crm_product_currency.id', '=', 'crm_request_in.product_currency_id'
            )
            ->where('crm_request_in.oracle_version', '=', 3)
            ->where('crm_request_in.send_product_date', '>=', $from.' 00:00:00')
            ->where('crm_request_in.send_product_date', '<=', $to.' 23:59:59')
            ->select(
                'crm_request_in.send_product_date',
                'crm_send_product_status.name',
                'crm_request_in.name_full',
                'crm_request_in.phone_mob',
                'crm_request_in.document_inn',
                'crm_company.name',
                'crm_product.name',
                'crm_request_in.affiliate_id',
                'crm_request_in.amount_product',
                'crm_product_currency.code',
                'crm_request_in.address_region_name_arch',
                'crm_request_in.id',
                'crm_request_in.email'
            )
            ->paginate(5)
        ;
        $result  = json_decode(json_encode($query), true);

        return $result;
    }
}
