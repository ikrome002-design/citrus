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
 * Class ShippingZone
 *
 * @property int $id
 * @property string $name
 * @property string $varies_by
 * @property int $base_weight
 * @property int $base_volume
 * @property float $extra_price_per_weight
 * @property float $extra_price_per_volume
 * @property float $free_shipping_start_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 * @property Collection|Town[] $towns
 *
 * @package App\Models
 */
class ShippingZone extends Model
{
	use SoftDeletes,CreatedUpdatedDeletedBy;
	protected $table = 'shipping_zones';

	protected $casts = [
		'base_weight' => 'int',
		'base_volume' => 'int',
		'extra_price_per_weight' => 'float',
		'extra_price_per_volume' => 'float',
		'free_shipping_start_price' => 'float',
		'created_by' => 'int',
		'deleted_by' => 'int',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'name',
		'varies_by',
		'base_weight',
		'base_volume',
		'extra_price_per_weight',
		'extra_price_per_volume',
		'free_shipping_start_price',
		'created_by',
		'deleted_by',
		'updated_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function towns()
	{
		return $this->hasMany(Town::class);
	}
}
