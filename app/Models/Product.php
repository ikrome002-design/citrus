<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 *
 * @property int $id
 * @property string|null $brand
 * @property int|null $category_id
 * @property string|null $sku
 * @property string $name
 * @property string $slug
 * @property string|null $content
 * @property string|null $description
 * @property string|null $image
 * @property bool $show_product
 * @property float|null $length
 * @property float|null $width
 * @property float|null $height
 * @property string|null $length_unit
 * @property float|null $weight
 * @property string|null $weight_unit
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $product_type
 * @property int|null $merchant_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $tarrif_id
 * @property string|null $deleted_at
 * @property bool $is_active
 * @property int|null $deleted_by
 *
 * @property User|null $user
 * @property Category|null $category
 * @property Merchant|null $merchant
 * @property Collection|ProductAttributePrice[] $product_attribute_prices
 * @property Collection|ProductImage[] $product_images
 * @property Collection|ProductRating[] $product_ratings
 * @property Collection|Wishlist[] $wishlists
 *
 * @package App\Models
 */
class Product extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'products';

    protected $casts = [
        'category_id' => 'int',
        'show_product' => 'bool',
        'length' => 'float',
        'width' => 'float',
        'height' => 'float',
        'weight' => 'float',
        'merchant_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'tarrif_id' => 'int',
        'is_active' => 'bool',
        'deleted_by' => 'int'
    ];

    protected $fillable = [
        'brand',
        'category_id',
        'sku',
        'name',
        'slug',
        'content',
        'description',
        'image',
        'show_product',
        'length',
        'width',
        'height',
        'length_unit',
        'weight',
        'weight_unit',
        'product_type',
        'merchant_id',
        'created_by',
        'updated_by',
        'tarrif_id',
        'is_active',
        'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function product_attribute_prices()
    {
        return $this->hasMany(ProductAttributePrice::class);
    }

    public function product_images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function product_ratings()
    {
        return $this->hasMany(ProductRating::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
}
