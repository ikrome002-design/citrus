<?php

namespace App\Shop\FeatureSetting;

use Illuminate\Database\Eloquent\Model;

class FeatureSetting extends Model
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
        'order',
        'button_link',
        'button_text',
        'status'
    ];

}
