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
 * Class MpesaTranscation
 *
 * @property int $id
 * @property string|null $trans_id
 * @property int|null $business_shortcode
 * @property string|null $invoice_no
 * @property float|null $amount
 * @property string|null $third_party_id
 * @property string|null $conversation_id
 * @property string|null $checkout_request_id
 * @property string|null $balance
 * @property Carbon|null $transaction_date
 * @property string|null $transaction_type
 * @property string|null $phone_number
 * @property string|null $name
 * @property string|null $status
 * @property Carbon|null $date_posted
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 *
 * @property User|null $user
 *
 * @package App\Models
 */
class MpesaTranscation extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'mpesa_transcations';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'business_shortcode' => 'int',
        'amount' => 'float',
        'transaction_date' => 'datetime',
        'date_posted' => 'datetime',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'trans_id',
        'business_shortcode',
        'invoice_no',
        'amount',
        'third_party_id',
        'conversation_id',
        'checkout_request_id',
        'balance',
        'transaction_date',
        'transaction_type',
        'phone_number',
        'name',
        'status',
        'date_posted',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
