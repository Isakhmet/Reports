<?php

namespace App\Classes\Reports\Oracle\ScoreValues;

use App\Classes\Connectors\Connectors;
use App\Classes\Reports\Oracle\OracleReportService;
use App\Classes\Reports\Oracle\ScoreValues\Transformer\ScoreValuesTransformer;
use App\Classes\Reports\Report;
use Illuminate\Support\Arr;

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
        ;
        $fields_ids   = $transformer->getFields($query->get());
        $fields       = $connect->table('fields')
                                ->whereIn('id', $fields_ids)
                                ->get(['id', 'name', 'title'])
        ;
        $fieldsTitles = [];

        foreach ($fields as $field) {
            $fieldsTitles[$field->id]['name']  = $field->name;
            $fieldsTitles[$field->id]['title'] = $field->title;
        }

        $excelData = json_decode(
            json_encode(
                $query->get()
                      ->toArray()
            ), true
        );
        $result    = json_decode(json_encode($query->paginate($perPage)), true);
        $excel     = [];

        foreach ($excelData as $key => $value) {
            $excelData[$key] = $service->transformData($value);
        }
        $excelData        = $transformer->transformCommon($excelData, $fieldsTitles);
        $excel['columns'] = array_flip($excelData['columns']);
        $excelKey         = array_keys($excelData['columns']);

        foreach ($excelData['data'] as $key => $row) {
            $row['products'] = $transformer->replaceProducts($row);
            $row             = Arr::only($row, $excelKey);

            foreach ($excelKey as $name) {
                if (isset($row[$name])) {
                    $excel['data'][$key][$name] = $row[$name];
                } else {
                    $excel['data'][$key][$name] = '';
                }
            }
        }

        foreach ($result['data'] as $key => $value) {
            $value                = json_decode(json_encode($value), true);
            $result['data'][$key] = $service->transformData($value);
        }

        $iterationArray = $transformer->transformCommon($result['data'], $fieldsTitles);
        $data           = $iterationArray['data'];
        $keys           = array_keys($iterationArray['columns']);
        $headers        = array_values($iterationArray['columns']);
        $values         = [];

        foreach ($data as $key => $row) {
            $row['products'] = $transformer->replaceProducts($row);
            $row             = Arr::only($row, $keys);

            foreach ($keys as $name) {
                if (isset($row[$name])) {
                    $values[$key][$name] = $row[$name];
                } else {
                    $values[$key][$name] = '';
                }
            }
        }

        $result['data']    = $values;
        $result['headers'] = $headers;
        $result['excel']   = $excel;

        return $result;
    }
}
