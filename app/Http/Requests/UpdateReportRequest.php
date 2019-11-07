<?php

namespace App\Http\Requests;

use App\Report;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateReportRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => [
                'required'
            ],
            'code'    => [
                'required',
            ],
            'name'   => [
                'required',
            ],
            'is_active' => [
                'boolean',
            ],
            'category_id' => [
                'integer',
            ],
        ];
    }
}
