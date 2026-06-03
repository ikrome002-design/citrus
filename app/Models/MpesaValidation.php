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
 * Class MpesaValidation
 *
 * @property int $id
 * @property string|null $third_party_id
 * @property string|null $transaction_type
 * @property string|null $trans_id
 * @property Carbon|null $trans_time
 * @property float|null $amount
 * @property string|null $business_shortcode
 * @property string|null $bill_ref_number
 * @property float|null $balance
 * @property string|null $phone_number
 * @property string|null $name
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
class MpesaValidation extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'mpesa_validation';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'trans_time' => 'datetime',
        'amount' => 'float',
        'balance' => 'float',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'third_party_id',
        'transaction_type',
        'trans_id',
        'trans_time',
        'amount',
        'business_shortcode',
        'bill_ref_number',
        'balance',
        'phone_number',
        'name',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
