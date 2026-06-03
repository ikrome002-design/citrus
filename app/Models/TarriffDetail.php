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
 * Class TarriffDetail
 *
 * @property int $id
 * @property float $tarrif_from
 * @property float|null $tarrif_to
 * @property int $tarrif_id
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property Tarriff $tarriff
 * @property User|null $user
 *
 * @package App\Models
 */
class TarriffDetail extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'tarriff_details';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'tarrif_from' => 'float',
        'tarrif_to' => 'float',
        'tarrif_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'tarrif_from',
        'tarrif_to',
        'tarrif_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function tarriff()
    {
        return $this->belongsTo(Tarriff::class, 'tarrif_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
