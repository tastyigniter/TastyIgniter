<?php

namespace System\Models;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Exception;
use Igniter\Flame\Database\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Main\Classes\ThemeManager;
use Main\Template\Page;
use System\Classes\ExtensionManager;
use System\Classes\UpdateManager;
use System\Traits\ConfigMaker;

/**
 * Settings Model Class
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

    /**
     * @var array Cache of registration callbacks.
     */
    protected static $callbacks = [];

    public static function listMenuSettingItems($menu, $item, $user)
    {
        $options = [];
        $settingItems = (new static)->listSettingItems();
        foreach (array_get($settingItems, 'core', []) as $settingItem) {
            $options[$settingItem->label] = [$settingItem->icon, $settingItem->url];
        }

        return $options;
    }

    public static function getDateFormatOptions()
    {
        $now = Carbon::now();

        return [
            'd M Y' => $now->format('d M Y'),
            'M d Y' => $now->format('M d Y'),
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

    public static function getMenusPageOptions()
    {
        $theme = ThemeManager::instance()->getActiveTheme();

        return Page::getDropdownOptions($theme, true);
    }

    public static function getReservationPageOptions()
    {
        $theme = ThemeManager::instance()->getActiveTheme();

        return Page::getDropdownOptions($theme, true);
    }

    public static function onboardingIsComplete()
    {
        if (!Session::has('settings.errors'))
            return false;

        return count(array_filter((array)Session::get('settings.errors'))) === 0;
    }

    public static function updatesCount()
    {
        try {
            $updates = UpdateManager::instance()->requestUpdateList();

            return count(array_get($updates, 'items', []));
        }
        catch (Exception $ex) {
        }
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

    public function getFieldConfig($code)
    {
        if ($this->fieldConfig !== null) {
            return $this->fieldConfig;
        }

        $settingItem = $this->getSettingItem('core.'.$code);
        if (!is_array($settingItem->form))
            $settingItem->form = array_get($this->makeConfig($settingItem->form, ['form']), 'form', []);

        return $this->fieldConfig = $settingItem->form ?? [];
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
        return $this->getSettingItem('core.'.$code);
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
        foreach (self::$callbacks as $callback) {
            $callback($this);
        }

        // Load extension items
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
        $catItems = ['core' => [], 'extensions' => []];
        foreach ($this->items as $item) {
            $category = ($item->owner != 'core') ? 'extensions' : $item->owner;
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
            'priority' => 99,
            'permissions' => [],
            'context' => 'settings',
            'model' => null,
            'form' => null,
            'request' => null,
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

    public static function registerCallback(callable $callback)
    {
        self::$callbacks[] = $callback;
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

    //
    // File Definitions
    //

    /**
     * Extensions typically used as images.
     * This list can be customized with config:
     * - system.assets.media.defaultExtensions
     */
    public static function defaultExtensions()
    {
        return Config::get('system.assets.media.defaultExtensions', [
            'jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'svg', 'ico', 'webp',
            'doc', 'docx', 'ppt', 'pptx', 'pdf', 'txt', 'xls', 'xlsx',
            'mp4', 'avi', 'mov', 'mpg', 'mpeg', 'mkv', 'webm', 'ogg',
            'mp3', 'wav', 'wma', 'm4a',
        ]);
    }

    /**
     * Extensions typically used as images.
     * This list can be customized with config:
     * - system.assets.media.imageExtensions
     */
    public static function imageExtensions()
    {
        return Config::get('system.assets.media.imageExtensions', [
            'jpg', 'jpeg', 'bmp', 'png', 'webp', 'gif', 'svg',
        ]);
    }

    /**
     * Extensions typically used as video files.
     * This list can be customized with config:
     * - system.assets.media.videoExtensions
     */
    public static function videoExtensions()
    {
        return Config::get('system.assets.media.videoExtensions', [
            'mp4', 'avi', 'mov', 'mpg', 'mpeg', 'mkv', 'webm', 'ogv',
        ]);
    }

    /**
     * Extensions typically used as audio files.
     * This list can be customized with config:
     * - system.assets.media.audioExtensions
     */
    public static function audioExtensions()
    {
        return Config::get('system.assets.media.audioExtensions', [
            'mp3', 'wav', 'wma', 'm4a', 'ogg', 'oga',
        ]);
    }
}
