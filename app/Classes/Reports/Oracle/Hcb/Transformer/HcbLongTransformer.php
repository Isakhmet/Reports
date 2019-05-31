<?php

namespace App\Classes\Reports\Oracle\Hcb\Transformer;

use Illuminate\Support\Arr;

/**
 * Class HcbLongTransformer
 *
 * @package App\Classes\Reports\Oracle\Hcb\Transformer
 */
class HcbLongTransformer
{
    /**
     * @param       $data
     * @param array $keys
     *
     * @return array
     */
    public function transform($data, array $keys)
    {
        $data  = Arr::only($data, $keys);
        $array = ['failed', 'valid', 'accepted', 'send', 'postback'];

        foreach ($array as $field) {
            if ($field == 'valid') {
                $valid = $data['valid'] === true && empty($data['valid_errors']);
                $valid ? 'Да' : 'Нет';
            } else {
                switch ($data[$field]) {
                    case true:
                        $data[$field] = 'Да';
                        break;
                    case false:
                        $data[$field] = 'Нет';
                        break;

                    default:
                        $data[$field] = 'Нет';
                        break;
                }
            }
        }

        if ($data['failed'] == true && !empty($data['partner_server_info'])) {
            if (isset($data['partner_server_info']['attributes']['error_dscr'])) {
                $data['partner_server_info'] = $data['partner_server_info']['attributes']['error_dscr'];
            } else {
                $data['partner_server_info'] = null;
            }
        }

        if ($data['partner_server_postback'] != null) {
            if (is_array($data['partner_server_postback'])) {
                $data['partner_server_postback'] = $data['partner_server_postback']['status'] . '(orderNo: ' . $data['partner_server_postback']['orderNo'] . ')';
            } else {
                $data['partner_server_postback'] = null;
            }
        }

        return $data;
    }
}
