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
 * Class ProductRating
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $product_id
 * @property int $rating
 * @property string $review
 * @property string|null $image
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 * @property string|null $deleted_at
 *
 * @property User $user
 * @property Product|null $product
 *
 * @package App\Models
 */
class ProductRating extends Model
{
	use SoftDeletes, CreatedUpdatedDeletedBy;
	protected $table = 'product_ratings';

	protected $casts = [
		'user_id' => 'int',
		'product_id' => 'int',
		'rating' => 'int',
		'status' => 'int',
		'created_by' => 'int',
		'deleted_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'user_id',
		'product_id',
		'rating',
		'review',
		'image',
		'status',
		'created_by',
		'deleted_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
