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
 * Class Permission
 *
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 *
 * @property User|null $user
 * @property Collection|Role[] $roles
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Permission extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'permissions';

    protected $casts = [
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->withPivot('created_by', 'deleted_by', 'updated_by', 'deleted_at')
            ->withTimestamps();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'permission_user', 'permission_id', 'updated_by')
            ->withPivot('user_id', 'user_type', 'created_by', 'deleted_by', 'deleted_at')
            ->withTimestamps();
    }
}
