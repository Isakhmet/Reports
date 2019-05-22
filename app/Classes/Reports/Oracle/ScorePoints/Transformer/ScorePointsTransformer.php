<?php

namespace App\Classes\Reports\Oracle\ScorePoints\Transformer;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

/**
 * Class ScorePointsTransformer
 *
 * @package App\Classes\Reports\Oracle\ScorePoints\Transformer
 */
class ScorePointsTransformer
{
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
     * @param array $row
     *
     * @return array
     */
    public function transformCommon(array $row): array
    {
        $row['products'] = $this->replaceProducts($row);

        if (is_array($row['category'])) {
            $row['category'] = $row['category']['code'];
        }

        unset($row['available_products']);
        unset($row['passed_products_ids']);
        $row = array_values($row);

        return $row;
    }

    /**
     * @param       $data
     * @param array $columns
     *
     * @return array
     */
    public function availableProducts($data, array $columns): array
    {
        $data                        = json_decode(json_encode($data), true);
        $available_products          = json_decode($data['available_products'] ?? '', true);
        $passed_products_ids         = json_decode($data['passed_products_ids'] ?? '', true);
        $data['fields']              = json_decode($data['fields'] ?? '', true);
        $data['category']            = json_decode($data['category'] ?? '', true);
        $data['category_score_map']  = json_decode($data['category_score_map'] ?? '', true);
        $data['category_score']      = json_decode($data['category_score'] ?? '', true);
        $data['products_score_maps'] = json_decode($data['products_score_maps'] ?? '', true);
        $data['products_score']      = json_decode($data['products_score'] ?? '', true);
        $data['user_fields']         = json_decode($data['user_fields'] ?? '', true);


        $data = $this->only($data, array_merge(['fields'], $columns));

        $data['passed_products_ids'] = $passed_products_ids;
        $data['available_products']  = $available_products;
        $fields                      = Arr::only($data['fields'], $columns);
        unset($data['fields']);
        $data = array_merge($data, $fields);

        return $data;
    }

    /**
     * @param $data
     * @param $attributes
     *
     * @return array
     */
    public function only($data, $attributes)
    {
        $results = [];

        foreach ($attributes as $attribute) {
            $results[$attribute] = $data[$attribute] ?? null;
        }

        return $results;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public function replaceProducts(array $data): string
    {
        if (!isset($data['passed_products_ids'])) {
            return '';
        }
        $products_ids = $data['passed_products_ids'];
        $products     = '';

        if (\count($products_ids)) {
            $products = array_map(
                function ($product) use ($products_ids) {
                    if (\in_array((int)$product['id'], $products_ids, 1)) {
                        return $product['name'];
                    }

                    return null;
                }, $data['available_products']
            );
            $products = array_filter($products);
            $products = implode(', ', $products);
        }

        if (!$products) {
            return 'Нет';
        }

        return $products;
    }
}
