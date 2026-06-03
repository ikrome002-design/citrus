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
 * Class BusinessType
 *
 * @property int $id
 * @property string|null $title
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 * @property Collection|Merchant[] $merchants
 *
 * @package App\Models
 */
class BusinessType extends Model
{
	use SoftDeletes,CreatedUpdatedDeletedBy;
	protected $table = 'business_types';

	protected $casts = [
		'created_by' => 'int',
		'deleted_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'title',
		'created_by',
		'deleted_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function merchants()
	{
		return $this->hasMany(Merchant::class);
	}
}
