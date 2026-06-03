<?php

namespace App\Shop\FeatureSetting\Requests;

use App\Shop\Base\BaseFormRequest;

class UpdateFeatureSettingRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required'],
            'order' => ['required'],
        ];
    }
}
