<?php

namespace App\Shop\Customers\Requests;

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
        
        $this->redirect=url()->current().'?tab=v-pills-account-details';
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['email', Rule::unique('customers')->ignore(auth()->user()->id)]
           
        ];
    }
}
