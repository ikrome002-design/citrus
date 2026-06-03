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
 * Class Town
 *
 * @property int $id
 * @property int $county_id
 * @property string $name
 * @property int $shipping_zone_id
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 * @property County $county
 * @property ShippingZone $shipping_zone
 * @property Collection|Address[] $addresses
 *
 * @package App\Models
 */
class Town extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'towns';

    protected $casts = [
        'county_id' => 'int',
        'shipping_zone_id' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'county_id',
        'name',
        'shipping_zone_id',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function shipping_zone()
    {
        return $this->belongsTo(ShippingZone::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
