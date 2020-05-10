<?php namespace System\Models;

use File;
use Igniter\Flame\Mail\MailParser;
use Model;
use System\Classes\MailManager;
use View;

/**
 * Mail templates Model Class
 * @package System
 */
class Mail_templates_model extends Model
{
    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_updated';

    /**
     * @var string The database table name
     */
    protected $table = 'mail_templates';

    protected $primaryKey = 'template_id';

    protected $guarded = [];

    public $casts = [
        'layout_id' => 'integer',
    ];

    public $relation = [
        'belongsTo' => [
            'layout' => ['System\Models\Mail_layouts_model', 'foreignKey' => 'layout_id'],
        ],
    ];

    protected $appends = ['title'];

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    protected function afterFetch()
    {
        if (!$this->is_custom) {
            $this->fillFromView();
        }
    }

    //
    // Accessors & Mutators
    //

    public function getTitleAttribute($value)
    {
        $langLabel = !empty($this->attributes['label']) ? $this->attributes['label'] : '';

        return is_lang_key($langLabel) ? lang($langLabel) : $langLabel;
    }

    //
    // Helpers
    //

    public function fillFromContent($content)
    {
        $this->fillFromSections(MailParser::parse($content));
    }

    public function fillFromView()
    {
        $this->fillFromSections(self::getTemplateSections($this->code));
    }

    protected function fillFromSections(array $sections)
    {
        $this->subject = array_get($sections, 'settings.subject', 'No subject');
        $this->body = array_get($sections, 'html');
        $this->plain_body = array_get($sections, 'text');

        $layoutCode = array_get($sections, 'settings.layout', 'default');
        $this->layout_id = Mail_layouts_model::getIdFromCode($layoutCode);
    }

    /**
     * Synchronise all templates to the database.
     * @return void
     */
    public static function syncAll()
    {
        Mail_layouts_model::createLayouts();
        Mail_partials_model::createPartials();

        $templates = (array)MailManager::instance()->listRegisteredTemplates();
        $dbTemplates = self::lists('is_custom', 'code')->all();
        $newTemplates = array_diff_key($templates, $dbTemplates);

        // Clean up non-customized templates
        foreach ($dbTemplates as $code => $is_custom) {
            if ($is_custom)
                continue;

            if (!array_key_exists($code, $templates))
                self::whereCode($code)->delete();
        }

        // Create new templates
        foreach ($newTemplates as $name => $label) {
            $sections = self::getTemplateSections($name);
            $layoutCode = array_get($sections, 'settings.layout', 'default');

            $templateModel = self::make();
            $templateModel->code = $name;
            $templateModel->label = $label;
            $templateModel->is_custom = 0;
            $templateModel->layout_id = Mail_layouts_model::getIdFromCode($layoutCode);
            $templateModel->save();
        }
    }

    public static function findOrMakeTemplate($code)
    {
        if (!$template = self::whereCode($code)->first()) {
            $template = new self;
            $template->code = $code;
            $template->fillFromView();
        }

        return $template;
    }

    public static function listAllTemplates()
    {
        $registeredTemplates = (array)MailManager::instance()->listRegisteredTemplates();
        $dbTemplates = (array)self::lists('code', 'code');
        $templates = $registeredTemplates + $dbTemplates;
        ksort($templates);

        return $templates;
    }

    protected static function getTemplateSections($code)
    {
        return MailParser::parse(File::get(View::make($code)->getPath()));
    }

    //
    // Registration
    //

    /**
     * @param callable $callback A callable function.
     * @deprecated see System\Classes\MailManager::registerCallback
     *
     */
    public static function registerCallback(callable $callback)
    {
        traceLog('Mail_templates_model::registerCallback is deprecated, use '.MailManager::class.'::registerCallback instead');
        MailManager::instance()->registerCallback($callback);
    }
}
