<?php

namespace App\Shop\Footers\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateFooterRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'unique:footers'],
            'link' => ['required']
            
        ];
    }
}
