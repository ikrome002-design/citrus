<?php

namespace App\Shop\Employees\Requests;
//namespace App\Shop\Employees\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CreateEmployeeBusinessRequest extends FormRequest
{
    

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'business_name' => ['required'],
            'office_address' => ['required']
        ];
    }
}
