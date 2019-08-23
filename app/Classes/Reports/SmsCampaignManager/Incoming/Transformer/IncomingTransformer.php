<?php

namespace App\Classes\Reports\SmsCampaignManager\Incoming\Transformer;

class IncomingTransformer
{
    /**
     * @param array $data
     *
     * @return array
     */
    public function transform(array $data)
    {
        $array = [];

        foreach ($data as $key => $value) {
            $array[$key]['sent_at']   = $value['created_at'];
            $array[$key]['done_at']   = strtotime($value['received_at']) - strtotime($value['created_at']);
            $array[$key]['from']      = $value['from'];
            $array[$key]['to']        = $value['to'];
            $array[$key]['sms_count'] = $value['sms_count'];
            $array[$key]['price']     = $value['price'];
            $array[$key]['sum']       = $value['sms_count'] * $value['price'];
            $array[$key]['text']      = $value['text'];

            if ($array[$key]['done_at'] / 3600 > 1 || $array[$key]['done_at'] / 60 > 1) {
                $hours                  = (int)($array[$key]['done_at'] / 3600);
                $min                    = (int)(($array[$key]['done_at'] % 3600) / 60); //279116
                $seconds                = $array[$key]['done_at'] - ($hours * 3600 + $min * 60);
                $hours                  = $hours > 0 ? "$hours hours, " : '';
                $min                    = $min > 0 ? "$min minutes, " : '';
                $doneAt                 = $hours . $min . $seconds . ' seconds';
                $array[$key]['done_at'] = $doneAt;
            }
        }

        return $array;
    }
}
