<?php

namespace App\Http\Requests;

use App\Report;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreReportRequest extends FormRequest
{
    public function authorize()
    {

        return true;
    }

    public function rules()
    {
        return [
            'code'     => [
                'required',
            ],
            'name'    => [
                'required',
            ],
            'category'  => [
                'integer',
            ],
            'is_active'  => [
                'integer',
            ],
        ];
    }
}
