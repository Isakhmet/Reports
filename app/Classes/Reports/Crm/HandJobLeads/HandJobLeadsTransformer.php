<?php

namespace App\Classes\Reports\Crm\HandJobLeads;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class HandJobLeadsTransformer
{
    /**
     * Колонка, по которой будет вестись сортировка массива
     *
     * @var string
     */
    const columnForSorting = 'updated_at';

    /**
     * Источник прихода заявки
     *
     * @var string
     */
    const utmSourceName = 'ручная отправка';

    /**
     * Название компании Сбербанк
     *
     * @var string
     */
    const companyNameSberbank = 'Сбербанк';

    /**
     * Название компании ХКБ
     *
     * @var string
     */
    const companyNameHCB = 'Банк Хоум Кредит';

    /**
     * Название компании БЦК
     *
     * @var string
     */
    const companyNameBCC = 'Банк Центр Кредит';

    /**
     * Сумма кредита для заявок с БЦК
     *
     * @var string
     */
    const creditAmountBCCDefault = '600000';

    /**
     * Название компании БЦК
     *
     * @var string
     */
    const companyNameAlfa = 'Альфа Банк';

    /**
     * Трансформирование лидов со Сбербанка
     *
     * @param $leads
     *
     * @return array
     */
    public function transformSberLeads($leads)
    {
        $reportDataSber = [];

        foreach ($leads as $lead) {
            $temp['created_at'] = $lead['created_at'];
            $temp['updated_at'] = $lead['updated_at'];
            if ($lead['firstname'] === $lead['lastname'] && $lead['firstname'] === $lead['middlename'] && $lead['lastname'] === $lead['middlename']) {
                $temp['fio'] = $lead['firstname'];
            } else {
                $temp['fio'] = $lead['firstname'] . ' ' . $lead['lastname'] . ' ' . $lead['middlename'];
            }
            $temp['mobile_phone']    = $lead['mobile_phone'];
            $temp['company_name']    = self::companyNameSberbank;
            $temp['iin']             = $lead['iin'];
            $temp['product']         = $lead['product'];
            $temp['credit_amount']   = $lead['credit_amount'];
            $temp['delivery_town']   = $lead['delivery_town'];
            $temp['utm_source_name'] = self::utmSourceName;

            $reportDataSber[] = $temp;
        }

        return $reportDataSber;
    }

    /**
     * Трансформирование лидов с БЦК
     *
     * @param $leads
     *
     * @return array
     */
    public function transformBccLeads($leads)
    {
        $reportDataBcc = [];

        foreach ($leads as $lead) {
            $temp['created_at']      = $lead['created_at'];
            $temp['updated_at']      = $lead['updated_at'];
            $temp['fio']             = $lead['name'];
            $temp['mobile_phone']    = $lead['phone'];
            $temp['company_name']    = self::companyNameBCC;
            $temp['iin']             = $lead['iin'];
            $temp['product']         = $lead['productName'];
            $temp['credit_amount']   = self::creditAmountBCCDefault;
            $temp['delivery_town']   = '';
            $temp['utm_source_name'] = self::utmSourceName;

            $reportDataBcc[] = $temp;
        }

        return $reportDataBcc;
    }

    /**
     * Трансформирование лидов с ХКБ
     *
     * @param $leads
     *
     * @return array
     */
    public function transformHcbLeads($leads)
    {
        $reportDataHcb = [];

        foreach ($leads as $lead) {
            $temp['created_at'] = $lead['created_at'];
            $temp['updated_at'] = $lead['updated_at'];
            if ($lead['firstname'] === $lead['lastname'] && $lead['firstname'] === $lead['middlename'] && $lead['lastname'] === $lead['middlename']) {
                $temp['fio'] = $lead['firstname'];
            } else {
                $temp['fio'] = $lead['firstname'] . ' ' . $lead['lastname'] . ' ' . $lead['middlename'];
            }
            $temp['mobile_phone']    = $lead['mobile_phone'];
            $temp['company_name']    = self::companyNameHCB;
            $temp['iin']             = $lead['iin'];
            $temp['product']         = $lead['product'];
            $temp['credit_amount']   = '';
            $temp['delivery_town']   = $lead['city'];
            $temp['utm_source_name'] = self::utmSourceName;

            $reportDataHcb[] = $temp;
        }

        return $reportDataHcb;
    }

    /**
     * Трансформирование лидов с Альфы
     *
     * @param $leads
     *
     * @return array
     */
    public function transformAlfaLeads($leads)
    {
        $reportDataAlfa = [];

        foreach ($leads as $lead) {
            $temp['created_at']      = $lead['created_at'];
            $temp['updated_at']      = $lead['updated_at'];
            $temp['fio']             = $lead['name'];
            $temp['mobile_phone']    = $lead['phone'];
            $temp['company_name']    = self::companyNameAlfa;
            $temp['iin']             = $lead['iin'];
            $temp['product']         = '-';
            $temp['credit_amount']   = '-';
            $temp['delivery_town']   = $lead['town'] === '' ? '-' : $lead['town'];
            $temp['utm_source_name'] = self::utmSourceName;

            $reportDataAlfa[] = $temp;
        }

        return $reportDataAlfa;
    }

    /**
     * Соединение всех полученных массивов
     *
     * @param $bccLeads
     * @param $sberLeads
     * @param $hcbLeads
     * @param $alfaLeads
     *
     * @return array
     */
    public function generate($bccLeads, $sberLeads, $hcbLeads, $alfaLeads)
    {
        $data = array_merge_recursive($bccLeads, $sberLeads, $hcbLeads, $alfaLeads);
        $this->arraySortByColumn($data, self::columnForSorting);

        return $data;
    }

    /**
     * Сортировка массива по колонке
     *
     * @param     $array
     * @param     $column
     * @param int $direction
     */
    public function arraySortByColumn(&$array, $column, $direction = SORT_ASC)
    {
        $reference_array = [];

        foreach ($array as $key => $row) {
            $reference_array[$key] = $row[$column];
        }

        array_multisort($reference_array, $direction, $array);
    }

    /**
     * Генерация meta-данных для отчета
     *
     * @param       $items
     * @param int   $perPage
     * @param null  $page
     * @param array $options
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page  = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}