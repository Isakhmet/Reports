<?php

namespace App\Classes\Reports\Oracle;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class OracleReportService
 *
 * @package App\Classes\Reports\Oracle
 */
class OracleReportService
{
    /**
     * @param $data
     *
     * @return mixed
     */
    public function transformData($data)
    {
        $data['category']            = json_decode($data['category'], true);
        $data['category_score_map']  = json_decode($data['category_score_map'], true);
        $data['category_score']      = json_decode($data['category_score'], true);
        $data['available_products']  = json_decode($data['available_products'], true);
        $data['products_score_maps'] = json_decode($data['products_score_maps'], true);
        $data['products_score']      = json_decode($data['products_score'], true);
        $data['passed_products_ids'] = json_decode($data['passed_products_ids'], true);
        $data['fields']              = json_decode($data['fields'], true);
        $data['user_fields']         = json_decode($data['user_fields'], true);
        $data['sended_products_ids'] = json_decode($data['sended_products_ids'], true);

        return $data;
    }

    /**
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

    /**
     * @param array $array
     *
     * @return array
     */
    public function paginateOrder(Array $array)
    {
        $keys = [];

        for ($i = 0; $i < count($array); $i++) {
            $keys[] = $i;
        }

        return array_combine($keys, $array);
    }
}
