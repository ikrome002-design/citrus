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
 * Class Message
 *
 * @property int $id
 * @property int $sender_id
 * @property int $receiver_id
 * @property string $message_text
 * @property bool $message_read
 * @property string $message_type
 * @property Carbon|null $updated_at
 * @property Carbon|null $created_at
 * @property string|null $deleted_at
 * @property int|null $created_by
 * @property int|null $deleted_by
 * @property int|null $updated_by
 *
 * @property User|null $user
 *
 * @package App\Models
 */
class Message extends Model
{
    use SoftDeletes, CreatedUpdatedDeletedBy;
    protected $table = 'messages';

    protected $casts = [
        'sender_id' => 'int',
        'receiver_id' => 'int',
        'message_read' => 'bool',
        'created_by' => 'int',
        'deleted_by' => 'int',
        'updated_by' => 'int'
    ];

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message_text',
        'message_read',
        'message_type',
        'created_by',
        'deleted_by',
        'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
