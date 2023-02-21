<?php

namespace App\Http\Requests;

use App\Models\OutletKitchen;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOutletKitchenRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('outlet_kitchen_edit');
    }

    public function rules()
    {
        return [
            'lokasi' => [
                'string',
                'required',
            ],
            'users.*' => [
                'integer',
            ],
            'users' => [
                'array',
            ],
        ];
    }
}