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
 * Class Admin
 *
 * @property int $id
 * @property int $user_id
 * @property bool $is_super_admin
 * @property string $role
 * @property bool $is_active
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
class Admin extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'admins';

    protected $casts = [
        'user_id' => 'int',
        'is_super_admin' => 'bool',
        'is_active' => 'bool',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'is_super_admin',
        'role',
        'is_active',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
