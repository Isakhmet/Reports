<?php

namespace App\Classes\Reports\Oracle\ScoreValues;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Oracle\OracleReportService;
use App\Classes\Reports\Oracle\ScoreValues\Transformer\ScoreValuesTransformer;
use App\Classes\Reports\Report;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

/**
 * Class ScoreValues
 *
 * @package App\Classes\Reports\Oracle\ScoreValues
 */
class ScoreValues extends Connectors implements Report
{
    /**
     * @param     $reportType
     * @param int $page
     * @param int $perPage
     * @param     $from
     * @param     $to
     *
     * @return mixed
     */
    public function report($reportType, $page, $perPage, $from, $to)
    {
        $transformer  = new ScoreValuesTransformer();
        $service      = new OracleReportService();
        $connect      = $this->connect($reportType);
        $query        = $connect->table('score_results')
                                ->where('created_at', '>=', $from . ' 00:00:00')
                                ->where('created_at', '<=', $to . ' 23:59:59')
                                ->get()
        ;
        $fields_ids   = $transformer->getFields($query);
        $fields       = $connect->table('fields')
                                ->whereIn('id', $fields_ids)
                                ->get(['id', 'name', 'title'])
        ;
        $fieldsTitles = [];

        foreach ($fields as $field) {
            $fieldsTitles[$field->id]['name']  = $field->name;
            $fieldsTitles[$field->id]['title'] = $field->title;
        }

        $data = $service->transformData($query->toArray());
        $iteration_array = $transformer->transformCommon($data, $fieldsTitles);
        $data            = $iteration_array['data'];
        $data            = new Collection($data);

        if ($data->isEmpty()) {
            return response()->json(['Нет данных за указанный период'], 500);
        }

        $keys    = array_keys($iteration_array['columns']);
        $headers = array_values($iteration_array['columns']);
        $chunks  = $data->chunk(70000000);
        $values  = [];

        foreach ($chunks as $key => $chunk) {
            $data = $chunk->map(
                function ($item, $key) use ($keys, $transformer) {
                    $item['products'] = $transformer->replaceProducts($item);
                    $item             = (collect($item))->only($keys);

                    return $item;
                }
            );

            foreach ($data->toArray() as $number => $item) {
                foreach ($keys as $name) {
                    if (isset($item[$name])) {
                        $values[$number][$name] = $item[$name];
                    } else {
                        $values[$number][$name] = '';
                    }
                }
            }
        }

        $data             = collect($values);
        $array            = $service->paginate(
            $data, $perPage, $page, [
                     'path'     => Request::url(),
                     'pageName' => 'page',
                 ]
        )
                                        ->toArray()
        ;
        $array['headers'] = $headers;
        $array['data']    = $service->paginateOrder($array['data']);

        return $array;
    }
}
