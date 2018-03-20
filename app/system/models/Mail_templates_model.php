<?php namespace System\Models;

use File;
use Igniter\Flame\Support\StringParser;
use Illuminate\Mail\Markdown;
use Model;
use October\Rain\Mail\MailParser;
use System\Classes\ExtensionManager;
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
    protected $table = 'mail_templates_data';

    protected $primaryKey = 'template_data_id';

    protected $fillable = ['template_id', 'code', 'label', 'subject', 'body', 'plain_body'];

    public $relation = [
        'belongsTo' => [
            'layout' => ['System\Models\Mail_layouts_model', 'foreignKey' => 'template_id'],
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

    /**
     * @var array A cache of templates.
     */
    protected static $templateCache = [];

    /**
     * @var array Cache of registration callbacks.
     */
    protected static $callbacks = [];

    protected static $registeredTemplates;

    public function afterFetch()
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
        return $query->where('template_id', Mail_layouts_model::$defaultTemplateId);
    }

    //
    // Helpers
    //

    public function fillFromView()
    {
        $sections = self::getTemplateSections($this->code);
        $this->subject = array_get($sections, 'settings.subject', 'No subject');
        $this->body = $sections['html'];
        $this->plain_body = $sections['text'];
    }

    /**
     * Synchronise all templates to the database.
     * @return void
     */
    public static function syncAll()
    {
        $templates = (array)(new static)->listRegisteredTemplates();
        $dbTemplates = self::lists('is_custom', 'code')->toArray();
        $newTemplates = array_diff_key($templates, $dbTemplates);

        // Clean up non-customized templates
        foreach ($dbTemplates as $code => $is_custom) {
            if ($is_custom)
                continue;

//            if (!array_key_exists($code, $templates))
//                self::whereCode($code)->delete();
        }

        // Create new templates
        foreach ($newTemplates as $name => $label) {
            $templateModel = self::make();
            $templateModel->code = $name;
            $templateModel->label = $label;
            $templateModel->is_custom = 0;
            $templateModel->save();

//            $templateModel->subject = $template->subject;
//            $templateSections = explode("\n==\n", $template->body, 2);
//            $templateModel->body = trim($templateSections[0]);
//            $templateModel->plain_body = isset($templateSections[1]) ? trim($templateSections[1]) : null;
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

    public static function addContentToMailer($message, $code, $data)
    {
        if (isset(self::$templateCache[$code])) {
            $template = self::$templateCache[$code];
        }
        else {
            self::$templateCache[$code] = $template = self::findOrMakeTemplate($code);
        }

        $stringParser = new StringParser;

        // Subject
        $customSubject = $message->getSwiftMessage()->getSubject();
        if (empty($customSubject)) {
            $message->subject($stringParser->parse(Markdown::parse($template->subject), $data));
        }

        // HTML contents
        $html = $stringParser->parse(Markdown::parse($template->body), $data);
        if ($template->layout AND strlen($template->layout->layout)) {
            $html = $stringParser->parse(Markdown::parse($template->layout->layout), [
                    'content' => $html,
                    'css'     => $template->layout->custom_css,
                ] + (array)$data);
        }

        $message->setBody($html, 'text/html');

        // Text contents
        if (strlen($template->plain_body)) {
            $text = $stringParser->parse(Markdown::parse($template->plain_body), $data);
            if ($template->layout AND strlen($template->layout->plain_layout)) {
                $text = $template->layout->parsePlain($text, $data);
                $text = $stringParser->parse(Markdown::parse($template->layout->plain_layout), [
                        'content' => $text,
                    ] + (array)$data);
            }

            $message->addPart($text, 'text/plain');
        }
    }

    public static function listAllTemplates()
    {
        $registeredTemplates = (array)(new static)->listRegisteredTemplates();
        $dbTemplates = (array)self::isDefault()->get()->keyBy('code')->all();
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
    public function listRegisteredTemplates()
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

        foreach ($definitions as $view => $label) {
            if (!is_string($view))
                $view = $label;

            static::$registeredTemplates[$view] = $label;
        }
    }

    /**
     * Registers a callback function that defines templates.
     * The callback function should register templates by calling the manager's
     * registerTemplates() function. This instance is passed to the
     * callback function as an argument. Usage:
     * <pre>
     *   Mail_templates_model::registerCallback(function($template){
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