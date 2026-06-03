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
 * Class ProductSubscription
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property Carbon $expiry_date
 * @property Carbon|null $opted_out_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 *
 * @package App\Models
 */
class ProductSubscription extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'product_subscriptions';

    protected $casts = [
        'user_id' => 'int',
        'product_id' => 'int',
        'expiry_date' => 'datetime',
        'opted_out_at' => 'datetime',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'product_id',
        'expiry_date',
        'opted_out_at',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
