<?php

namespace App\Classes\Reports\Oracle\Delayed\Transformer;

class OkzaimTransformer
{
    public function transform($data, array $keys)
    {
        $data['status']    = trans('report.reports.okzaim.statuses.' . $data['name']);
        $data['is_double'] = $data['is_double'] ? 'Да' : 'Нет';

        if (
            !$data['send_at']
            && $data['created_at'] !== $data['updated_at']
        ) {
            $data['send_at'] = $data['updated_at'];
        }

        $result = [];

        foreach ($keys as $key) {
            $result[$key] = $data[$key] ?? '';
        }

        return $result;
    }
}
