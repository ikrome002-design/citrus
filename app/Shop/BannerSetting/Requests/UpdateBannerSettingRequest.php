<?php

namespace App\Shop\BannerSetting\Requests;

use App\Shop\Base\BaseFormRequest;

class UpdateBannerSettingRequest extends BaseFormRequest
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
            'subtitle' => ['required'],
            'description' => ['required'],
        ];
    }
}
