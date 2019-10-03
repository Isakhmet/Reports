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
            'title'     => [
                'required',
            ],
            'description'    => [
                'required',
            ],
            'is_active'  => [
                'integer',
            ],
        ];
    }
}
