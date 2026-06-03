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
 * Class Payment
 *
 * @property int $id
 * @property string|null $order_id
 * @property string|null $invoice_no
 * @property string|null $payment_method
 * @property string|null $phone_number
 * @property int $name
 * @property string|null $transaction_id
 * @property Carbon $transaction_date
 * @property string|null $payment_status
 * @property float|null $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 * @property Collection|Refund[] $refunds
 *
 * @package App\Models
 */
class Payment extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'payments';

    protected $casts = [
        'name' => 'int',
        'transaction_date' => 'datetime',
        'amount' => 'float',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'order_id',
        'invoice_no',
        'payment_method',
        'phone_number',
        'name',
        'transaction_id',
        'transaction_date',
        'payment_status',
        'amount',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
