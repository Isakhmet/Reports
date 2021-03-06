<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;

class CallTasks extends Connectors implements Report
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
            ->table('crm_task')
            ->leftJoin('crm_task_status', 'crm_task_status.id', '=', 'crm_task.task_status_id')
            ->leftJoin('crm_user as operator', 'operator.id', '=', 'crm_task.operator_id')
            ->leftJoin('crm_user as create', 'create.id', '=', 'crm_task.created_user_id')
            ->leftJoin('crm_task_type', 'crm_task_type.id', '=', 'crm_task.task_type_id')
            ->leftJoin('crm_yesno', 'crm_yesno.id', '=', 'crm_task.is_promise')
            ->leftJoin('crm_product', 'crm_product.id', '=', 'crm_task.product_id')
            ->leftJoin('crm_company', 'crm_company.id', '=', 'crm_task.company_id')
            ->leftJoin('crm_utm_source', 'crm_utm_source.id', '=', 'crm_task.utm_source_id')
            ->leftJoin('crm_client', 'crm_client.id', '=', 'crm_task.client_id')
            ->leftJoin('crm_region', 'crm_region.id', '=', 'crm_client.address_region_id')
            ->where('crm_task.created_datetime', '>=', $from . ' 00:00:00')
            ->where('crm_task.created_datetime', '<=', $to . ' 23:59:59')
            ->orderBy('crm_task.id', 'asc')
            ->select(
                'crm_task.id',
                'crm_task.client_id',
                'crm_task.request_id',
                'crm_task.created_datetime',
                'crm_client.name_full',
                'crm_client.document_inn',
                'crm_client.phone_mob',
                'crm_region.name as region',
                'operator.name as operator',
                'create.name as creator',
                'crm_task_type.name as type',
                'crm_task_status.name as status',
                'crm_task.call_back',
                'crm_task.closed_datetime',
                'crm_yesno.name as is_promise',
                'crm_task.comments',
                'crm_product.name as product',
                'crm_company.name as company',
                'crm_utm_source.name as utm_source'
            )
        ;
        $excel['data']   = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $result  = json_decode(json_encode($query->paginate($perPage)), true);
        $result['headers'] = __('report.reports.callTask.columns');

        if(!empty($result['data'])){
            foreach ($result['headers'] as $key => $value) {
                $excel['columns'][$value] = $value;
            }
        }

        $result['excel']   = $excel;

        return $result;
    }
}
