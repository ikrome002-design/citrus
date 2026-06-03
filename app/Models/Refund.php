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
 * Class Refund
 *
 * @property int $id
 * @property int $payment_id
 * @property float $amount
 * @property string $payment_type
 * @property string|null $phone_number
 * @property string|null $transaction_id
 * @property Carbon $transaction_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 * @property Payment $payment
 *
 * @package App\Models
 */
class Refund extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'refunds';

    protected $casts = [
        'payment_id' => 'int',
        'amount' => 'float',
        'transaction_date' => 'datetime',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'payment_id',
        'amount',
        'payment_type',
        'phone_number',
        'transaction_id',
        'transaction_date',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
