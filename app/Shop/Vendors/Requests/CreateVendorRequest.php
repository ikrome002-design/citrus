<?php

namespace App\Shop\Vendors\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateVendorRequest extends FormRequest
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

            'first_name'                  => ['required'],
            'email'                 => ['required', 'email', 'unique:vendors'],
            'password'              => ['required', 'min:6'],
            'phone_number'                 => ['numeric', 'nullable', 'unique:vendors'],

        ];
    }




}


