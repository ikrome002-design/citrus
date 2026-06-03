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
 * Class Ticket
 *
 * @property int $id
 * @property string $ticket_no
 * @property int $user_id
 * @property string $ticket_subject
 * @property string|null $ticked_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User $user
 *
 * @package App\Models
 */
class Ticket extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'tickets';

    protected $casts = [
        'user_id' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'ticket_no',
        'user_id',
        'ticket_subject',
        'ticked_status',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
