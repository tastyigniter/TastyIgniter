<?php namespace System\Models;

use Model;

/**
 * MailTemplates Model Class
 *
 * @package System
 */
class Mail_templates_model extends Model
{
    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_updated';

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
        'hasMany' => [
            'templates' => ['System\Models\Mail_templates_data_model', 'foreignKey' => 'template_id', 'delete' => true],
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
     *
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

    /**
     * Return all mail templates
     *
     * @return array
     */
    public function getTemplates()
    {
        return $this->get();
    }

    /**
     * Find a single mail template by template_id
     *
     * @param $template_id
     *
     * @return bool
     */
    public function getTemplate($template_id)
    {
        return $this->find($template_id);
    }

    /**
     * Return all mail templates data by template_id
     *
     * @param $template_id
     *
     * @return array
     */
    public function getAllTemplateData($template_id)
    {
        $result = [];

        if ($template_id) {
            $result = Mail_templates_data_model::where('template_id', $template_id)
                                                      ->orderBy('template_data_id')->get();
        }

        return $result;
    }

    /**
     * Find the default mail template by template code
     *
     * @param $template_code
     *
     * @return mixed
     */
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

    /**
     * Create a new or update existing mail template
     *
     * @param       $template_id
     * @param array $save
     *
     * @return bool|int The $template_id of the affected row, or FALSE on failure
     */
    public function saveTemplate($template_id, $save = [])
    {
        if (empty($save)) return FALSE;

        $templateModel = $this->findOrNew($template_id);

        $saved = $templateModel->fill($save)->save();

        return $saved ? $templateModel->getKey() : $saved;
    }

    /**
     * Create a new or update existing mail template data
     *
     * @param       $template_id
     * @param array $templates
     *
     * @return bool TRUE on success, or FALSE on failure
     */
    public static function updateTemplateData($template_id, $templates = [])
    {
        return Mail_templates_data_model::updateTemplateData($template_id, $templates);
    }

    /**
     * Delete a single or multiple mail template by template_id
     *
     * @param $template_id
     *
     * @return int The number of deleted rows
     */
    public function deleteTemplate($template_id)
    {
        if (is_numeric($template_id)) $template_id = [$template_id];

        foreach ($template_id as $key => $value) {
            if ($value == setting('mail_template_id')) {
                unset($template_id[$key]);
            }
        }

        if (!empty($template_id) AND ctype_digit(implode('', $template_id))) {
            return $this->where('template_id', '!=', '11')->whereIn('template_id', $template_id)->delete();
        }
    }
}