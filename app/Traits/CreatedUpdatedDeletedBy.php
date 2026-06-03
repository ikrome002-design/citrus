<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait CreatedUpdatedDeletedBy
{
    public static function bootCreatedUpdatedDeletedBy()
    {
        static::creating(function (Model $model) {
            if (auth()->check()) {
                $model->created_by = auth()->id();
                $model->updated_by = auth()->id();
            }
        });

        static::updating(function (Model $model) {
            if (auth()->check()) {
                $model->updated_by = auth()->id();
            }
        });

        static::deleting(function (Model $model) {
            if (auth()->check()) {
                $model->deleted_by = auth()->id();
                $model->save();
            }
        });

        static::restoring(function (Model $model) {
            if (auth()->check()) {
                $model->deleted_by = null;
                $model->updated_by = auth()->id();
            }
        });
    }
}
