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
 * Class BackOfficeSubscription
 *
 * @property int $id
 * @property int $merchant_id
 * @property int $back_office_plan_id
 * @property Carbon|null $expiry_date
 * @property Carbon|null $opted_out_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property Merchant $merchant
 * @property BackOfficePlan $back_office_plan
 * @property User|null $user
 *
 * @package App\Models
 */
class BackOfficeSubscription extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'back_office_subscriptions';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'merchant_id' => 'int',
        'back_office_plan_id' => 'int',
        'expiry_date' => 'datetime',
        'opted_out_at' => 'datetime',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'merchant_id',
        'back_office_plan_id',
        'expiry_date',
        'opted_out_at',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function back_office_plan()
    {
        return $this->belongsTo(BackOfficePlan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
