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
 * Class Sociallink
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $link
 * @property int $merchant_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 *
 * @property User|null $user
 * @property Merchant $merchant
 *
 * @package App\Models
 */
class Sociallink extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'sociallinks';

    protected $casts = [
        'merchant_id' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'title',
        'link',
        'merchant_id',
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
}
