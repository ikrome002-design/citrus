<?php

namespace App\Shop\Taxes\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateTaxRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tax_name' => ['required'],
            'rate_percentage' => ['required']
            
            
        ];
        
    }
}
