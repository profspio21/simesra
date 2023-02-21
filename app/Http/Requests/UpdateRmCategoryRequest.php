<?php

namespace App\Http\Requests;

use App\Models\RmCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRmCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('rm_category_edit');
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