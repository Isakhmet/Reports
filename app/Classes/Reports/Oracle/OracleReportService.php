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
        $data = json_decode(json_encode($data), true);

        foreach ($data as $key => $row) {
            $data[$key]['category']            = json_decode($row['category'], true);
            $data[$key]['category_score_map']  = json_decode($row['category_score_map'], true);
            $data[$key]['category_score']      = json_decode($row['category_score'], true);
            $data[$key]['available_products']  = json_decode($row['available_products'], true);
            $data[$key]['products_score_maps'] = json_decode($row['products_score_maps'], true);
            $data[$key]['products_score']      = json_decode($row['products_score'], true);
            $data[$key]['passed_products_ids'] = json_decode($row['passed_products_ids'], true);
            $data[$key]['fields']              = json_decode($row['fields'], true);
            $data[$key]['user_fields']         = json_decode($row['user_fields'], true);
            $data[$key]['sended_products_ids'] = json_decode($row['sended_products_ids'], true);
        }

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
