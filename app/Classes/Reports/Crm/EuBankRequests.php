<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Request;

class EuBankRequests extends Connectors implements Report
{
    const TASK_TYPE = 31;
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
            ->leftJoin('google_client_ids', 'crm_request_in.id', '=', 'google_client_ids.request_in_id')
            ->orderBy('created_datetime')
            ->where('registration_utm_source_id', '=', '35')
            ->whereBetween('created_datetime', [$from . ' 06:00:00', $to . ' 07:59:59'])
            ->select(
                'crm_request_in.id',
                'crm_request_in.document_inn',
                'crm_request_in.name_full',
                'crm_request_in.phone_mob',
                'crm_request_in.registration_date',
                'crm_request_in.address_region_name_arch',
                'crm_request_in.param_create_task_type',
                'google_client_ids.ga'
            )
        ;

        $data = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );

        $doubling  = [];
        $new_users = [];
        foreach ($data as $user) {
            if (
                !in_array($user['document_inn'], array_column($doubling, 'iin')) ||
                !in_array($user['registration_date'], array_column($doubling, 'date'))
            ) {
                $temp['iin']                  = $user['document_inn'];
                $temp['date']                 = $user['registration_date'];
                $tempUser['ИИН']              = $user['document_inn'];
                $tempUser['ФИО']              = $user['name_full'];
                $tempUser['Телефон']          = $user['phone_mob'];
                $tempUser['Дата']             = $user['registration_date'];
                $tempUser['Город']            = $user['address_region_name_arch'];
                $tempUser['ga']               = $user['ga'];
                $tempUser['Прошел скоринг']   = (intval($user['param_create_task_type']) === self::TASK_TYPE) ?
                    'Да' : 'Нет';
                $doubling[]                   = $temp;
                $new_users[]                  = $tempUser;
            }
        }

        $excel['data'] = $new_users;

        $currentPage      = Paginator::resolveCurrentPage();
        $col              = collect($data);
        $currentPageItems = $col->slice(($currentPage - 1) * $perPage, $perPage)
                                ->all()
        ;
        $result           = new Paginator($currentPageItems, count($col), $perPage);
        $result->setPath(Request::url());
        $result = json_decode(json_encode($result), true);

        $result['headers'] = __('report.reports.EuBankRequests.headers');

        if (!empty($result['data'])) {
            foreach ($result['headers'] as $key => $value) {
                $excel['columns'][$value] = $value;
            }
        }

        $result['excel'] = $excel;

        return $result;
    }
}
