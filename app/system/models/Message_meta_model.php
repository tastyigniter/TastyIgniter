<?php namespace System\Models;

use Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Message Meta Model Class
 *
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

	protected $fillable = ['message_meta_id', 'message_id', 'messageable_id', 'messageable_type', 'state', 'status'];

	public $relation = [
	    'morphTo' => [
	        'messageable' => []
        ]
    ];

	protected $with = ['messageable'];

    public function scopeIsUnread($query)
    {
        return $query->where('state', '!=', '1');
	}
}