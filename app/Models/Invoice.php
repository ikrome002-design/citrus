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
 * Class Invoice
 *
 * @property int $id
 * @property string|null $invoice_no
 * @property int|null $mass_invoice_id
 * @property int|null $order_item_id
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
 * @property string|null $bill_created
 * @property string|null $note
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
 * @property User $user
 * @property OrderItem|null $order_item
 *
 * @package App\Models
 */
class Invoice extends Model
{
	use SoftDeletes, CreatedUpdatedDeletedBy;
	protected $table = 'invoices';

	protected $casts = [
		'mass_invoice_id' => 'int',
		'order_item_id' => 'int',
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
		'invoice_no',
		'mass_invoice_id',
		'order_item_id',
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
		'bill_created',
		'note',
		'tax_type',
		'tax_amount',
		'discount_type',
		'discount_amt',
		'deleted_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function order_item()
	{
		return $this->belongsTo(OrderItem::class);
	}
}
