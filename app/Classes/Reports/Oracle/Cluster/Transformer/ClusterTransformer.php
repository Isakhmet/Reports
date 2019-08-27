<?php

namespace App\Classes\Reports\Oracle\Cluster\Transformer;

use Illuminate\Support\Arr;

class ClusterTransformer
{
    /**
     * @param       $data
     * @param array $keys
     *
     * @return array
     */
    public function transform($data, array $keys)
    {
        $data    = Arr::only($data, $keys);
        $amount  = array_unique(json_decode($data['amounts'], true));
        $ids     = array_keys($amount);
        $months  = __('report.reports.cluster.months');
        $amounts = [];

        foreach ($ids as $id) {
            $amounts[$months[$id]] = $amount[$id];
        }

        $data['amounts'] = $amounts;

        return $data;
    }
}
