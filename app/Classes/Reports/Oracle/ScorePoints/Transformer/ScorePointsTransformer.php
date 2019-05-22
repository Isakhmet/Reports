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
    public function transform_common(array $row): array
    {
        $row['products'] = $this->replace_products($row);

        if (is_array($row['category'])) {
            $row['category'] = $row['category']['code'];
        }

        unset($row['available_products']);
        unset($row['passed_products_ids']);
        $row = array_values($row);

        return $row;
    }

    /**
     * @param array $data
     *
     * @return array
     * @throws \Exception
     */
    public function get_fields(array $data): array
    {
        $fields       = [];
        $fields       = array_merge($fields, array_keys($data['fields']));
        $fields       = array_unique($fields);
        $fields_cache = cache('fields');

        if (!$fields_cache) {
            $fields_cache = Fields::get();
            cache(['fields' => $fields_cache], 1440);
        }

        if (!empty($fields)) {
            $fields = $fields_cache->whereIn('name', $fields);
        }

        $columns = new Collection(
            [
                'id'           => '#',
                'created_at'   => 'Дата/Время',
                'iin'          => 'ИИН',
                'full_name'    => 'ФИО',
                'mobile_phone' => 'Телефон',
                'email'        => 'email',
                'ore'          => 'Руда',
                'products'     => 'Продукты',
            ]
        );

        $columns = $columns->merge(
            $fields->pluck('title', 'name')
                   ->toArray()
        )
                           ->toArray()
        ;

        return $columns;
    }

    /**
     * @param       $data
     * @param array $columns
     *
     * @return array
     */
    public function available_products($data, array $columns): array
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

        foreach (is_array($attributes) ? $attributes : func_get_args() as $attribute) {
            $results[$attribute] = $data[$attribute] ?? null;
        }

        return $results;
    }

    /**
     * @param array $data
     *
     * @return string
     */
    public function replace_products(array $data): string
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
