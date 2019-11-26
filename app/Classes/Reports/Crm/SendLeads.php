<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Request;

class SendLeads extends Connectors implements Report
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
            ->table('crm_send_product')
            ->leftJoin(
                'crm_send_product_status', 'crm_send_product_status.id', '=', 'crm_send_product.send_product_status_id'
            )
            ->leftJoin('crm_client', 'crm_client.id', '=', 'crm_send_product.client_id')
            ->leftJoin('crm_product', 'crm_product.id', '=', 'crm_send_product.product_id')
            ->leftJoin('crm_company', 'crm_company.id', '=', 'crm_send_product.company_id')
            ->leftJoin('crm_utm_source', 'crm_utm_source.id', '=', 'crm_client.registration_utm_source_id')
            ->leftJoin('crm_user', 'crm_user.id', '=', 'crm_send_product.send_product_user_id')
            ->leftJoin('crm_product_currency', 'crm_product_currency.id', '=', 'crm_send_product.product_currency_id')
            ->leftJoin('crm_region', 'crm_region.id', '=', 'crm_send_product.address_region_id')
            ->leftJoin('crm_audit', 'crm_audit.id', '=', 'crm_send_product.audit_id')
            ->leftJoin('crm_user as audit', 'audit.id', '=', 'crm_send_product.audit_lastchanged_user_id')
            ->leftJoin('crm_request', 'crm_send_product.request_id', '=', 'crm_request.id')
            ->whereNotNull('crm_send_product.send_product_date')
            ->where('crm_send_product.send_product_date', '>=', $from . ' 00:00:00')
            ->where('crm_send_product.send_product_date', '<=', $to . ' 23:59:59')
            ->orderBy('crm_send_product.send_product_date')
            ->select(
                'crm_send_product.send_product_date as Дата отправки',
                'crm_send_product_status.name as Статус отправки',
                'crm_user.name as Специалист',
                'crm_send_product.name_full as ФИО',
                'crm_send_product.phone_mob as Мобильный',
                'crm_company.name as Компания',
                'crm_send_product.document_inn as ИИН',
                'crm_product.name as Продукт',
                'crm_send_product.amount_product as Сумма',
                'crm_region.name as Регион',
                'crm_audit.name as Аудит: Статус',
                'audit.name as Аудит: ФИО',
                'crm_send_product.audit_lastchanged_datetime as Аудит: Дата изменения',
                'crm_send_product.email as Email',
                'crm_utm_source.name as Источник создания клиента',
                'crm_request.request_in_id as request_in'
            )
        ;

        $data = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );

        $requestIds = [];

        foreach ($data as $value) {
            if ($value['request_in'] !== null) {
                $requestIds[] = $value['request_in'];
            }
        }

        $gaArray = $connect
            ->table('google_client_ids')
            ->whereIn('request_in_id', $requestIds)
            ->select('request_in_id', 'ga')
            ->get()
            ->keyBy('request_in_id')
            ->toArray()
        ;

        $gaArray = json_decode(json_encode($gaArray), true);

        if (count($gaArray) > 0) {
            $data = array_map(
                function ($item) use ($gaArray) {
                    $tempArray = $item;
                    $tempArray['Google Client Id'] = array_key_exists($item['request_in'], $gaArray) ? $gaArray[$item['request_in']]['ga'] : '';
                    unset($tempArray['request_in']);
                    return $tempArray;
                }, $data
            );
        }

        $excel['data'] = $data;

        $currentPage      = Paginator::resolveCurrentPage();
        $col              = collect($data);
        $currentPageItems = $col->slice(($currentPage - 1) * $perPage, $perPage)
                                ->all()
        ;
        $result           = new Paginator($currentPageItems, count($col), $perPage);
        $result->setPath(Request::url());
        $result = json_decode(json_encode($result), true);

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
