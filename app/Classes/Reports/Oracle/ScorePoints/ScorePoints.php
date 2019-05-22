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
     * @param $report_type
     * @param $page
     * @param $per_page
     * @param $from
     * @param $to
     *
     * @return array|mixed
     * @throws \Exception
     */
    public function report($report_type, $page = 1, $per_page = 15, $from, $to)
    {
        $connect = $this->connect($report_type);

        $first = $connect->table('score_results')
                         ->first()
        ;

        $fields  = array_keys(json_decode($first->fields, true));
        $fields  = array_unique($fields);
        $columns =
            [
                'id'           => 'ID',
                'created_at'   => 'Дата/Время',
                'iin'          => 'ИИН',
                'full_name'    => 'ФИО',
                'mobile_phone' => 'Телефон',
                'email'        => 'email',
                'ore'          => 'Руда',
                'products'     => 'Продукты',
            ];

        $data = $connect->table('fields')
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
                                $array = $transformer->available_products($item, $keys);

                                return $transformer->transform_common($array);
                            }
                        );
                        $data    = $results->toArray();
                        cache(['data' => $data], 30);
                    }
                )
        ;

        $data  = cache('data');
        $data  = collect($data);
        $array = $transformer->paginate(
            $data, $per_page, $page, [
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
