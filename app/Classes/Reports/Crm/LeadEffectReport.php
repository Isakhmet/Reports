<?php

namespace App\Classes\Reports\Crm;

use Illuminate\Support\Facades\DB;
use PDO;

/**
 * Class LeadEffectReport
 *
 * @package App\Classes\Reports\Crm
 */
class LeadEffectReport
{
    public function query()
    {

        $dbh = new PDO('mysql:host=localhost;dbname=crm', 'prodengi', 'prodengi');

        $query = DB::connection($dbh)
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
                   ->where('crm_request.oracle_version', 3)
                   ->where('crm_request.send_product_date', '>=', '')
                   ->where('crm_request.send_product_date', '<=', '')
                   ->select(
                       'crm_request.send_product_date',
                       'crm_send_product_status.name',
                       'crm_request.name_full',
                       'crm_request.phone_mob',
                       'crm_request.document_inn',
                       'crm_company.name',
                       'crm_product.name',
                       'crm_request.affiliate_id',
                       'crm_request.amount_product',
                       'crm_product_currency.code',
                       'crm_request.address_region_name_arch',
                       'crm_request.id',
                       'crm_request.email'
                   )
                   ->get()
        ;
        dd($query);
    }
}
