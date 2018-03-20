<?php namespace System\Models;

use Model;

/**
 * MailLayouts Model Class
 * @package System
 */
class Mail_layouts_model extends Model
{
    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_updated';

    /**
     * @var string The database table name
     */
    protected $table = 'mail_templates';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'template_id';

    protected $fillable = ['name', 'language_id', 'date_added', 'date_updated', 'status'];

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    public $relation = [
        'hasMany'   => [
            'templates' => ['System\Models\Mail_templates_model', 'foreignKey' => 'template_id', 'delete' => TRUE],
        ],
        'belongsTo' => [
            'language' => 'System\Models\Languages_model',
        ],
    ];

    public static function getDropdownOptions()
    {
        return self::dropdown('name');
    }

    //
    // Scopes
    //

    /**
     * Scope a query to only include enabled mail template
     * @return $this
     */
    public function scopeIsEnabled($query)
    {
        return $query->where('status', 1);
    }
}