<?php

namespace App\Shop\MembershipVarients\Requests;

use App\Shop\Base\BaseFormRequest;

class UpdateMembershipVarientRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'display_name' => ['required'],
            'roles' => ['array']
        ];
    }
}
