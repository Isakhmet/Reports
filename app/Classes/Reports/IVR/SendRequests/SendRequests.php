<?php

namespace App\Classes\Reports\IVR\SendRequests;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Report;

class SendRequests extends Connectors implements Report
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
        $crm          = 'crm';
        $aster        = 'aster';
        $banks_id     = ['14', '21', '24', '25', '26', '41'];
        $products_id  = ['49', '186', '340', '435', '491', '508', '551', '554', '555', '1540', '1550'];
        $connectToCRM = $this->connect($crm);
        $queryCRM     = $connectToCRM
            ->table('crm_product')
            ->leftJoin('crm_company', 'crm_product.company_id', '=', 'crm_company.id')
            ->where('crm_product.is_active', '=', '1')
            ->whereIn('crm_product.company_id', $banks_id)
            ->whereIn('crm_product.id', $products_id)
            ->orderBy('crm_product.company_id')
            ->select(
                'crm_company.name as bank',
                'crm_product.name as product'
            )
        ;
        $crmData      = json_decode(
            json_encode(
                $queryCRM->get()
                         ->toArray(), true
            ), true
        );
        //dd($crmData);

        $connectToIVR = $this->connect($reportType);
        $queryIVR     = $connectToIVR
            ->table('calls')
            ->leftJoin('status', 'calls.status_id', '=', 'status.id')
            ->whereBetween('calls.date_call', [$from . ' 15:08:11', $to . ' 15:08:15'])
            ->where('calls.method', '=', 1)
            /**->where( 'bank', '=', function ($bank) {
             * $connectToCRM = $this->connect('crm');
             * $connectToCRM
             * ->table('crm_company')
             * ->where('id', '=', $bank)
             * ->select('id', 'name');
             * })*/
            ->orderBy('date_call')
            ->select(
                'calls.id as id',
                'calls.fio as fio',
                'calls.iin as iin',
                'calls.phone as phone',
                'calls.bank as bank',
                'calls.product as product',
                'calls.date_call as date_call',
                'calls.method as method',
                'status.name as status'
            )
        ;
        $ivrData      = json_decode(
            json_encode(
                $queryIVR->get()
                         ->toArray(), true
            ), true
        );
        //dd($ivrData);

        $connectToASTER = $this->connect($aster);
        $queryASTER     = $connectToASTER
            ->table('prodengi_ivr_calls')
            ->whereBetween('date_call', [$from . ' 15:08:11', $to . ' 15:08:15'])
            ->select(
                'dtmf as answer',
                'phone as phone',
                'date_call as date_call',
                'iin as iin'
            )
        ;
        $asterData      = json_decode(
            json_encode(
                $queryASTER->get()
                           ->toArray(), true
            ), true
        );
        //dd($asterData);

        $data = array_replace_recursive($ivrData, $crmData, $asterData);
        dd($data);

        $result = $data;

        return $result;
    }
}