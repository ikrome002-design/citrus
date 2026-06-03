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
 * Class Address
 *
 * @property int $id
 * @property string $street_address
 * @property int $town_id
 * @property int $user_id
 * @property bool $address_is_active
 * @property string|null $address_phone_number
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property User|null $user
 * @property Town $town
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class Address extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'addresses';

    protected $casts = [
        'town_id' => 'int',
        'user_id' => 'int',
        'address_is_active' => 'bool',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_by' => 'int'
    ];

    protected $fillable = [
        'street_address',
        'town_id',
        'user_id',
        'address_is_active',
        'address_phone_number',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
