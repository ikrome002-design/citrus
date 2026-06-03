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
 * Class Order
 *
 * @property int $id
 * @property string $order_no
 * @property int|null $courier_id
 * @property int $user_id
 * @property int $address_id
 * @property string|null $order_status
 * @property Carbon|null $order_date
 * @property float $discounts
 * @property string $total_products
 * @property float $total_shipping
 * @property float $tax
 * @property float $total
 * @property float $total_paid
 * @property string|null $tracking_number
 * @property string|null $coupon
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 *
 * @property User $user
 * @property Address $address
 * @property Courier|null $courier
 * @property Collection|Courier[] $couriers
 * @property Collection|OrderItem[] $order_items
 * @property Collection|OrderStatusTimeline[] $order_status_timelines
 *
 * @package App\Models
 */
class Order extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'orders';

    protected $casts = [
        'courier_id' => 'int',
        'user_id' => 'int',
        'address_id' => 'int',
        'order_date' => 'datetime',
        'discounts' => 'float',
        'total_shipping' => 'float',
        'tax' => 'float',
        'total' => 'float',
        'total_paid' => 'float',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'order_no',
        'courier_id',
        'user_id',
        'address_id',
        'order_status',
        'order_date',
        'discounts',
        'total_products',
        'total_shipping',
        'tax',
        'total',
        'total_paid',
        'tracking_number',
        'coupon',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function couriers()
    {
        return $this->belongsToMany(Courier::class, 'courier_orders')
            ->withPivot('id', 'notes', 'deleted_at', 'created_by', 'deleted_by', 'updated_by')
            ->withTimestamps();
    }

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function order_status_timelines()
    {
        return $this->hasMany(OrderStatusTimeline::class);
    }
}
