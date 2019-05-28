<?php

namespace App\Classes\Reports\Oracle\ScoreValues\Transformer;

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

        foreach ($data as $key => $row) {

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
        $productsIds = $data['passed_products_ids'];
        $products    = '';

        if (\count($productsIds)) {
            $products = array_map(
                function ($product) use ($productsIds) {
                    if (\in_array((int)$product['id'], $productsIds, 1)) {
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
