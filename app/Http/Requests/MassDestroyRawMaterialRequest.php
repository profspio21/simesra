<?php

namespace App\Http\Requests;

use App\Models\RawMaterial;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRawMaterialRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('raw_material_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:raw_materials,id',
        ];
    }
}