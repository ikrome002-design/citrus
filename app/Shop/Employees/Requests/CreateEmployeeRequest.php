<?php

namespace App\Shop\Admins\Requests;
//namespace App\Shop\Employees\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEmployeeRequest extends FormRequest
{
    
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
            'email' => ['required', 'email', 'unique:employees'],
            'password' => ['required', 'min:6'],
            'phone' => ['required','numeric', 'nullable', 'unique:employees'],
            'status' => ['required'],
            'role' => ['required']
        ];
    }
}


