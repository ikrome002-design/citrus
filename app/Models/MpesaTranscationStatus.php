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
 * Class MpesaTranscationStatus
 *
 * @property int $id
 * @property string|null $OriginatorConversationID
 * @property string|null $ConversationID
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @property User|null $user
 *
 * @package App\Models
 */
class MpesaTranscationStatus extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'mpesa_transcation_status';
    public $incrementing = false;

    protected $casts = [
        'id' => 'int',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'id',
        'OriginatorConversationID',
        'ConversationID',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
