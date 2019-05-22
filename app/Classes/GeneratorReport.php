<?php

namespace App\Classes;

/**
 * Class GeneratorReport
 *
 * @package App\Classes
 */
class GeneratorReport
{
    /**
     * @param array $data
     *
     * @return mixed
     */
    public function generate(Array $data)
    {
        $config               = config('report.' . $data['type']);
        $report               = app($config[$data['id']]);

        return $report->report($data['type'], $data['page'], $data['per_page'] ?? 15, $data['date_start'] ?? null, $data['date_end'] ?? null);
    }
}
