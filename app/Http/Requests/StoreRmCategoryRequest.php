<?php

namespace App\Http\Requests;

use App\Models\RmCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRmCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rm_category_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:raw_material_categories'
            ],
        ];
    }
}