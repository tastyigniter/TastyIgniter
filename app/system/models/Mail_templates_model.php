<?php namespace System\Models;

use Model;

/**
 * MailTemplates Model Class
 * @package System
 */
class Mail_templates_model extends Model
{
    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_updated';

    // @todo: use original_id field instead
    public static $defaultTemplateId = 11;

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
            'templates' => ['System\Models\Mail_templates_data_model', 'foreignKey' => 'template_id', 'delete' => TRUE],
        ],
        'belongsTo' => [
            'language' => 'System\Models\Languages_model',
            'original' => 'System\Models\Mail_templates_model',
        ],
    ];

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

    //
    // Events
    //

    public function afterCreate()
    {
        if (is_null($this->original_id))
            return;

        $originalTemplate = $this->find($this->original_id);
        $this->plain_layout = $originalTemplate->plain_layout;
        $this->layout = $originalTemplate->layout;
        $this->save();

        self::updateTemplateData(
            $this->getKey(),
            $this->getAllTemplateData($originalTemplate->getKey())
        );
    }

    //
    // Helpers
    //

    public static function getDefaultTemplateData($template_code)
    {
        $template_id = setting('mail_template_id');
        $found = (new Mail_templates_data_model)->getTemplateData($template_id, $template_code);

        if (!$found)
            $template_id = self::$defaultTemplateId;

        return self::getTemplateData($template_id, $template_code);
    }

    /**
     * Find a single mail template by template id and code
     *
     * @param $template_id
     * @param $template_code
     *
     * @return mixed
     */
    public static function getTemplateData($template_id, $template_code)
    {
        if (is_numeric($template_id) AND is_string($template_code)) {
            $query = Mail_templates_data_model::leftJoin(
                'mail_templates', 'mail_templates.template_id', '=', 'mail_templates_data.template_id'
            );

            $query->where('mail_templates_data.template_id', $template_id);
            $query->where('mail_templates_data.code', $template_code);
            $query->where('mail_templates.status', '1');

            return $query->first();
        }
    }
}