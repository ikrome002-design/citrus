<?php

namespace App\Shop\Admins\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
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
            'avatar' => ['mimes:jpeg,jpg,png,gif|nullable|max:2048'],
            'name' => ['required'],
            'phone' => ['required','numeric', 'nullable'],
            'email' => ['required', 'email'],
            'status' => ['required'],
        ];
    }
}
