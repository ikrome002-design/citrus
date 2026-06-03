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
 * Class MassInvoice
 *
 * @property int $id
 * @property string|null $mass_invoice_no
 * @property int|null $quantity
 * @property float $price
 * @property float $subtotal
 * @property float|null $amount
 * @property float|null $discount
 * @property float $tax
 * @property float $total
 * @property string|null $description
 * @property float|null $transaction_fee
 * @property float|null $trans_amount
 * @property int $user_id
 * @property int|null $created_by
 * @property Carbon|null $duedate
 * @property Carbon|null $datepaid
 * @property string|null $status
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $tax_type
 * @property float|null $tax_amount
 * @property int|null $discount_type
 * @property float|null $discount_amt
 * @property int|null $deleted_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class MassInvoice extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'mass_invoices';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'quantity' => 'int',
        'price' => 'float',
        'subtotal' => 'float',
        'amount' => 'float',
        'discount' => 'float',
        'tax' => 'float',
        'total' => 'float',
        'transaction_fee' => 'float',
        'trans_amount' => 'float',
        'user_id' => 'int',
        'created_by' => 'int',
        'duedate' => 'datetime',
        'datepaid' => 'datetime',
        'tax_type' => 'int',
        'tax_amount' => 'float',
        'discount_type' => 'int',
        'discount_amt' => 'float',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'mass_invoice_no',
        'quantity',
        'price',
        'subtotal',
        'amount',
        'discount',
        'tax',
        'total',
        'description',
        'transaction_fee',
        'trans_amount',
        'user_id',
        'created_by',
        'duedate',
        'datepaid',
        'status',
        'notes',
        'tax_type',
        'tax_amount',
        'discount_type',
        'discount_amt',
        'deleted_by',
        'updated_by'
    ];
}
