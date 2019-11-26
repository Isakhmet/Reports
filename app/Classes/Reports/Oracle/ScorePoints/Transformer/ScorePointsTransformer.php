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
     *  fields for unset
     */
    const EXTRA_FIELDS = [
        'browser_locale',
        'iss_date',
        'exp_date',
        'id_card',
        'home_phone',
        'economical_status_code',
        'birth_place',
        'iss_by',
        'citizenship',
        'document_type',
        'actual_residence',
        'marital_status',
        'education',
        'type_company_activity',
        'gclid',

    ];

    /**
     * @param array $row
     * @param array $keys
     *
     * @return array
     */
    public function transformCommon(array $row, array $keys): array
    {
        $row['products'] = $this->replaceProducts($row);

        if (is_array($row['category'])) {
            $row['category'] = $row['category']['code'];
        }

        unset($row['available_products']);
        unset($row['passed_products_ids']);

        $result = array_combine($keys, $row);

        return $result;
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

    public function exclusionOfExtraFields(array $fields): array
    {
        return array_diff_key($fields, array_flip(self::EXTRA_FIELDS));
    }

}
