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
 * Class PermissionUser
 *
 * @property int $permission_id
 * @property int $user_id
 * @property string $user_type
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property User|null $user
 * @property Permission $permission
 *
 * @package App\Models
 */
class PermissionUser extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'permission_user';
    public $incrementing = false;

    protected $casts = [
        'permission_id' => 'int',
        'user_id' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
