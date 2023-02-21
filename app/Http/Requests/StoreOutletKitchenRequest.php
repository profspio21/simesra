<?php

namespace App\Http\Requests;

use App\Models\OutletKitchen;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOutletKitchenRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('outlet_kitchen_create');
    }

    public function rules()
    {
        return [
            'lokasi' => [
                'string',
                'required',
                'unique:outlet_kitchens'
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