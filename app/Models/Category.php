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
 * Class Category
 *
 * @property int $id
 * @property bool $is_active
 * @property string $name
 * @property string $slug
 * @property string|null $description
 * @property string|null $image
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $parent_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 * @property string|null $deleted_at
 *
 * @property User|null $user
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Category extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'categories';

    protected $casts = [
        'is_active' => 'bool',
        'status' => 'int',
        'parent_id' => 'int',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_by' => 'int'
    ];

    protected $fillable = [
        'is_active',
        'name',
        'slug',
        'description',
        'image',
        'status',
        'parent_id',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
