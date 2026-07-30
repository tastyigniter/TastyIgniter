<?php

declare(strict_types=1);

namespace Igniter\System\Models;

use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Template\Page;
use Igniter\System\Classes\ExtensionManager;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

/**
 * Settings Model Class
 *
 * @property int $setting_id
 * @property string $sort
 * @property string|null $item
 * @property string|null $value
 * @property int|null $serialized
 * @method static Builder<static>|Settings applyFilters(array $options = [])
 * @method static Builder<static>|Settings applySorts(array $sorts = [])
 * @method static Builder<static>|Settings listFrontEnd(array $options = [])
 * @method static Builder<static>|Settings newModelQuery()
 * @method static Builder<static>|Settings newQuery()
 * @method static Builder<static>|Settings query()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Settings extends Model
{
    /**
     * @var string The database table name
     */
    protected $table = 'settings';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'setting_id';

    protected $settingsFields = 'Settings';

    protected array $fieldValues = [];

    protected $allItems;

    protected $items;

    /**
     * @var array Cache of registration callbacks.
     */
    protected static $callbacks = [];

    /**
     * @return array[]
     */
    public static function listMenuSettingItems($menu, $item, $user): array
    {
        $options = [];
        $settingItems = (new static)->listSettingItems();
        foreach (array_get($settingItems, 'core', []) as $settingItem) {
            $options[$settingItem->label] = [$settingItem->icon, $settingItem->url];
        }

        return $options;
    }

    public static function getDateFormatOptions(): array
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

    public static function getTimeFormatOptions(): array
    {
        $now = Carbon::now();

        return [
            'h:i A' => $now->format('h:i A'),
            'h:i a' => $now->format('h:i a'),
            'H:i' => $now->format('H:i'),
        ];
    }

    public static function getPageLimitOptions(): array
    {
        return [
            '10' => '10',
            '20' => '20',
            '50' => '50',
            '75' => '75',
            '100' => '100',
        ];
    }

    public static function getMenusPageOptions(): array
    {
        $theme = resolve(ThemeManager::class)->getActiveThemeCode();

        return $theme ? Page::getDropdownOptions($theme, true) : [];
    }

    public static function getReservationPageOptions(): array
    {
        $theme = resolve(ThemeManager::class)->getActiveThemeCode();

        return $theme ? Page::getDropdownOptions($theme, true) : [];
    }

    public static function onboardingIsComplete(): bool
    {
        if (!Session::has('settings.errors')) {
            return false;
        }

        return array_filter((array)Session::get('settings.errors')) === [];
    }

    public static function onboardingMailIsComplete(): bool
    {
        return (bool)self::getPref('test_mail_sent', false);
    }

    public function getValueAttribute()
    {
        return ($value = @unserialize($this->attributes['value'] ?? '')) !== false
            ? $value
            : $this->attributes['value'];
    }

    public static function get(?string $key = null, mixed $default = null, string $group = 'config'): mixed
    {
        return array_get(resolve(Settings::class)->getFieldValues($group), $key, $default);
    }

    public static function set(string|array $key, mixed $value = null, string $group = 'config'): bool
    {
        $data = collect(is_array($key) ? $key : [$key => $value])->map(fn($value, $key): array => [
            'sort' => $group,
            'item' => $key,
            'value' => is_array($value) ? serialize($value) : $value,
        ])->values()->all();

        resolve(Settings::class)->resetFieldValues();

        return (bool)static::upsert($data, ['sort', 'item'], ['value']);
    }

    public static function setPref(string|array $key, mixed $value = null): bool
    {
        return self::set($key, $value, 'prefs');
    }

    public static function getPref(string|array $key, mixed $default = null): mixed
    {
        return self::get($key, $default, 'prefs');
    }

    //
    // Registration
    //

    public function getFieldValues(string $group = 'config')
    {
        if (!Igniter::hasDatabase()) {
            return [];
        }

        if (is_array($this->fieldValues[$group] ?? '')) {
            return $this->fieldValues[$group];
        }

        return $this->fieldValues[$group] = $this
            ->newQuery()
            ->where('sort', $group)
            ->pluck('value', 'item')
            ->undot()
            ->all();
    }

    public function resetFieldValues(): static
    {
        $this->fieldValues = [];

        return $this;
    }

    public function getSettingDefinitions(string $code)
    {
        return $this->getSettingItem('core.'.$code);
    }

    public function getSettingItem($code)
    {
        if (!$this->allItems) {
            $this->loadSettingItems();
        }

        return $this->allItems[$code] ?? null;
    }

    public function listSettingItems()
    {
        if (!$this->items) {
            $this->loadSettingItems();
        }

        return $this->items;
    }

    public function loadSettingItems(): void
    {
        foreach (self::$callbacks as $callback) {
            $callback($this);
        }

        // Load extension items
        $extensions = resolve(ExtensionManager::class)->getExtensions();

        foreach ($extensions as $code => $extension) {
            $this->registerSettingItems($code, $extension->registerSettings());
        }

        usort($this->items, fn($a, $b): int|float => $a->priority - $b->priority);

        $allItems = [];
        $catItems = ['core' => [], 'extensions' => []];
        foreach ($this->items as $item) {
            $category = ($item->owner != 'core') ? 'extensions' : $item->owner;
            $catItems[$category][] = $item;

            $allItems[$item->owner.'.'.$item->code] = $item;
        }

        $this->allItems = $allItems;
        $this->items = $catItems;

        $this->fireSystemEvent('system.settings.extendItems', [$this]);
    }

    public function removeSettingItem($code): void
    {
        unset($this->allItems[$code]);

        if (starts_with($code, 'core.')) {
            foreach ($this->items['core'] as $key => $item) {
                if ($item->code == str_after($code, 'core.')) {
                    unset($this->items['core'][$key]);
                }
            }
        } else {
            foreach ($this->items['extensions'] as $key => $item) {
                if ($code === $item->owner.'.'.$item->code) {
                    unset($this->items['extensions'][$key]);
                }
            }
        }
    }

    public function registerSettingItems($owner, array $definitions): void
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

            if (!isset($item['url'])) {
                $item['url'] = admin_url($owner == 'core'
                    ? 'settings/edit/'.$code
                    : 'extensions/edit/'.str_replace('.', '/', $owner).'/'.$code,
                );
            }

            if (isset($item['permission'])) {
                $item['permissions'] = $item['permission'];
                unset($item['permission']);
            }

            $this->items[] = (object)$item;
        }
    }

    public static function registerCallback(callable $callback): void
    {
        self::$callbacks[] = $callback;
    }

    public static function clearInternalCache(): void
    {
        self::$callbacks = [];
    }

    //
    // Form Dropdown options
    //
    /**
     * @return non-falsy-string[]
     */
    public static function listTimezones(): array
    {
        $timezoneIdentifiers = DateTimeZone::listIdentifiers();
        $utcTime = new DateTime('now', new DateTimeZone('UTC'));

        $tempTimezones = [];
        foreach ($timezoneIdentifiers as $timezoneIdentifier) {
            $currentTimezone = new DateTimeZone($timezoneIdentifier);

            $tempTimezones[] = [
                'offset' => $currentTimezone->getOffset($utcTime),
                'identifier' => $timezoneIdentifier,
            ];
        }

        usort($tempTimezones, fn(array $a, array $b): int => ($a['offset'] === $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset']);

        $timezoneList = [];
        foreach ($tempTimezones as $tz) {
            $sign = ($tz['offset'] > 0) ? '+' : '-';
            $offset = gmdate('H:i', abs($tz['offset']));
            $timezoneList[$tz['identifier']] = $tz['identifier'].' (UTC '.$sign.$offset.')';
        }

        return $timezoneList;
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
        return Config::get('igniter-system.assets.media.defaultExtensions', [
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
        return Config::get('igniter-system.assets.media.imageExtensions', [
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
        return Config::get('igniter-system.assets.media.videoExtensions', [
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
        return Config::get('igniter-system.assets.media.audioExtensions', [
            'mp3', 'wav', 'wma', 'm4a', 'ogg', 'oga',
        ]);
    }
}
