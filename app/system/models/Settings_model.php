<?php namespace System\Models;

use Carbon\Carbon;
use Config;
use DateTime;
use DateTimeZone;
use Model;
use Session;
use Setting;
use System\Classes\ExtensionManager;
use System\Traits\ConfigMaker;

/**
 * Settings Model Class
 * @package System
 */
class Settings_model extends Model
{
    use ConfigMaker;

    /**
     * @var string The database table name
     */
    protected $table = 'settings';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'setting_id';

    protected $settingsFields = 'settings_model';

    protected $fieldConfig;

    protected $fieldValues;

    protected $allItems;

    protected $items;

    public static function listMenuSettingItems($menu, $item, $user)
    {
        $fieldConfig = (new static)->getFieldConfig();
        $settingsConfig = array_except($fieldConfig, 'toolbar');

        $options = [];
        foreach ($settingsConfig as $settingItem) {
            $options[$settingItem['label']] = [$settingItem['icon'], $settingItem['url']];
        }

        return $options;
    }

    public static function getDateFormatOptions()
    {
        $now = Carbon::now();

        return [
            'd m Y' => $now->format('d m Y'),
            'm d Y' => $now->format('m d Y'),
            'Y m d' => $now->format('Y m d'),
            'd/m/Y' => $now->format('d/m/Y'),
            'm/d/Y' => $now->format('m/d/Y'),
            'Y/m/d' => $now->format('Y/m/d'),
            'd-m-Y' => $now->format('d-m-Y'),
            'm-d-Y' => $now->format('m-d-Y'),
            'Y-m-d' => $now->format('Y-m-d'),
        ];
    }

    public static function getTimeFormatOptions()
    {
        $now = Carbon::now();

        return [
            'h:i A' => $now->format('h:i A'),
            'h:i a' => $now->format('h:i a'),
            'H:i' => $now->format('H:i'),
        ];
    }

    public static function getPageLimitOptions()
    {
        return [
            '10' => '10',
            '20' => '20',
            '50' => '50',
            '75' => '75',
            '100' => '100',
        ];
    }

    public static function onboardingIsComplete()
    {
        if (!Session::has('settings.errors'))
            return FALSE;

        return count(array_filter((array)Session::get('settings.errors'))) === 0;
    }

    public function getValueAttribute()
    {
        return ($value = @unserialize($this->attributes['value']))
            ? $value
            : $this->attributes['value'];
    }

    //
    // Registration
    //

    public function getFieldConfig()
    {
        if ($this->fieldConfig !== null) {
            return $this->fieldConfig;
        }

        $this->configPath = '~/app/system/models/config';
        $config = $this->makeConfig($this->settingsFields, ['form']);

        return $this->fieldConfig = $config['form'] ?? [];
    }

    public function getFieldValues()
    {
        if (is_array($this->fieldValues))
            return $this->fieldValues;

        $values = [];
        $records = $this->newQuery()->where('sort', 'config')->get();
        foreach ($records as $record) {
            $values[$record->item] = $record->value;
        }

        return $this->fieldValues = $values;
    }

    public function getSettingDefinitions($code)
    {
        $fieldConfig = $this->getFieldConfig();

        return $fieldConfig[$code] ?? [];
    }

    public function getSettingItem($code)
    {
        if (!$this->allItems)
            $this->loadSettingItems();

        return $this->allItems[$code] ?? null;
    }

    public function listSettingItems()
    {
        if (!$this->items)
            $this->loadSettingItems();

        return $this->items;
    }

    public function loadSettingItems()
    {
        $fieldConfig = $this->getFieldConfig();
        $settingsConfig = array_except($fieldConfig, 'toolbar');
        $this->registerSettingItems('core', $settingsConfig);

        // Load plugin items
        $extensions = ExtensionManager::instance()->getExtensions();

        foreach ($extensions as $code => $extension) {
            $items = $extension->registerSettings();
            if (!is_array($items)) {
                continue;
            }

            $this->registerSettingItems($code, $items);
        }

        usort($this->items, function ($a, $b) {
            return $a->priority - $b->priority;
        });

        $allItems = [];
        $catItems = ['core' => [], 'other' => []];
        foreach ($this->items as $item) {
            $category = ($item->owner != 'core') ? 'other' : $item->owner;
            $catItems[$category][] = $item;

            $allItems[$item->owner.'.'.$item->code] = $item;
        }

        $this->allItems = $allItems;
        $this->items = $catItems;
    }

    public function registerSettingItems($owner, array $definitions)
    {
        if (!$this->items) {
            $this->items = [];
        }

        $defaultDefinitions = [
            'code' => null,
            'label' => null,
            'description' => null,
            'icon' => null,
            'url' => null,
            'priority' => null,
            'permissions' => [],
            'context' => 'settings',
            'model' => null,
            'form' => null,
        ];

        foreach ($definitions as $code => $definition) {
            $item = array_merge($defaultDefinitions, array_merge($definition, [
                'code' => $code,
                'owner' => $owner,
            ]));

            if (!isset($item['url']))
                $item['url'] = admin_url($owner == 'core'
                    ? 'settings/edit/'.$code
                    : 'extensions/edit/'.str_replace('.', '/', $owner).'/'.$code
                );

            $this->items[] = (object)$item;
        }
    }

    //
    // Mailer Config
    //

    public static function applyMailerConfigValues()
    {
        Config::set('mail.driver', Setting::get('protocol', Config::get('mail.driver')));
        Config::set('mail.host', Setting::get('smtp_host', Config::get('mail.host')));
        Config::set('mail.port', Setting::get('smtp_port', Config::get('mail.port')));
        Config::set('mail.from.address', Setting::get('sender_email', Config::get('mail.from.address')));
        Config::set('mail.from.name', Setting::get('sender_name', Config::get('mail.from.name')));
        Config::set('mail.username', Setting::get('smtp_user', Config::get('mail.username')));
        Config::set('mail.password', Setting::get('smtp_pass', Config::get('mail.password')));
    }

    //
    // Form Dropdown options
    //

    public static function listTimezones()
    {
        $timezone_identifiers = DateTimeZone::listIdentifiers();
        $utc_time = new DateTime('now', new DateTimeZone('UTC'));

        $temp_timezones = [];
        foreach ($timezone_identifiers as $timezone_identifier) {
            $current_timezone = new DateTimeZone($timezone_identifier);

            $temp_timezones[] = [
                'offset' => (int)$current_timezone->getOffset($utc_time),
                'identifier' => $timezone_identifier,
            ];
        }

        usort($temp_timezones, function ($a, $b) {
            return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
        });

        $timezone_list = [];
        foreach ($temp_timezones as $tz) {
            $sign = ($tz['offset'] > 0) ? '+' : '-';
            $offset = gmdate('H:i', abs($tz['offset']));
            $timezone_list[$tz['identifier']] = $tz['identifier'].' (UTC '.$sign.$offset.')';
        }

        return $timezone_list;
    }
}