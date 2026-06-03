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
 * Class OrderStatusTimeline
 *
 * @property int $id
 * @property int $order_id
 * @property string $status
 * @property Carbon $status_date
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property User|null $user
 * @property Order $order
 *
 * @package App\Models
 */
class OrderStatusTimeline extends Model
{
	use SoftDeletes, CreatedUpdatedDeletedBy;
	protected $table = 'order_status_timelines';

	protected $casts = [
		'order_id' => 'int',
		'status_date' => 'datetime',
		'created_by' => 'int',
		'updated_by' => 'int',
		'deleted_by' => 'int'
	];

	protected $fillable = [
		'order_id',
		'status',
		'status_date',
		'created_by',
		'updated_by',
		'deleted_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
