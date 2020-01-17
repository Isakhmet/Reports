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
            ->leftJoin('crm_request', 'crm_send_product.request_id', '=', 'crm_request.id')
            ->leftJoin('crm_product', 'crm_product.id', '=', 'crm_send_product.product_id')
            ->leftJoin('crm_company', 'crm_company.id', '=', 'crm_send_product.company_id')
            ->leftJoin('crm_utm_source', 'crm_utm_source.id', '=', 'crm_request.registration_utm_source_id')
            ->leftJoin('crm_user', 'crm_user.id', '=', 'crm_send_product.send_product_user_id')
            ->leftJoin('crm_product_currency', 'crm_product_currency.id', '=', 'crm_send_product.product_currency_id')
            ->leftJoin('crm_region', 'crm_region.id', '=', 'crm_send_product.address_region_id')
            ->leftJoin('crm_audit', 'crm_audit.id', '=', 'crm_send_product.audit_id')
            ->leftJoin('crm_user as audit', 'audit.id', '=', 'crm_send_product.audit_lastchanged_user_id')
            ->whereNotNull('crm_send_product.send_product_date')
            ->where('crm_send_product.send_product_date', '>=', $from . ' 00:00:00')
            ->where('crm_send_product.send_product_date', '<=', $to . ' 23:59:59')
            ->orderBy('crm_send_product.send_product_date')
            ->select(
                'crm_send_product.send_product_date',
                'crm_send_product_status.name as status',
                'crm_user.name as specialist',
                'crm_send_product.name_full',
                'crm_send_product.phone_mob',
                'crm_company.name as company',
                'crm_send_product.document_inn',
                'crm_product.name as product',
                'crm_send_product.amount_product',
                'crm_region.name as region',
                'crm_audit.name as audit_status',
                'audit.name as audit_name',
                'crm_send_product.audit_lastchanged_datetime as audit_date',
                'crm_send_product.email as email',
                'crm_utm_source.name as utm_source',
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

        foreach ($data as $key => $value) {
            if ($value['utm_source'] === null) {
                $data[$key]['utm_source'] = __('report.reports.sendLeads.utmSourceDefault');
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
                    $tempArray                     = $item;
                    $tempArray['ga'] = array_key_exists(
                        $item['request_in'], $gaArray
                    ) ? $gaArray[$item['request_in']]['ga'] : '';
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
            $result['headers'] = __('report.reports.sendLeads.columns');

            foreach ($result['headers'] as $key => $value) {
                $excel['columns'][$value] = $value;
            }
        }

        $result['excel'] = $excel;

        return $result;
    }
}