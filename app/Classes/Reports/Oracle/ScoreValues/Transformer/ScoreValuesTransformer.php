<?php

namespace App\Classes\Reports\Oracle\ScoreValues\Transformer;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Class ScoreValuesTransformer
 *
 * @package App\Classes\Reports\Oracle\ScoreValues\Transformer
 */
class ScoreValuesTransformer
{
    /**
     * @param $data
     *
     * @return array
     */
    public function getFields($data)
    {
        $fieldsIds = [];

        foreach ($data as $row) {
            $categoryScore = json_decode($row->category_score, true);

            if (
                isset($categoryScore['score']['rules'])
                && \is_array($categoryScore['score']['rules'])
                && $categoryScoreRules = $categoryScore['score']['rules']
            ) {
                /** @noinspection ForeachSourceInspection */
                foreach ($categoryScoreRules as $rule) {
                    $fieldsIds[] = $rule['rule']['field_id'];

                    if (isset($rule['rule']['dep_field_id']) && !empty($rule['rule']['dep_field_id'])) {
                        $fieldsIds[] = $rule['rule']['dep_field_id'];
                    }
                }
            }

        }

        $fieldsIds = array_unique($fieldsIds);

        return $fieldsIds;
    }

    /**
     * @param array $data
     * @param       $fields
     *
     * @return array
     */
    public function transformCommon(array $data, $fields)
    {
        $columns    = __('report.reports.scoreValues.columns');
        $addColumns = [];
        $data       = json_decode((json_encode($data)), true);

        foreach ($data as $key => $row) {
            $data[$key]['category_score']      = $row['category_score'] = json_decode($row['category_score'], true);
            $data[$key]['category']            = $row['category'] = json_decode($row['category'], true);
            $data[$key]['category_score_map']  = $row['category_score_map'] = json_decode(
                $row['category_score_map'], true
            );
            $data[$key]['available_products']  = $row['available_products'] = json_decode(
                $row['available_products'], true
            );
            $data[$key]['products_score_maps'] = $row['products_score_maps'] = json_decode(
                $row['products_score_maps'], true
            );
            $data[$key]['products_score']      = $row['products_score'] = json_decode($row['products_score'], true);
            $data[$key]['user_fields']         = $row['user_fields'] = json_decode($row['user_fields'], true);
            $data[$key]['fields']              = $row['fields'] = json_decode($row['fields'], true);

            if (
                (
                    !isset($row['full_name'])
                    || !$row['full_name']
                )
                && isset($row['fields']['full_name'])
            ) {
                $data[$key]['full_name'] = $row['fields']['full_name'];
            }

            if (
                isset($row['category_score']['score']['rules'])
                && \is_array($row['category_score']['score']['rules'])
                && $categoryScoreRules = $row['category_score']['score']['rules']
            ) {
                /**
                 * @var $category_score_rules array
                 */
                foreach ($categoryScoreRules as $rule) {
                    $field     = $fields[$rule['rule']['field_id']] ?? null;
                    $dep_field = $fields[$rule['rule']['dep_field_id']] ?? null;

                    if ($dep_field) {
                        $column              = "{$field['name']}-{$dep_field['name']}";
                        $addColumns[$column] = "{$field['title']}/{$dep_field['title']}";
                    } else {
                        $column              = $field['name'];
                        $addColumns[$column] = $field['title'];
                    }

                    if (!isset($data[$key][$column])) {
                        $data[$key][$column] = is_numeric($rule['result']) ? $rule['result'] : 'Нет';
                    } elseif (is_numeric($rule['result']) && $rule['result']) {
                        if ($data[$key][$column] === 'Нет') {
                            $data[$key][$column] = $rule['result'];
                        } else {
                            $data[$key][$column] += $rule['result'];
                        }
                    }
                }

                $data[$key]['score-result'] = $row['category_score']['score']['score'];
            }
        }

        $columns                 = array_merge($columns, $addColumns);
        $columns['score-result'] = 'Скоринг';
        $array                   = ['data' => $data, 'columns' => $columns];

        return $array;
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
        $products_ids = json_decode($data['passed_products_ids'], true);
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
