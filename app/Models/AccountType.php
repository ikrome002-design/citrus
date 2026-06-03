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
 * Class AccountType
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property int|null $created_by
 *
 * @property User|null $user
 * @property BackOfficePlan $back_office_plan
 *
 * @package App\Models
 */
class AccountType extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'account_types';

    protected $casts = [
        'updated_by' => 'int',
        'deleted_by' => 'int',
        'created_by' => 'int'
    ];

    protected $fillable = [
        'name',
        'description',
        'updated_by',
        'deleted_by',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function back_office_plan()
    {
        return $this->hasOne(BackOfficePlan::class);
    }
}
