<?php

namespace App\Classes\Reports\Oracle\ScoreClients\Transformer;

use Illuminate\Support\Arr;

/**
 * Class ScoreClientsTransformer
 *
 * @package App\Classes\Reports\Oracle\ScoreClients\Transformer
 */
class ScoreClientsTransformer
{
    /**
     * @param array $row
     * @param array $keys
     *
     * @return array
     */
    public function transformCommon(array $row, array $keys): array
    {
        $headers               = ['pass_score', 'pass_score_product'];
        $row['category_score'] = $row['category_score']['score']['score'] ?? 'Нет';
        $row['created_at']     = isset($row['created_at']) ? (string)$row['created_at'] : 'Нет';
        $row['gclid']          = isset($row['fields']['gclid']) ? (string)$row['fields']['gclid'] : '';
        $row                   = $this->transformName($row);
        $row                   = $this->transformBooleans($row, $headers);
        $row                   = $this->transformProducts($row);
        $row                   = Arr::only($row, $keys);
        $row                   = array_replace(array_flip($keys), $row);

        return $row;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function transformName(array $data): array
    {
        if (!isset($data['lastname'], $data['firstname'], $data['middlename'])) {
            return $data;
        }

        $data['full_name'] = trim("{$data['lastname']} {$data['firstname']} {$data['middlename']}");

        return $data;
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return array
     */
    public function transformBooleans(array $data, array $headers): array
    {
        foreach ($headers as $key) {
            if (isset($data[$key])) {
                $data[$key] = $data[$key] ? 'Да' : 'Нет';
            }
        }

        return $data;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function transformProducts(array $data): array
    {
        if (!isset($data['passed_products_ids']))
        {
            $data['products'] = '';

            return $data;
        }

        $products_ids = $data['passed_products_ids'];
        $products     = '';

        if (\count($products_ids))
        {
            $products = \array_map(
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

        $data['products'] = $products ?: 'Нет';
        unset($data['passed_products_ids'], $data['available_products']);

        return $data;
    }
}
