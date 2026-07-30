<?php

declare(strict_types=1);

namespace Igniter\Local\Models;

use Igniter\Flame\Database\Model;
use Igniter\System\Classes\ExtensionManager;
use Override;

class LocationSettings extends Model
{
    public $timestamps = false;

    protected $casts = [
        'data' => 'array',
    ];

    public $relation = [
        'belongsTo' => [
            'location' => [Location::class],
        ],
    ];

    protected array $queryModifierFilters = [
        'location_id' => 'applyLocationId',
        'item' => 'applyItem',
    ];

    protected array $settingsValues = [];

    protected static array $registeredSettings = [];

    protected static array $callbacks = [];

    /**
     * @var array Internal cache of model objects.
     */
    protected static $instances = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->bindEvent('model.setAttribute', $this->setSettingsValue(...));
        $this->bindEvent('model.saveInternal', $this->saveModelInternal(...));
    }

    public static function instance(Location $location, string $settingsCode)
    {
        if (isset(self::$instances[$location->getKey()][$settingsCode])) {
            return self::$instances[$location->getKey()][$settingsCode];
        }

        $instance = static::query();

        return self::$instances[$location->getKey()][$settingsCode] = $instance->firstOrNew([
            'location_id' => $location->getKey(),
            'item' => $settingsCode,
        ]);
    }

    #[Override]
    protected function afterFetch()
    {
        $this->settingsValues = (array)$this->data;
        $this->setRawAttributes(array_merge($this->settingsValues, $this->getAttributes()));
    }

    #[Override]
    protected function beforeSave()
    {
        if ($this->settingsValues) {
            $this->data = $this->settingsValues;
        }
    }

    public function saveModelInternal(): void
    {
        // Purge the field values from the attributes
        $this->setRawAttributes(array_diff_key($this->getAttributes(), $this->settingsValues));
    }

    public function setSettingsValue($key, $value): void
    {
        if ($this->isKeyAllowed($key)) {
            return;
        }

        $this->settingsValues[$key] = $value;
    }

    public function get($key, $default = null)
    {
        return $this->getAttribute($key) ?? $default;
    }

    public function getSettingsValue(): array
    {
        return $this->settingsValues;
    }

    protected function isKeyAllowed($key): bool
    {
        return in_array($key, ['id', 'location_id', 'item', 'data']) || $this->hasRelation($key);
    }

    public static function clearInternalCache(): void
    {
        static::$instances = [];
    }

    public function scopeApplyLocationId($query, $locationId)
    {
        return $query->where('location_id', $locationId);
    }

    public function scopeApplyItem($query, $item)
    {
        return $query->where('item', $item);
    }

    //
    // Registration
    //

    public function listRegisteredSettings(): array
    {
        if (!static::$registeredSettings) {
            $this->loadRegisteredSettings();
        }

        return static::$registeredSettings;
    }

    public function loadRegisteredSettings(): void
    {
        foreach (self::$callbacks as $callback) {
            $callback($this);
        }

        // Load extension items
        $settingsBundle = resolve(ExtensionManager::class)->getRegistrationMethodValues('registerLocationSettings');
        foreach ($settingsBundle as $extensionCode => $definitions) {
            $this->registerSettingItems($extensionCode, $definitions);
        }

        uasort(static::$registeredSettings, fn($a, $b): int|float => $a->priority - $b->priority);
    }

    public function registerSettingItems(string $extensionCode, array $definitions): void
    {
        $defaultDefinitions = [
            'code' => null,
            'label' => null,
            'description' => null,
            'icon' => null,
            'url' => null,
            'priority' => 99,
            'permissions' => [],
            'form' => null,
            'request' => null,
        ];

        foreach ($definitions as $settingsCode => $definition) {
            $definition['code'] = $settingsCode;
            $definition = array_merge($defaultDefinitions, $definition);

            if (array_key_exists('form', $definition) && is_string($definition['form']) && !str_contains($definition['form'], '::')) {
                $definition['form'] = $extensionCode.'::'.$definition['form'];
            }

            static::$registeredSettings[$settingsCode] = (object)$definition;
        }
    }

    public static function registerCallback(callable $callback): void
    {
        self::$callbacks[] = $callback;
    }
}
