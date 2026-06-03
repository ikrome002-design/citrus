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
 * Class MerchantBalanceTransaction
 *
 * @property int $id
 * @property int|null $order_item_id
 * @property int $merchant_id
 * @property float $amount
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property OrderItem|null $order_item
 * @property Merchant $merchant
 * @property User|null $user
 *
 * @package App\Models
 */
class MerchantBalanceTransaction extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'merchant_balance_transactions';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'order_item_id' => 'int',
        'merchant_id' => 'int',
        'amount' => 'float',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'order_item_id',
        'merchant_id',
        'amount',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function order_item()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
