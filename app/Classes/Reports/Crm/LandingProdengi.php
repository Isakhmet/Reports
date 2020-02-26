<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Request;

class LandingProdengi extends Connectors implements Report
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
            ->orderBy('created_datetime')
            ->where('registration_utm_source_id', '=', '37')
            ->whereBetween('created_datetime', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->select(
                'id',
                'document_inn',
                'name_full',
                'phone_mob',
                'registration_date',
                'address_region_name_arch',
                'param_create_task_type'
            )
        ;

        $data = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        
        $doubling = [];
        $newUsers = [];
        foreach ($data as $user) {
            if (
                !in_array($user['document_inn'], array_column($doubling, 'iin')) ||
                !in_array($user['registration_date'], array_column($doubling, 'date'))
            ) {
                $temp['iin']                = $user['document_inn'];
                $temp['date']               = $user['registration_date'];
                $tempUser['ИИН']            = $user['document_inn'];
                $tempUser['ФИО']            = $user['name_full'];
                $tempUser['Телефон']        = $user['phone_mob'];
                $tempUser['Дата']           = $user['registration_date'];
                $tempUser['Город']          = $user['address_region_name_arch'];
                $tempUser['Прошел скоринг'] = (intval($user['param_create_task_type']) === self::TASK_TYPE) ?
                    'Да' : 'Нет';
                $doubling[]                 = $temp;
                $newUsers[]                 = $tempUser;
            }
        }

        $excel['data'] = $newUsers;

        $currentPage      = Paginator::resolveCurrentPage();
        $col              = collect($data);
        $currentPageItems = $col->slice(($currentPage - 1) * $perPage, $perPage)
                                ->all()
        ;
        $result           = new Paginator($currentPageItems, count($col), $perPage);
        $result->setPath(Request::url());
        $result = json_decode(json_encode($result), true);

        $result['headers'] = __('report.reports.LandingProdengi.headers');

        if (!empty($result['data'])) {
            foreach ($result['headers'] as $key => $value) {
                $excel['columns'][$value] = $value;
            }
        }

        $result['excel'] = $excel;

        return $result;
    }
}
