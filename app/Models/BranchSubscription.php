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
 * Class BranchSubscription
 *
 * @property int $id
 * @property int $merchant_id
 * @property int $branch_plan_id
 * @property Carbon|null $branch_expiry_date
 * @property int $branches
 * @property Carbon|null $opted_out_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property BranchPlan $branch_plan
 * @property Merchant $merchant
 * @property User|null $user
 *
 * @package App\Models
 */
class BranchSubscription extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'branch_subscriptions';

    protected $casts = [
        'merchant_id' => 'int',
        'branch_plan_id' => 'int',
        'branch_expiry_date' => 'datetime',
        'branches' => 'int',
        'opted_out_at' => 'datetime',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'merchant_id',
        'branch_plan_id',
        'branch_expiry_date',
        'branches',
        'opted_out_at',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function branch_plan()
    {
        return $this->belongsTo(BranchPlan::class);
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
