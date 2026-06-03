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
 * Class RecentlyViewedProduct
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $cart_details
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @package App\Models
 */
class RecentlyViewedProduct extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'recently_viewed_products';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'user_id' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'user_id',
        'cart_details',
        'created_by',
        'deleted_by',
        'updated_by'
    ];
}
