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
 * Class Receipt
 *
 * @property int $id
 * @property string|null $receipt_no
 * @property string|null $invoice_no
 * @property string|null $order_no
 * @property int|null $user_id
 * @property string|null $description
 * @property Carbon|null $datepaid
 * @property float|null $amount
 * @property float $subtotal
 * @property float $discount
 * @property float $tax
 * @property float $total
 * @property float|null $trans_amount
 * @property float|null $transaction_fee
 * @property string $type
 * @property string $pmethod
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 *
 * @property User|null $user
 *
 * @package App\Models
 */
class Receipt extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'receipts';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'datepaid' => 'datetime',
        'amount' => 'float',
        'subtotal' => 'float',
        'discount' => 'float',
        'tax' => 'float',
        'total' => 'float',
        'trans_amount' => 'float',
        'transaction_fee' => 'float',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'receipt_no',
        'invoice_no',
        'order_no',
        'user_id',
        'description',
        'datepaid',
        'amount',
        'subtotal',
        'discount',
        'tax',
        'total',
        'trans_amount',
        'transaction_fee',
        'type',
        'pmethod',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
