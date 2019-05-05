<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use Illuminate\Support\Facades\DB;
use PDO;

/**
 * Class LeadEffectReport
 *
 * @package App\Classes\Reports\Crm
 */
class LeadEffectReport extends Connectors
{
    public function report($type, $report_type, $from = null, $to = null){

        if($type == 'db'){
            $this->connect($report_type);
        }else{
            $this->getHttp($report_type);
        }

        $sql = 'select
                cin.send_product_date,
                stat.name,
                cin.name_full,
                cin.phone_mob,
                cin.document_inn,
                com.name,
                prd.name,
                cin.affiliate_id,
                cin.amount_product,
                prdc.code,
                cin.address_region_name_arch,
                cin.id,
                cin.email
                from crm_request_in cin
                left join crm_request cr on cr.request_in_id = cin.id
                left join crm_send_product spr on spr.request_id = cr.id
                left join crm_send_product_status stat on stat.id = spr.send_product_status_id
                left join crm_company com on com.id = cin.company_id
                left join crm_product prd on prd.id = cin.product_id
                left join crm_product_currency prdc on prdc.id = cin.product_currency_id
                WHERE cin.send_product_date >= \''.$from.' 00:00:00 \'
                and cin.send_product_date <= \''.$to.' 23:59:59 \'';

        $result = $this->query($sql);
    }
}
