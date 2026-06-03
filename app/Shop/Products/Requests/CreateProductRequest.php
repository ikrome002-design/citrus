<?php

namespace App\Shop\Products\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateProductRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
             'cover' => ['required', 'file'],
            'flat_amount' => ['numeric', 'nullable'],
            'product_type' => ['required'],
            'weight' => ['numeric', 'nullable'],
            'length' => ['numeric', 'nullable'],
            'width' => ['numeric', 'nullable'],
            'height' => ['numeric', 'nullable'],
        ];
    }
}
