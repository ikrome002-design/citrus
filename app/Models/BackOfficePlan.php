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
 * Class BackOfficePlan
 *
 * @property int $id
 * @property string|null $name
 * @property float|null $price
 * @property float|null $transaction_fee
 * @property string|null $discount_type
 * @property string|null $apply_discount
 * @property float|null $discount_amount
 * @property string|null $govt_charges_type
 * @property string|null $apply_govt_charges
 * @property float|null $govt_charges_amt
 * @property int|null $account_type_id
 * @property float $discount
 * @property float $tax
 * @property float $trans_amount
 * @property int|null $total
 * @property bool|null $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property AccountType|null $account_type
 * @property User|null $user
 * @property BackOfficeSubscription $back_office_subscription
 *
 * @package App\Models
 */
class BackOfficePlan extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'back_office_plans';

    protected $casts = [
        'price' => 'float',
        'transaction_fee' => 'float',
        'discount_amount' => 'float',
        'govt_charges_amt' => 'float',
        'account_type_id' => 'int',
        'discount' => 'float',
        'tax' => 'float',
        'trans_amount' => 'float',
        'total' => 'int',
        'is_active' => 'bool',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'name',
        'price',
        'transaction_fee',
        'discount_type',
        'apply_discount',
        'discount_amount',
        'govt_charges_type',
        'apply_govt_charges',
        'govt_charges_amt',
        'account_type_id',
        'discount',
        'tax',
        'trans_amount',
        'total',
        'is_active',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function account_type()
    {
        return $this->belongsTo(AccountType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function back_office_subscription()
    {
        return $this->hasOne(BackOfficeSubscription::class);
    }
}
