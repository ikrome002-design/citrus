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
 * Class Blog
 *
 * @property int $id
 * @property bool $is_active
 * @property string|null $title
 * @property string $description
 * @property string|null $content
 * @property string|null $slug
 * @property string|null $image
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
class Blog extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'blogs';

    protected $casts = [
        'is_active' => 'bool',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'is_active',
        'title',
        'description',
        'content',
        'slug',
        'image',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
