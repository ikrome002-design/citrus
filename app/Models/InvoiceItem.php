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
 * Class InvoiceItem
 *
 * @property int $id
 * @property int|null $invoice_id
 * @property string $description
 * @property float $price
 * @property int $quantity
 * @property float $amount
 * @property int|null $team_subscription_id
 * @property int|null $back_office_subscription_id
 * @property int|null $branch_subscription_id
 * @property int|null $product_subscription_id
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
class InvoiceItem extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'invoice_items';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'invoice_id' => 'int',
        'price' => 'float',
        'quantity' => 'int',
        'amount' => 'float',
        'team_subscription_id' => 'int',
        'back_office_subscription_id' => 'int',
        'branch_subscription_id' => 'int',
        'product_subscription_id' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'invoice_id',
        'description',
        'price',
        'quantity',
        'amount',
        'team_subscription_id',
        'back_office_subscription_id',
        'branch_subscription_id',
        'product_subscription_id',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
