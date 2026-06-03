<?php

namespace App\Http\Controllers\Admin\Categories\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
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
            'name' => 'required',
            'parent_id' => 'nullable|required_without:business_type_id|prohibited_unless:business_type_id,null|exists:categories,id',
            'business_type_id' => 'nullable|required_without:parent_id|prohibited_unless:parent_id,null|exists:business_type,id',
            'featured_image' => 'required|mimes:jpg,png,jpeg,gif,webp|max:5120',
            'is_visible' => 'required',
            'status' => 'required',
        ];
    }
}