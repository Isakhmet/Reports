<?php

namespace App\Http\Requests;

use App\CategoriesReport;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreCategoryReportRequest extends FormRequest
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
            'is_active'  => [
                'integer',
            ],
        ];
    }
}
