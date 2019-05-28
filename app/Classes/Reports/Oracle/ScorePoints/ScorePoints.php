<?php

namespace App\Classes\Reports\Oracle\ScorePoints;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Oracle\ScorePoints\Transformer\ScorePointsTransformer;
use App\Classes\Reports\Report;
use Illuminate\Support\Facades\Request;

/**
 * Class ScorePoints
 *
 * @package App\Classes\Reports\Oracle\ScorePoints
 */
class ScorePoints extends Connectors implements Report
{
    /**
     * @param $reportType
     * @param $page
     * @param $perPage
     * @param $from
     * @param $to
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function report($reportType, $page, $perPage, $from, $to)
    {
        $connect     = $this->connect($reportType);
        $first       = $connect->table('score_results')
                               ->first()
        ;
        $fields      = array_keys(json_decode($first->fields, true));
        $fields      = array_unique($fields);
        $columns     = __('report.reports.scorePoints.headers');
        $data        = $connect->table('fields')
                               ->whereIn('name', $fields)
                               ->pluck('title', 'name')
                               ->toArray()
        ;
        $columns     = array_merge($columns, $data);
        $keys        = array_keys($columns);
        $headers     = array_values($columns);
        $transformer = new ScorePointsTransformer();
        $connect->table('score_results')
                ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                ->orderBy('id')
                ->chunk(
                    500,
                    function ($results) use ($keys, $transformer) {
                        if ($results->isEmpty()) {
                            return response()->json(['Нет данных за указанный период'], 500);
                        }

                        $results = $results->map(
                            function ($item, $key) use ($keys, $transformer) {
                                $array = $transformer->availableProducts($item, $keys);

                                return $transformer->transformCommon($array);
                            }
                        );
                        $data    = $results->toArray();
                        cache(['data' => $data], 30);
                    }
                )
        ;
        $data             = cache('data');
        $data             = collect($data);
        $array            = $transformer->paginate(
            $data, $perPage, $page, [
                     'path'     => Request::url(),
                     'pageName' => 'page',
                 ]
        )
                                        ->toArray()
        ;
        $array['headers'] = $headers;
        $array['data']    = $transformer->paginateOrder($array['data']);

        return $array;
    }
}
