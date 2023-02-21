<?php

namespace App\Http\Requests;

use App\Models\Sale;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSaleRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sale_create');
    }

    public function rules()
    {
        return [
            'qty' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}