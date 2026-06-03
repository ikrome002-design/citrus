<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\CreatedUpdatedDeletedBy;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Courier
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class Courier extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'couriers';

    protected $casts = [
        'is_active' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
