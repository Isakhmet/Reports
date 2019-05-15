<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;
use Illuminate\Support\Facades\DB;

class CallTasks extends Connectors implements Report
{
    /**
     * @param $type
     * @param $report_type
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function report($type, $report_type, $from, $to)
    {
        $connect = $this->connect($report_type);

        /*$sql = $connect->select("select
            crm_task.id \"ID задания\",
            crm_task.client_id \"ID клиента\",
            crm_task.request_id \"ID полученной заявки\",
            crm_task.send_product_id \"ID отправленой заявки\",
            crm_task.created_datetime \"Создано\",
            crm_client.name_full \"ФИО\",
            crm_client.name_surname \"Фамилия\",
            crm_client.name_first \"Имя\",
            crm_client.name_patronymic \"Отчество\",
            crm_client.document_inn \"ИИН\",
            crm_client.phone_mob \"Мобильный телефон\",
            crm_region.name \"Регион\",
            crm_user_created_user_id.name \"Кто создал\",
            crm_task_type.name \"Тип\",
            crm_task_status.name \"Статус\",
            crm_user_operator_id.name \"Специалист\",
            crm_task.call_back \"Когда нужно перезвонить\",
            crm_task.closed_datetime \"Дата закрытия\",
            crm_yesno__is_promise.name \"Обещание\",
            crm_task.comments \"Комментарий\",
            crm_product.name \"Продукт\",
            crm_company.name \"Компания\",
            crm_utm_source.name \"Источник\"
            from
            crm_task,
            crm_task_status,
            crm_user crm_user_operator_id,
            crm_user crm_user_created_user_id,
            crm_task_type,
            crm_yesno crm_yesno__is_promise,
            crm_product,
            crm_company,
            crm_utm_source,
            crm_client,
            crm_region
            where
            crm_task.created_datetime >= '$from 00:00:00'
            and crm_task.created_datetime <= '$to 23:59:59'
            and crm_task.task_status_id = crm_task_status.id
            and crm_task.operator_id = crm_user_operator_id.id
            and crm_task.created_user_id = crm_user_created_user_id.id
            and crm_task.task_type_id = crm_task_type.id
            and crm_task.is_promise = crm_yesno__is_promise.id
            and crm_task.product_id = crm_product.id
            and crm_task.company_id = crm_company.id
            and crm_task.utm_source_id = crm_utm_source.id
            and crm_task.client_id = crm_client.id
            and crm_client.address_region_id = crm_region.id
            order by crm_task.id");*/
        $query = $connect
            ->table('crm_task')
            ->leftJoin('crm_task_status', 'crm_task_status.id', '=', 'crm_task.task_status_id')
            ->leftJoin('crm_user as operator', 'operator.id', '=', 'crm_task.operator_id')
            ->leftJoin('crm_task_type','crm_task_type.id','=','crm_task.task_type_id')
            ->leftJoin('crm_yesno','crm_yesno.id','=','crm_task.is_promise')
            ->leftJoin('crm_product','crm_product.id','=','crm_task.product_id')
            ->leftJoin('crm_company','crm_company.id','=','crm_task.company_id')
            ->leftJoin('crm_utm_source','crm_utm_source.id','=','crm_task.utm_source_id')
            ->leftJoin('crm_client','crm_client.id','=','crm_task.client_id')
            ->leftJoin('crm_region','crm_region.id','=','crm_client.address_region_id')

            ->where('crm_task.created_datetime', '>=', $from.' 00:00:00')
            ->where('crm_task.created_datetime', '<=', $to.' 23:59:59')
            ->orderBy('crm_task.id')
            ->select('crm_task.id',
                     'crm_task.client_id',
                     'crm_task.request_id',
                     'crm_task.send_product_id',
                     'crm_task.created_datetime',
                     'crm_client.name_full',
                     'crm_client.name_surname',
                     'crm_client.name_first',
                     'crm_client.name_patronymic',
                     'crm_client.document_inn',
                     'crm_client.phone_mob',
                     'crm_region.name',
                     'operator.name',
                     'crm_task_type.name',
                     'crm_task_status.name',
                     'crm_task.call_back',
                     'crm_task.closed_datetime',
                     'crm_yesno.name',
                     'crm_task.comments',
                     'crm_product.name',
                     'crm_company.name',
                     'crm_utm_source.name'
            )
            ->get()
        ;
        $result  = json_decode(json_encode($query), true);
        dd($result);
        return $result;
    }
}
