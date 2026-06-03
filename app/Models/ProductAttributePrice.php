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
 * Class ProductAttributePrice
 *
 * @property int $id
 * @property bool $show_product_attribute
 * @property bool $is_active
 * @property int $quantity_in _stock
 * @property float|null $original_price
 * @property string|null $selling_price
 * @property int $product_id
 * @property int|null $product_attribute_id
 * @property int|null $subscription_attribute_id
 * @property string|null $attribute_value
 * @property string|null $digital_link
 * @property string|null $digital_link_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 *
 * @property User|null $user
 * @property Product $product
 *
 * @package App\Models
 */
class ProductAttributePrice extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'product_attribute_prices';

    protected $casts = [
        'show_product_attribute' => 'bool',
        'is_active' => 'bool',
        'quantity_in _stock' => 'int',
        'original_price' => 'float',
        'product_id' => 'int',
        'product_attribute_id' => 'int',
        'subscription_attribute_id' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'show_product_attribute',
        'is_active',
        'quantity_in _stock',
        'original_price',
        'selling_price',
        'product_id',
        'product_attribute_id',
        'subscription_attribute_id',
        'attribute_value',
        'digital_link',
        'digital_link_type',
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
