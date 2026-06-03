<?php

namespace App\Shop\Vendors\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'first_name' => ['required']
            // 'phone_number' => ['required', 'numeric', Rule::unique('vendors')->ignore(auth('vendor')->user()->id)],
            // 'email' => ['required', 'email', Rule::unique('vendors')->ignore(auth('vendor')->user()->id)]
        ];
    }
}
