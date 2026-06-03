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
 * Class Withdrawal
 *
 * @property int $id
 * @property int|null $order_item_id
 * @property int $merchant_id
 * @property string $withdrawal_status
 * @property Carbon $requested_at
 * @property Carbon|null $processed_at
 * @property float $amount
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property User|null $user
 * @property OrderItem|null $order_item
 *
 * @package App\Models
 */
class Withdrawal extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'withdrawals';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'order_item_id' => 'int',
        'merchant_id' => 'int',
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
        'amount' => 'float',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'order_item_id',
        'merchant_id',
        'withdrawal_status',
        'requested_at',
        'processed_at',
        'amount',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function order_item()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
