<?php

namespace App\Shop\Memberships\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMembershipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'membership_varient_id' => ['numeric'],
            'price' => ['numeric'],
            'sell' => ['numeric'],
            'add' => ['numeric'],
            'display' => ['numeric']
        ];
    }
}
