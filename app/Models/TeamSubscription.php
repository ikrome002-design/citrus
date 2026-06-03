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
 * Class TeamSubscription
 *
 * @property int $id
 * @property int $merchant_id
 * @property int $team_plan_id
 * @property Carbon|null $expiry_date
 * @property int $members
 * @property Carbon|null $opted_out_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 * @property Merchant $merchant
 * @property TeamPlan $team_plan
 *
 * @package App\Models
 */
class TeamSubscription extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'team_subscriptions';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'merchant_id' => 'int',
        'team_plan_id' => 'int',
        'expiry_date' => 'datetime',
        'members' => 'int',
        'opted_out_at' => 'datetime',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'merchant_id',
        'team_plan_id',
        'expiry_date',
        'members',
        'opted_out_at',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function team_plan()
    {
        return $this->belongsTo(TeamPlan::class);
    }
}
