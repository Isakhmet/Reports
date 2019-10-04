<?php

namespace App\Classes\Reports\IVR\SendRequests;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Classes\Connectors\Connectors;

/**
 * Class SendRequestTransformer
 *
 * @package App\Classes\Reports\IVR\SendRequests
 */
class SendRequestTransformer extends Connectors
{
    /**
     * @param        $items
     * @param int    $perPage
     * @param null   $page
     * @param string $pageName
     * @param array  $options
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page  = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /**
     * @param $ivrData
     * @param $crmData
     * @param $asterData
     *
     * @return array
     */
    public function generate($ivrData, $crmData, $asterData)
    {
        $answerMap   = __('report.reports.ivr.ivr_send.constants.answerMap');
        $methodMap   = __('report.reports.ivr.ivr_send.constants.methodMap');
        $report_data = [];

        if (count($ivrData) > 0) {
            foreach ($ivrData as $ivrd) {
                $temp['id']    = $ivrd['id_call'];
                $temp['fio']   = $ivrd['fio'];
                $temp['iin']   = $ivrd['iin'];
                $temp['phone'] = $ivrd['phone'];
                $temp['phone'] = $ivrd['phone'];
                foreach ($crmData as $item) {
                    if ($ivrd['bank'] === $item['company_id'] &&
                        $ivrd['product'] === $item['product_id']) {
                        $temp['bank']     = $item['company_name'];
                        $temp['product']  = $item['product_name'];
                        $temp['category'] = $item['category_name'];
                    }
                }

                $ignore = true;

                foreach ($asterData as $item) {
                    if ($ivrd['iin'] == $item['IIN']) {
                        $temp['date_call'] = $item['date_call'];
                        $temp['method']    = $methodMap[$ivrd['method']];
                        $temp['answer']    = $answerMap[$item['dtmf']];
                        $ignore            = false;
                    }
                }

                if ($ignore) {
                    $temp['date_call'] = $ivrd['date_call'];
                    $temp['method']    = $methodMap[$ivrd['method']];
                    $temp['answer']    = ($ivrd['rejection'] === '1') ? $answerMap[2] : $answerMap[9];
                }

                $report_data[] = $temp;
            }
        } else {
            foreach ($ivrData as $row) {
                $temp['id']        = $row['id_call'];
                $temp['fio']       = $row['fio'];
                $temp['iin']       = $row['iin'];
                $temp['phone']     = $row['phone'];
                $temp['bank']      = $row['bank'];
                $temp['product']   = $row['product'];
                $temp['date_call'] = $row['date_call'];
                $temp['method']    = $methodMap[$row['method']];
                $temp['answer']    = ($row['rejection'] === '1') ? $answerMap[2] : $answerMap[9];
                $report_data[]     = $temp;
            }
        }

        return $report_data;
    }

    /**
     * @param $type
     * @param $from
     * @param $to
     *
     * @return mixed
     */
    public function QueryGeneration($type, $from, $to)
    {
        $banks_id    = __('report.reports.ivr.ivr_send.constants.banksID');
        $products_id = __('report.reports.ivr.ivr_send.constants.productsID');
        if ($type === 'crm') {
            $connectToCRM = $this->connect('crm');

            $queryCRM = $connectToCRM
                ->table('crm_product as cp')
                ->leftJoin('crm_company as cc', 'cp.company_id', '=', 'cc.id')
                ->leftJoin('crm_product_category as cpc', 'cp.product_category_id', '=', 'cpc.id')
                ->where('cp.is_active', '=', '1')
                ->whereIn('cp.company_id', $banks_id)
                ->whereIn('cp.id', $products_id)
                ->orderBy('cp.company_id')
                ->select(
                    'cp.company_id as company_id',
                    'cc.name as company_name',
                    'cp.id as product_id',
                    'cp.name as product_name',
                    'cp.product_category_id as category_id',
                    'cpc.name as category_name'
                )
            ;
            $crmData  = json_decode(
                json_encode(
                    $queryCRM->get()
                             ->toArray(), true
                ), true
            );

            return $crmData;
        } elseif ($type === 'aster') {
            $connectToASTER = $this->connect('aster');

            $queryASTER = $connectToASTER
                ->table('prodengi_ivr_calls as pic')
                ->whereBetween('pic.date_call', [$from, $to])
                ->select(
                    'pic.id',
                    'pic.date_call',
                    'pic.IIN',
                    'pic.phone',
                    'pic.dtmf'
                )
            ;

            $asterData = json_decode(
                json_encode(
                    $queryASTER->get()
                               ->toArray(), true
                ), true
            );

            return $asterData;
        } elseif ($type === 'ivr') {
            $connectToIVR = $this->connect('ivr');

            $queryIVR = $connectToIVR
                ->table('calls as c')
                ->leftJoin('status as s', 'c.status_id', '=', 's.id')
                ->whereIn('c.bank', $banks_id)
                ->whereIn('c.product', $products_id)
                ->whereBetween('c.date_call', [$from, $to])
                ->orderBy('c.id')
                ->select(
                    'c.id as id_call',
                    'c.date_create as date_create',
                    'c.fio as fio',
                    'c.phone as phone',
                    'c.iin as iin',
                    'c.amount_calls as calls_count',
                    'c.bank as bank',
                    'c.product as product',
                    'c.method as method',
                    'c.city as city',
                    'c.date_call as date_call',
                    's.name as status',
                    'c.rejection'
                )
            ;
            $ivrData  = json_decode(
                json_encode(
                    $queryIVR->get()
                             ->toArray(), true
                ), true
            );

            return $ivrData;
        }
    }

}
