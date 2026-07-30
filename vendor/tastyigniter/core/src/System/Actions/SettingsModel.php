<?php

declare(strict_types=1);

namespace Igniter\System\Actions;

use Igniter\Flame\Database\Model;
use Igniter\Flame\Support\Facades\Igniter;

/**
 * Settings model extension
 * Adapted from October/ModelBehaviour
 * Usage:
 * In the model class definition:
 *   public array $implement = [\Igniter\System\Actions\SettingsModel::class];
 *   public string $settingsCode = 'owner_extension_settings';
 *   public string $settingsFieldsConfig = 'Settings';
 */
class SettingsModel extends ModelAction
{
    protected ?string $recordCode = null;

    protected ?array $fieldConfig = null;

    protected array $fieldValues = [];

    /**
     * @var array Internal cache of model objects.
     */
    protected static $instances = [];

    protected array $requiredProperties = ['settingsFieldsConfig', 'settingsCode'];

    /**
     * Constructor
     */
    public function __construct(Model $model)
    {
        parent::__construct($model);

        $this->model->setTable('extension_settings');
        $this->model->setKeyName('id');
        $this->model->addCasts(['data' => 'array']);
        $this->model->guard([]);

        $this->model->timestamps = false;

        $parts = explode('\\', strtolower($model::class));
        $namespace = implode('.', array_slice($parts, 0, 2));

        $this->configPath[] = $namespace.'::models';
        $this->configPath[] = 'igniter::models/admin';
        $this->configPath[] = 'igniter::models/system';
        $this->configPath[] = 'igniter::models/main';

        // Access to model's overrides is unavailable, using events instead
        $this->model->bindEvent('model.afterFetch', $this->afterModelFetch(...));
        $this->model->bindEvent('model.beforeSave', $this->beforeModelSave(...));
        $this->model->bindEvent('model.afterSave', $this->afterModelSave(...));
        $this->model->bindEvent('model.setAttribute', $this->setSettingsValue(...));
        $this->model->bindEvent('model.saveInternal', $this->saveModelInternal(...));

        $this->recordCode = $this->model->settingsCode;
    }

    /**
     * Create an instance of the settings model, intended as a static method
     */
    public function instance()
    {
        if (isset(self::$instances[$this->recordCode])) {
            return self::$instances[$this->recordCode];
        }

        if (is_null($item = $this->getSettingsRecord())) {
            $this->model->initSettingsData();
            $item = $this->model;
        }

        return self::$instances[$this->recordCode] = $item;
    }

    /**
     * Reset the settings to their defaults, this will delete the record model
     */
    public function resetDefault(): void
    {
        if (!is_null($record = $this->getSettingsRecord())) {
            $record->delete();
            $this->fieldValues = [];
            $this->model->data = [];
            unset(self::$instances[$this->recordCode]);
        }
    }

    /**
     * Checks if the model has been set up previously, intended as a static method
     */
    public function isConfigured(): bool
    {
        return Igniter::hasDatabase() && $this->getSettingsRecord() instanceof Model;
    }

    /**
     * Returns the raw Model record that stores the settings.
     */
    public function getSettingsRecord(): ?Model
    {
        /** @var Model $model */
        $model = $this->model->where('item', $this->recordCode)->first();

        return $model;
    }

    /**
     * Set a single or array key pair of values, intended as a static method
     */
    public function set(string|array $key, mixed $value = null): bool
    {
        $data = is_array($key) ? $key : [$key => $value];
        $obj = self::instance();
        $obj->fill($data);

        return $obj->save();
    }

    /**
     * Helper for getSettingsValue, intended as a static method
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->instance()->getSettingsValue($key, $default);
    }

    /**
     * Get a single setting value, or return a default value
     */
    public function getSettingsValue(string $key, mixed $default = null): mixed
    {
        if ($this->model->hasGetMutator($key)) {
            return $this->model->getAttribute($key);
        }

        if (array_key_exists($key, $this->fieldValues)) {
            return $this->fieldValues[$key];
        }

        return $default;
    }

    /**
     * Set a single setting value, if allowed.
     */
    public function setSettingsValue(string $key, mixed $value): void
    {
        if ($this->isKeyAllowed($key)) {
            return;
        }

        $this->fieldValues[$key] = $value;
    }

    /**
     * Default values to set for this model, override
     */
    public function initSettingsData() {}

    /**
     * Populate the field values from the database record.
     */
    public function afterModelFetch(): void
    {
        $this->fieldValues = $this->model->data ?: [];
        $this->model->setRawAttributes(array_merge($this->fieldValues, $this->model->getAttributes()));
    }

    /**
     * Internal save method for the model
     */
    public function saveModelInternal(): void
    {
        // Purge the field values from the attributes
        $this->model->setRawAttributes(array_diff_key($this->model->getAttributes(), $this->fieldValues));
    }

    /**
     * Before the model is saved, ensure the record code is set
     * and the jsonable field values
     */
    public function beforeModelSave(): void
    {
        $this->model->item = $this->recordCode;
        if ($this->fieldValues) {
            $this->model->data = $this->fieldValues;
        }
    }

    /**
     * After the model is saved, clear the cached query entry.
     */
    public function afterModelSave(): void
    {
        $this->model->setRawAttributes(array_merge($this->fieldValues, $this->model->getAttributes()));
    }

    /**
     * Checks if a key is legitimate or should be added to
     * the field value collection
     */
    protected function isKeyAllowed(string $key): bool
    {
        return in_array($key, ['id', 'item', 'data'], true) || $this->model->hasRelation($key);
    }

    /**
     * Returns the field configuration used by this model.
     */
    public function getFieldConfig(): ?array
    {
        if ($this->fieldConfig !== null) {
            return $this->fieldConfig;
        }

        return $this->fieldConfig = $this->loadConfig($this->model->settingsFieldsConfig, ['form'], 'form');
    }

    /**
     * Clears the internal memory cache of model instances.
     */
    public static function clearInternalCache(): void
    {
        self::$instances = [];
    }
}
