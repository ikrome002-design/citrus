<?php

namespace App\Shop\Memberships\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateMembershipRequest extends BaseFormRequest
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
            'price' => ['required'],
            'package_expire' => ['required']
            
        ];
        
    }
}
