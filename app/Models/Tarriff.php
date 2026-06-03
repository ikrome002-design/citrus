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
 * Class Tarriff
 *
 * @property int $id
 * @property string $name
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property User|null $user
 * @property TarriffDetail $tarriff_detail
 *
 * @package App\Models
 */
class Tarriff extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'tarriffs';

    protected $casts = [
        'is_active' => 'bool',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_by' => 'int'
    ];

    protected $fillable = [
        'name',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function tarriff_detail()
    {
        return $this->hasOne(TarriffDetail::class, 'tarrif_id');
    }
}
