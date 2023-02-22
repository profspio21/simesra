<?php

namespace App\Http\Requests;

use App\Models\RawMaterial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRawMaterialRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('raw_material_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'category_id' => [
                'required',
            ],
        ];
    }
}