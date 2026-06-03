<?php

namespace App\Shop\MembershipVarients\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateMembershipVarientRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:membership_varients']
        ];
    }
}
