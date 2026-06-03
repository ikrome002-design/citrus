<?php

namespace App\Shop\FeatureSetting\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateFeatureSettingRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'banner_image' => ['required'],
            'title' => ['required'],
            'order' => ['required'],
        ];
        
    }
}
