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

    public function getVariablesAttribute($value)
    {
        return [
            'General' => [
                ['var' => '{site_name}', 'name' => 'Site name'],
                ['var' => '{site_logo}', 'name' => 'Site logo'],
                ['var' => '{site_url}', 'name' => 'Site URL'],
                ['var' => '{signature}', 'name' => 'Signature'],
                ['var' => '{location_name}', 'name' => 'Location name'],
            ],
            'Customer' => [
                ['var' => '{first_name}', 'name' => 'Customer first name'],
                ['var' => '{last_name}', 'name' => 'Customer last name'],
                ['var' => '{email}', 'name' => 'Customer email address'],
                ['var' => '{telephone}', 'name' => 'Customer telephone address'],
            ],
            'Staff' => [
                ['var' => '{staff_name}', 'name' => 'Staff name'],
                ['var' => '{staff_username}', 'name' => 'Staff username'],
            ],
            'Registration/Reset' => [
                ['var' => '{account_login_link}', 'name' => 'Account login link'],
                ['var' => '{reset_password}', 'name' => 'Created password on password reset'],
            ],
            'Order' => [
                ['var' => '{customer_name}', 'name' => 'Customer full name'],
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
            'Reservation' => [
                ['var' => '{reservation_number}', 'name' => 'Reservation number'],
                ['var' => '{reservation_view_url}', 'name' => 'Reservation view URL'],
                ['var' => '{reservation_date}', 'name' => 'Reservation date'],
                ['var' => '{reservation_time}', 'name' => 'Reservation time'],
                ['var' => '{reservation_guest_no}', 'name' => 'No. of guest reserved'],
                ['var' => '{reservation_comment}', 'name' => 'Reservation comment'],
            ],
            'Status' => [
                ['var' => '{status_name}', 'name' => 'Status name'],
                ['var' => '{status_comment}', 'name' => 'Status comment'],
            ],
            'Contact' => [
                ['var' => '{full_name}', 'name' => 'Customer full name'],
                ['var' => '{contact_topic}', 'name' => 'Contact topic'],
                ['var' => '{contact_telephone}', 'name' => 'Contact telephone'],
                ['var' => '{contact_message}', 'name' => 'Contact message body'],
            ],
        ];
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
