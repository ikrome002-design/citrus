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
 * Class CourierOrder
 *
 * @property int $id
 * @property int $courier_id
 * @property int $order_id
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property Courier $courier
 * @property Order $order
 * @property User|null $user
 *
 * @package App\Models
 */
class CourierOrder extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'courier_orders';

    protected $casts = [
        'courier_id' => 'int',
        'order_id' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'courier_id',
        'order_id',
        'notes',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
