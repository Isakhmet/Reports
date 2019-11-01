<?php

namespace App\Classes\Reports\Crm;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class EuBankRequests extends Connectors implements Report
{

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page  = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function getSum($data, $month, $date)
    {
        $sum_pay     = 0;
        $month_start = date("Y-m-01 00:00:00", strtotime("-" . $month . " month", strtotime($date)));
        $month_end   = date("Y-m-t 23:59:59", strtotime("-" . $month . " month", strtotime($date)));
        ;
        foreach ($data as $val) {
            if ($month_start < $val->real_date && $val->real_date < $month_end) {
                $sum_pay += intval($val->pay_sum);
            }
        }

        return $sum_pay;
    }

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
        $connect      = $this->connect($reportType);
        $query        = $connect
            ->table('crm_request_in')
            ->orderBy('created_datetime')
            ->where('registration_utm_source_id', '=', '35')
            ->whereBetween('created_datetime', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->select(
                'document_inn',
                'name_full',
                'phone_mob',
                'registration_date',
                'company_id',
                'address_region_name_arch'
            )
        ;

        $users        = $query->get()
                              ->toArray()
        ;
        $doubling     = [];
        $new_users    = [];
        $eubankID = 8;
        $num_month    = range(6, 1);

        $date         = date('Y-m-01 00:00:00');
        $half_year    = date("Y-m-d H:i:s", strtotime("-6 month", strtotime($date)));

        foreach ($users as $u) {
            if (!in_array($u->document_inn, array_column($doubling, 'iin')) || !in_array(
                    $u->registration_date, array_column($doubling, 'date')
                )) {
                $temp['iin']       = $u->document_inn;
                $temp['date']      = $u->registration_date;
                $tempUser['iin']   = $u->document_inn;
                $tempUser['fio']   = $u->name_full;
                $tempUser['phone'] = $u->phone_mob;
                $tempUser['date']  = $u->registration_date;
                $tempUser['city']  = $u->address_region_name_arch;
                $tempUser['score'] = (intval($u->company_id) === $eubankID) ? 'Да' : 'Нет';
                $doubling[]        = $temp;
                $new_users[]       = $tempUser;
            }
        }

        $string_sic       = array_column($doubling, 'iin');
        $connectServerNew = $this->connect('server_new');
        $queryServerNew   = $connectServerNew
            ->table('main')
            ->where('real_date', '>', $half_year)
            ->whereIn('sic', $string_sic)
            ->select(
                'sic',
                'pay_sum',
                'real_date'
            )
        ;
        $resultsn         = $queryServerNew->get()
                                           ->toArray()
        ;
        $clusterIins      = [];
        $headers          = __('report.reports.EuBankRequests.headers');


        foreach ($resultsn as $r) {
            $clusterIins[] = $r->sic;
        }

        foreach ($num_month as $key) {
            $temp_headers = date("Y-m", strtotime("-" . $key . " month", strtotime($date)));
            array_push($headers, $temp_headers);
        }
        $data = [];
        foreach ($new_users as $user) {
            $user_pay       = [];
            $seekIin['iin'] = $user['iin'];
            $findedPays     = array_intersect($clusterIins, $seekIin);
            $findedPays     = array_keys($findedPays);

            foreach ($findedPays as $r) {
                $user_pay[] = $resultsn[$r];
            }
            foreach ($num_month as $key) {
                $user[$key] = $this->getSum($user_pay, $key, $date);
            }
            $data[] = $user;
        }
        $excel['data'] = json_decode(
            json_encode(
                $data
            ), true
        );

        $result            = json_decode(json_encode($this->paginate($data, 15)), true);
        $result['headers'] = $headers;
        $result['excel']   = $excel;

        return $result;
    }


}
