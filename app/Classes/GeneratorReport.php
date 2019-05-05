<?php


namespace App\Classes;


class GeneratorReport
{
    public function generate(Array $data){
        $config = config('report.'.$data['type']);
        $report = app($config[$data['id']]);
        $data['connect_type'] = $config['type'];
        $report->report($config['type'], $data['type'], $data['from']??null, $data['to']??null);
    }
}
