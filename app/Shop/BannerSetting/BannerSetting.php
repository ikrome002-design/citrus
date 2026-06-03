<?php

namespace App\Shop\BannerSetting;

use Illuminate\Database\Eloquent\Model;

class BannerSetting extends Model
{
  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'banner_image',
        'title',
        'subtitle',
        'description',
    ];

}
