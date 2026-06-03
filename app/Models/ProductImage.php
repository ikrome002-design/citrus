<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductImage
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $image_url
 * @property int|null $product_attribute_price_id
 * @property int|null $subscription_attribute_price_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 * @property Product $product
 *
 * @package App\Models
 */
class ProductImage extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'product_images';

    protected $casts = [
        'product_id' => 'int',
        'product_attribute_price_id' => 'int',
        'subscription_attribute_price_id' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'product_id',
        'image_url',
        'product_attribute_price_id',
        'subscription_attribute_price_id',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
