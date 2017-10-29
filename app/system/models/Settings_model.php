<?php namespace System\Models;

use DateTime;
use DateTimeZone;
use Model;
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

    public static function getDateFormatOptions()
    {
        return [
            '%d/%m/%Y' => mdate('%d/%m/%Y', time()),
            '%m/%d/%Y' => mdate('%m/%d/%Y', time()),
            '%Y-%m-%d' => mdate('%Y-%m-%d', time()),
        ];
    }

    public static function getTimeFormatOptions()
    {
        return [
            '%h:%i %A' => mdate('%h:%i %A', time()),
            '%h:%i %a' => mdate('%h:%i %a', time()),
            '%H:%i'    => mdate('%H:%i', time()),
        ];
    }

    public static function getPageLimitOptions()
    {
        return [
            '10'  => '10',
            '20'  => '20',
            '50'  => '50',
            '75'  => '75',
            '100' => '100',
        ];
    }

    public function getValueAttribute()
    {
        return ($value = @unserialize($this->attributes['value']))
            ? $value
            : $this->attributes['value'];
    }

    //
    // Config & Registration
    //

    public function getFieldConfig()
    {
        if ($this->fieldConfig !== null) {
            return $this->fieldConfig;
        }

        $this->configPath = '~/app/system/models/config';
        $config = $this->makeConfig($this->settingsFields, ['form']);

        return $this->fieldConfig = isset($config['form']) ? $config['form'] : [];
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

        return isset($fieldConfig[$code]) ? $fieldConfig[$code] : [];
    }

    public function getSettingItem($code)
    {
        if (!$this->allItems)
            $this->loadSettingItems();

        return isset($this->allItems[$code]) ? $this->allItems[$code] : null;
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
        $settingsCategories = array_except($fieldConfig, 'toolbar');
        $this->registerSettingItems('core', $settingsCategories);

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
            'code'        => null,
            'label'       => null,
            'description' => null,
            'icon'        => null,
            'url'         => null,
            'priority'    => null,
            'permissions' => [],
            'context'     => 'settings',
            'model'       => null,
            'form'        => null,
        ];

        foreach ($definitions as $code => $definition) {
            $item = array_merge($defaultDefinitions, array_merge($definition, [
                'code'  => $code,
                'owner' => $owner,
            ]));

            if ($owner == 'core') {
                $item['url'] = admin_url('settings/edit/'.$code);
            } else {
                $item['url'] = admin_url('extensions/edit/'.str_replace('.', '/', $owner).'/'.$code);
            }

            $this->items[] = (object)$item;
        }
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
                'offset'     => (int)$current_timezone->getOffset($utc_time),
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