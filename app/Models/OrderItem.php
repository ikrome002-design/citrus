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
 * Class OrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $product_id
 * @property int|null $product_attribute_price_id
 * @property int|null $subscription_attribute_price_id
 * @property int|null $quantity
 * @property int|null $branch_id
 * @property string|null $branch_name
 * @property int $shipping_cost
 * @property string|null $order_item_status
 * @property Carbon|null $delivered_at
 * @property string|null $clearing_status
 * @property string|null $product_name
 * @property string|null $product_sku
 * @property string|null $product_description
 * @property float|null $original_price
 * @property float $selling_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 * @property Order $order
 * @property Collection|Invoice[] $invoices
 * @property MerchantBalanceTransaction $merchant_balance_transaction
 * @property Withdrawal $withdrawal
 *
 * @package App\Models
 */
class OrderItem extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'order_items';

    protected $casts = [
        'order_id' => 'int',
        'product_id' => 'int',
        'product_attribute_price_id' => 'int',
        'subscription_attribute_price_id' => 'int',
        'quantity' => 'int',
        'branch_id' => 'int',
        'shipping_cost' => 'int',
        'delivered_at' => 'datetime',
        'original_price' => 'float',
        'selling_price' => 'float',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'order_id',
        'product_id',
        'product_attribute_price_id',
        'subscription_attribute_price_id',
        'quantity',
        'branch_id',
        'branch_name',
        'shipping_cost',
        'order_item_status',
        'delivered_at',
        'clearing_status',
        'product_name',
        'product_sku',
        'product_description',
        'original_price',
        'selling_price',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function merchant_balance_transaction()
    {
        return $this->hasOne(MerchantBalanceTransaction::class);
    }

    public function withdrawal()
    {
        return $this->hasOne(Withdrawal::class);
    }
}
