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
     * @param array $row
     *
     * @return array
     */
    public function transformExcel(array $row): array
    {
        $row['products'] = $this->replaceProducts($row);

        if (is_array($row['category'])) {
            $row['category'] = $row['category']['code'];
        }

        unset($row['available_products']);
        unset($row['passed_products_ids']);

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
        $availableProducts           = $data['available_products'];
        $passedProductsIds           = $data['passed_products_ids'];
        $data                        = $this->only($data, array_merge(['fields'], $columns));
        $data['passed_products_ids'] = $passedProductsIds;
        $data['available_products']  = $availableProducts;
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
