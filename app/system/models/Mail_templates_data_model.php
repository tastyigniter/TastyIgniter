<?php namespace System\Models;

use Model;
use Modules;
use System\Classes\ExtensionManager;

/**
 * Mail template data Model Class
 *
 * @package System
 */
class Mail_templates_data_model extends Model
{
    const CREATED_AT = 'date_added';

    const UPDATED_AT = 'date_updated';

    /**
     * @var string The database table name
     */
    protected $table = 'mail_templates_data';

    protected $primaryKey = 'template_data_id';

    protected $fillable = ['template_id', 'code', 'label', 'subject', 'body', 'plain_body'];

    public $relation = [
        'belongsTo' => [
            'template' => 'System\Models\Mail_templates_model'
        ],
    ];

    protected $appends = ['title'];

    /**
     * @var array The model table column to convert to dates on insert/update
     */
    public $timestamps = TRUE;

    protected static $defaultTemplateCodes = [
        'registration',
        'registration_alert',
        'password_reset_request',
        'password_reset_request_alert',
        'password_reset',
        'password_reset_alert',
        'order',
        'order_alert',
        'order_update',
        'reservation',
        'reservation_alert',
        'reservation_update',
        'internal',
        'contact',
    ];

    protected static $templateDefaults = [
        'code'    => null,
        'label'   => null,
        'subject' => null,
        'body'    => '',
    ];

    /**
     * @var array A cache of templates.
     */
    protected static $templateCache = [];

    /**
     * @var array Cache of registration callbacks.
     */
    private static $callbacks = [];

    protected static $registeredTemplates;

    //
    // Accessors & Mutators
    //

    public function getTitleAttribute($value)
    {
        $langLabel = !empty($this->attributes['label']) ? $this->attributes['label'] : '';

        return (sscanf($langLabel, 'lang:%s', $lang) === 1) ? lang($langLabel) : $langLabel;
    }

    public function getBodyAttribute($value)
    {
        return html_entity_decode($value);
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = trim(preg_replace('~>\s+<~m', '><', $value));
    }

    public function getVariablesAttribute($value)
    {
        return [
            'General'            => [
                ['var' => '{site_name}', 'name' => 'Site name'],
                ['var' => '{site_logo}', 'name' => 'Site logo'],
                ['var' => '{site_url}', 'name' => 'Site URL'],
                ['var' => '{signature}', 'name' => 'Signature'],
                ['var' => '{location_name}', 'name' => 'Location name'],
            ],
            'Customer'           => [
                ['var' => '{full_name}', 'name' => 'Customer full name'],
                ['var' => '{first_name}', 'name' => 'Customer first name'],
                ['var' => '{last_name}', 'name' => 'Customer last name'],
                ['var' => '{email}', 'name' => 'Customer email address'],
                ['var' => '{telephone}', 'name' => 'Customer telephone address'],
            ],
            'Staff'              => [
                ['var' => '{staff_name}', 'name' => 'Staff name'],
                ['var' => '{staff_username}', 'name' => 'Staff username'],
            ],
            'Registration/Reset' => [
                ['var' => '{account_login_link}', 'name' => 'Account login link'],
                ['var' => '{reset_password}', 'name' => 'Created password on password reset'],
            ],
            'Order'              => [
                ['var' => '{order_number}', 'name' => 'Order number'],
                ['var' => '{order_view_url}', 'name' => 'Order view URL'],
                ['var' => '{order_type}', 'name' => 'Order type ex. delivery/pick-up'],
                ['var' => '{order_time}', 'name' => 'Order delivery/pick-up time'],
                ['var' => '{order_date}', 'name' => 'Order delivery/pick-up date'],
                ['var' => '{order_address}', 'name' => 'Customer address for delivery order'],
                ['var' => '{order_payment}', 'name' => 'Order payment method'],
                ['var' => '{order_menus}', 'name' => 'Order menus  - START iteration'],
                ['var' => '{menu_name}', 'name' => 'Order menu name'],
                ['var' => '{menu_quantity}', 'name' => 'Order menu quantity'],
                ['var' => '{menu_price}', 'name' => 'Order menu price'],
                ['var' => '{menu_subtotal}', 'name' => 'Order menu subtotal'],
                ['var' => '{menu_options}', 'name' => 'Order menu option ex. name: price'],
                ['var' => '{menu_comment}', 'name' => 'Order menu comment'],
                ['var' => '{/order_menus}', 'name' => 'Order menus  - END iteration'],
                ['var' => '{order_totals}', 'name' => 'Order total pairs - START iteration'],
                ['var' => '{order_total_title}', 'name' => 'Order total title'],
                ['var' => '{order_total_value}', 'name' => 'Order total value'],
                ['var' => '{/order_totals}', 'name' => 'Order total pairs - END iteration'],
                ['var' => '{order_comment}', 'name' => 'Order comment'],
            ],
            'Reservation'        => [
                ['var' => '{reservation_number}', 'name' => 'Reservation number'],
                ['var' => '{reservation_view_url}', 'name' => 'Reservation view URL'],
                ['var' => '{reservation_date}', 'name' => 'Reservation date'],
                ['var' => '{reservation_time}', 'name' => 'Reservation time'],
                ['var' => '{reservation_guest_no}', 'name' => 'No. of guest reserved'],
                ['var' => '{reservation_comment}', 'name' => 'Reservation comment'],
            ],
            'Status'             => [
                ['var' => '{status_name}', 'name' => 'Status name'],
                ['var' => '{status_comment}', 'name' => 'Status comment'],
            ],
            'Contact'            => [
                ['var' => '{contact_topic}', 'name' => 'Contact topic'],
                ['var' => '{contact_telephone}', 'name' => 'Contact telephone'],
                ['var' => '{contact_message}', 'name' => 'Contact message body'],
            ],
        ];
    }

    //
    // Scopes
    //

    public function scopeIsDefault($query)
    {
        return $query->where('template_id', Mail_templates_model::$defaultTemplateId);
    }

    //
    // Helpers
    //

    public function formatDateTime($value)
    {
        return mdate('%d %M %y - %H:%i', strtotime($value));
    }

    public static function listAllTemplates()
    {
        $registeredTemplates = (array)(new static)->listRegisteredTemplates();
        $dbTemplates = (array)self::isDefault()->get()->keyBy('code')->all();
        $templates = $registeredTemplates + $dbTemplates;
        ksort($templates);

        return $templates;
    }

    /**
     * Find a single mail template by template id and code
     *
     * @param $template_id
     * @param $template_code
     *
     * @return mixed
     */
    public function getTemplateData($template_id, $template_code)
    {
        if (is_numeric($template_id) AND is_string($template_code)) {
            $query = $this->where('mail_templates.template_id', $template_id)
                          ->leftJoin('mail_templates', 'mail_templates.template_id', '=', 'mail_templates_data.template_id')
                          ->where('code', $template_code)
                          ->where('mail_templates.status', '1');

            return $query->first();
        }
    }

    /**
     * Fetch changes from the system default mail template
     * used to update cloned mail templates
     *
     * @param int $templateId
     *
     * @return array|bool array on success, FALSE on failure
     */
    public static function fetchChanges($templateId)
    {
        $mailChanges = [];

        $template = Mail_templates_model::find($templateId);

        if (!is_numeric($templateId) OR is_null($template->original_id))
            return FALSE;

        $templates = self::where('template_id', $templateId)->get();
        $parentTemplates = self::where('template_id', $template->original_id)->get();
        if (!$templates AND !$parentTemplates)
            return FALSE;

        $templates->keyBy('code');
        $parentTemplates->keyBy('code');

        if ($parentTemplates AND $newTemplates = $parentTemplates->diffKeys($templates)->all())
            $mailChanges['new'] = $newTemplates;

        if ($templates AND $deletedTemplates = $templates->diffKeys($parentTemplates)->all())
            $mailChanges['deleted'] = $deletedTemplates;

        $modifiedTemplates = $parentTemplates->reject(function($model, $key) use ($templates) {
            $template = $templates->get($key);
            return (!$template OR !self::compareTemplateData($model, $template));
        })->all();

        if ($modifiedTemplates)
            $mailChanges['modified'] = $modifiedTemplates;

        return $mailChanges;
    }

    /**
     * Check difference in two template data
     *
     * @param $one
     * @param $two
     *
     * @return bool
     */
    public static function compareTemplateData($one, $two)
    {
        if ($one->template_id == $two->template_id)
            return FALSE;

        if (strtotime($two->date_updated) > strtotime($one->date_updated))
            return FALSE;

        return (strtotime($one->date_updated) > strtotime($two->date_added));
    }

    /**
     * Update changes from the system default mail templates
     *
     * @param $template_id
     * @param $update
     *
     * @return bool
     */
    public static function updateChanges($template_id, $changes)
    {
        if (!count($changes)) return FALSE;

        $templatesToUpdate = $templatesToDelete = [];
        foreach ($changes as $type => $templateIds) {
            foreach ($templateIds as $template_data_id) {
                if (!is_numeric($template_data_id) OR !$template = self::find($template_data_id))
                    continue;

                if ($type == 'deleted') {
                    $templatesToDelete[] = self::destroy($template_data_id);
                } else {
                    $templatesToUpdate[] = $template->toArray();
                }
            }
        }

        self::updateTemplateData($template_id, $templatesToUpdate);

        return count($templatesToUpdate) OR count($templatesToDelete);
    }

    /**
     * Synchronise all templates to the database.
     * @return void
     */
    public static function syncAll()
    {
        $templates = (array)(new static)->listRegisteredTemplates();
        $dbTemplates = self::isDefault()->lists('template_id', 'code')->toArray();
        $newTemplates = array_diff_key($templates, $dbTemplates);

        // Clean up templates
        foreach ($dbTemplates as $name => $status) {
            if (in_array($name, self::$defaultTemplateCodes))
                continue;

            if (!array_key_exists($name, $templates)) {
                self::whereCode($name)->delete();
            }
        }

        // Create new templates
        foreach ($newTemplates as $name => $template) {
            $templateModel = self::make();
            $templateModel->template_id = Mail_templates_model::$defaultTemplateId;
            $templateModel->code = $template->code;
            $templateModel->label = $template->label;
            $templateModel->subject = $template->subject;

            $templateSections = explode("\n==\n", $template->body, 2);
            $templateModel->body = trim($templateSections[0]);
            $templateModel->plain_body = isset($templateSections[1]) ? trim($templateSections[1]) : null;
            $templateModel->save();
        }
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
        $query = FALSE;

        if (empty($template_id) OR empty($templates)) return FALSE;

        foreach ($templates as $template) {
            $templateDataModel = self::firstOrNew(['template_id' => $template_id, 'code' => $template['code']]);

            $query = $templateDataModel->fill(array_merge($template, [
                'template_id' => $template_id,
                'code'        => $template['code'],
                'body'        => trim($template['body']),
            ]))->save();
        }

        return $query;
    }

    /**
     * Add extension registered mail templates
     *
     * @param array $mailTemplates
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function addMailTemplateData($mailTemplates)
    {
        if (!is_array($mailTemplates))
            return FALSE;

        $this->load->model('Mail_templates_model');
        $defaultTemplateId = Mail_templates_model::$defaultTemplateId;

        foreach ($mailTemplates as $mailPath => $mailTemplate) {
            if (!is_string($mailPath) OR count($path = pathinfo($mailPath)) < 3) continue;

            $templateDataModel = $this->firstOrNew(['template_id' => $defaultTemplateId, 'code' => $mailPath]);

            $templateDataModel->fill([
                'label'   => $mailTemplate['label'],
                'subject' => $mailTemplate['subject'],
                'body'    => $this->load->view($mailPath),
            ])->save();
        }

        return TRUE;
    }

    /**
     * Delete extension registered mail templates
     *
     * @param array $mailTemplates
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function removeMailTemplateData($mailTemplates)
    {
        if (!is_array($mailTemplates))
            return FALSE;

        $this->load->model('Mail_templates_model');
        $defaultTemplateId = Mail_templates_model::$defaultTemplateId;

        foreach ($mailTemplates as $mailPath => $mailTemplate) {
            if (!is_string($mailPath)) continue;

            $this->where('template_id', $defaultTemplateId)
                 ->where('code', $mailPath)->delete();
        }

        return TRUE;
    }

    //
    // Registration
    //

    /**
     * Loads registered templates from extensions
     * @return void
     */
    public function loadRegisteredTemplates()
    {
        foreach (static::$callbacks as $callback) {
            $callback($this);
        }

        $extensions = ExtensionManager::instance()->getExtensions();
        foreach ($extensions as $extensionId => $extensionObj) {
            $templates = $extensionObj->registerMailTemplates();
            if (!is_array($templates)) {
                continue;
            }

            $this->registerTemplates($templates);
        }
    }

    /**
     * Returns a list of the registered templates.
     * @return array
     */
    public  function listRegisteredTemplates()
    {
        if (self::$registeredTemplates === null) {
            $this->loadRegisteredTemplates();
        }

        return self::$registeredTemplates;
    }

    /**
     * Registers templates.
     */
    public function registerTemplates(array $definitions)
    {
        if (!static::$registeredTemplates) {
            static::$registeredTemplates = [];
        }

        foreach ($definitions as $view => $definition) {
            $template = (object)array_merge(self::$templateDefaults, array_merge($definition, [
                'code'    => $view,
                'label'   => $definition['label'],
                'subject' => $definition['subject'],
//                'body'    => View::make($view, [], TRUE),
                'body'    => '',
            ]));

            static::$registeredTemplates[$template->code] = $template;
        }
    }

    /**
     * Registers a callback function that defines templates.
     * The callback function should register templates by calling the manager's
     * registerTemplates() function. This instance is passed to the
     * callback function as an argument. Usage:
     * <pre>
     *   Mail_templates_data_model::registerCallback(function($template){
     *       $template->registerTemplates([...]);
     *   });
     * </pre>
     *
     * @param callable $callback A callable function.
     */
    public static function registerCallback(callable $callback)
    {
        self::$callbacks[] = $callback;
    }

}