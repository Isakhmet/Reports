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
        $data['connect_type'] = $config['type'];

        return $report->report($config['type'], $data['type'], $data['date_start'] ?? null, $data['date_end'] ?? null);
    }
}
