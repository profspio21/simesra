<?php

namespace App\Http\Requests;

use App\Models\RmCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRmCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('rm_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:rm_categories,id',
        ];
    }
}