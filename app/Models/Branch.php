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
 * Class Branch
 *
 * @property int $id
 * @property string|null $branch_title
 * @property string|null $branch_location
 * @property string|null $citrus_branch_id
 * @property int $merchant_id
 * @property string|null $branch_logo
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property bool $show_products
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 * @property Merchant $merchant
 *
 * @package App\Models
 */
class Branch extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'branches';

    protected $casts = [
        'merchant_id' => 'int',
        'show_products' => 'bool',
        'is_active' => 'bool',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'branch_title',
        'branch_location',
        'citrus_branch_id',
        'merchant_id',
        'branch_logo',
        'show_products',
        'is_active',
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
