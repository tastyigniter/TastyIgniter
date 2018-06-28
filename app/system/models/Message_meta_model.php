<?php namespace System\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Model;

/**
 * Message Meta Model Class
 * @package System
 */
class Message_meta_model extends Model
{
    use SoftDeletes;

    const DELETED_AT = 'date_deleted';

    /**
     * @var string The database table name
     */
    protected $table = 'message_meta';

    protected $primaryKey = 'message_meta_id';

    protected $fillable = ['message_meta_id', 'message_id', 'messagable_id', 'messagable_type', 'state', 'status'];

    public $relation = [
        'morphTo' => [
            'messagable' => [],
        ],
    ];

    protected $with = ['messagable'];

    public function scopeWhereIsUnread($query)
    {
        return $query->where('state', '!=', '1');
    }

    public function scopeWhereIsRead($query)
    {
        return $query->where('state', '1');
    }

    public function scopeWhereMessagable($query, $messagable)
    {
        return $query->where('messagable_id', $messagable->getKey())
                     ->where('messagable_type', $messagable->getMorphClass());
    }
}