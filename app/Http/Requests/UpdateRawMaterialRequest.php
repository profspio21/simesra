<?php

namespace App\Http\Requests;

use App\Models\RawMaterial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRawMaterialRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('raw_material_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}