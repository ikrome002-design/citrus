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
 * Class Merchant
 *
 * @property int $id
 * @property int $user_id
 * @property Carbon|null $approved_at
 * @property bool $is_active
 * @property string $business_name
 * @property string|null $business_location
 * @property string $business_email
 * @property int $business_type_id
 * @property string|null $business_role
 * @property string|null $business_about
 * @property string|null $business_logo
 * @property string $citrus_merchant_id
 * @property float $balance
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted_by
 *
 * @property User $user
 * @property BusinessType $business_type
 * @property BackOfficeSubscription $back_office_subscription
 * @property Collection|BranchSubscription[] $branch_subscriptions
 * @property Collection|Branch[] $branches
 * @property MerchantBalanceTransaction $merchant_balance_transaction
 * @property Collection|Product[] $products
 * @property Collection|Sociallink[] $sociallinks
 * @property TeamSubscription $team_subscription
 *
 * @package App\Models
 */
class Merchant extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'merchants';

    protected $casts = [
        'user_id' => 'int',
        'approved_at' => 'datetime',
        'is_active' => 'bool',
        'business_type_id' => 'int',
        'balance' => 'float',
        'created_by' => 'int',
        'updated_by' => 'int',
        'deleted_by' => 'int'
    ];

    protected $fillable = [
        'user_id',
        'approved_at',
        'is_active',
        'business_name',
        'business_location',
        'business_email',
        'business_type_id',
        'business_role',
        'business_about',
        'business_logo',
        'citrus_merchant_id',
        'balance',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business_type()
    {
        return $this->belongsTo(BusinessType::class);
    }

    public function back_office_subscription()
    {
        return $this->hasOne(BackOfficeSubscription::class);
    }

    public function branch_subscriptions()
    {
        return $this->hasMany(BranchSubscription::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function merchant_balance_transaction()
    {
        return $this->hasOne(MerchantBalanceTransaction::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function sociallinks()
    {
        return $this->hasMany(Sociallink::class);
    }

    public function team_subscription()
    {
        return $this->hasOne(TeamSubscription::class);
    }
}
