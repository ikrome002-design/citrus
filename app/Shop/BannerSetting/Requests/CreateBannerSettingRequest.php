<?php

namespace App\Shop\BannerSetting\Requests;

use App\Shop\Base\BaseFormRequest;

class CreateBannerSettingRequest extends BaseFormRequest
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
            'subtitle' => ['required'],
            'description' => ['required'],
        ];
        
    }
}
