<?php

declare(strict_types=1);

namespace Igniter\Main\Models;

use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Factories\HasFactory;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Main\Classes\Theme as ThemeData;
use Igniter\Main\Classes\ThemeManager;
use Igniter\Main\Events\ThemeActivatedEvent;
use Igniter\Main\Template\Layout;
use Igniter\System\Classes\ComponentManager;
use Igniter\System\Classes\ExtensionManager;
use Igniter\System\Classes\PackageManifest;
use Igniter\System\Models\Concerns\Defaultable;
use Igniter\System\Models\Concerns\Switchable;
use Illuminate\Support\Carbon;
use Override;

/**
 * Theme Model Class
 *
 * @property int $theme_id
 * @property string $name
 * @property string|null $code
 * @property string|null $description
 * @property string|null $version
 * @property array<array-key, mixed>|null $data
 * @property bool $status
 * @property bool $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $author
 * @property-read mixed $locked
 * @property-read mixed $screenshot
 * @method static Builder<static>|Theme applyDefaultable(bool $default = true)
 * @method static Builder<static>|Theme applyFilters(array $options = [])
 * @method static Builder<static>|Theme applySorts(array $sorts = [])
 * @method static Builder<static>|Theme applySwitchable(bool $switch = true)
 * @method static Builder<static>|Theme isEnabled()
 * @method static Builder<static>|Theme listFrontEnd(array $options = [])
 * @method static Builder<static>|Theme newModelQuery()
 * @method static Builder<static>|Theme newQuery()
 * @method static Builder<static>|Theme query()
 * @method static Builder<static>|Theme whereIsDisabled()
 * @method static Builder<static>|Theme whereIsEnabled()
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Theme extends Model
{
    use Defaultable;
    use HasFactory;
    use Purgeable;
    use Switchable;

    public const array ICON_MIMETYPES = [
        'png' => 'image/png',
        'svg' => 'image/svg+xml',
    ];

    /**
     * @var array data cached array
     */
    protected static $instances = [];

    /**
     * @var string The database table code
     */
    protected $table = 'themes';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'theme_id';

    protected $fillable = ['theme_id', 'name', 'code', 'version', 'description', 'data', 'status'];

    protected $casts = [
        'data' => 'array',
        'status' => 'boolean',
        'is_default' => 'boolean',
    ];

    protected $purgeable = ['template', 'settings', 'markup', 'codeSection'];

    public $timestamps = true;

    protected $fieldConfig;

    protected $fieldValues = [];

    public static function forTheme(ThemeData $theme)
    {
        $themeCode = $theme->getName();
        if ($instance = array_get(self::$instances, $themeCode)) {
            return $instance;
        }

        $instance = self::firstOrCreate(['code' => $themeCode]);

        return self::$instances[$themeCode] = $instance;
    }

    public static function onboardingIsComplete(): bool
    {
        return (bool)self::getDefault()?->data;
    }

    public function getLayoutOptions(): array
    {
        return Layout::getDropdownOptions($this->getTheme()->getName());
    }

    /**
     * @return array[]
     */
    public static function getComponentOptions(): array
    {
        $components = [];
        $manager = resolve(ComponentManager::class);
        foreach ($manager->listComponentObjects() as $code => $componentData) {
            if ($componentData->component->isHidden()) {
                continue;
            }

            $components[$code] = [$componentData->name, lang($componentData->description ?? '')];
        }

        return $components;
    }

    //
    // Accessors & Mutators
    //

    public function getNameAttribute($value)
    {
        return optional($this->getTheme())->label ?? $value;
    }

    public function getDescriptionAttribute($value)
    {
        return optional($this->getTheme())->description ?? $value;
    }

    public function getVersionAttribute($value = null)
    {
        return $value ?? '0.1.0';
    }

    public function getAuthorAttribute($value)
    {
        return optional($this->getTheme())->author ?? $value;
    }

    public function getLockedAttribute()
    {
        return $this->getTheme()?->locked;
    }

    public function getScreenshotAttribute()
    {
        return $this->getTheme()?->getScreenshotData();
    }

    #[Override]
    public function setAttribute($key, mixed $value)
    {
        if (!$this->isFillable($key)) {
            $this->fieldValues[$key] = $value;

            return $this;
        }

        return parent::setAttribute($key, $value);
    }

    //
    // Events
    //

    #[Override]
    protected function beforeSave()
    {
        if ($this->fieldValues) {
            $this->data = $this->fieldValues;
        }
    }

    //
    // Manager
    //

    public function getManager()
    {
        return resolve(ThemeManager::class);
    }

    public function getTheme()
    {
        return $this->getManager()->findTheme($this->code);
    }

    public function getFieldsConfig()
    {
        if (!is_null($this->fieldConfig)) {
            return $this->fieldConfig;
        }

        $fields = [];
        $formConfig = $this->getTheme()->getFormConfig();
        foreach ($formConfig as $item) {
            foreach (array_get($item, 'fields', []) as $name => $field) {
                if (!isset($field['tab'])) {
                    $field['tab'] = $item['title'];
                }

                $fields[$name] = $field;
            }
        }

        return $this->fieldConfig = $fields;
    }

    public function getFieldValues()
    {
        return $this->data ?: [];
    }

    public function getThemeData()
    {
        return $this->data;
    }

    //
    // Helpers
    //

    public static function syncAll(): void
    {
        $installedThemes = [];
        $manifest = resolve(PackageManifest::class);
        $themeManager = resolve(ThemeManager::class);
        foreach ($themeManager->paths() as $code => $path) {
            if (!($themeObj = $themeManager->findTheme($code))) {
                continue;
            }

            $installedThemes[] = $name = $themeObj->name ?? $code;

            // Only add themes whose meta code match their directory name
            if ($code != $name) {
                continue;
            }

            /** @var self $theme */
            $theme = self::firstOrNew(['code' => $name]);
            $theme->name = $themeObj->label ?? title_case($code);
            $theme->code = $name;
            $theme->version = $manifest->getVersion($theme->code) ?? $theme->version;
            $theme->description = $themeObj->description ?? '';
            $theme->data ??= [];
            $theme->save();
        }

        // Disable themes not found in file system
        // This allows admin to remove an enabled theme from admin UI after deleting files
        self::whereNotIn('code', $installedThemes)->update(['status' => false]);
        self::whereIn('code', $installedThemes)->update(['status' => true]);
    }

    /**
     * Activate theme
     *
     * @param string $code
     *
     * @return bool|mixed
     */
    public static function activateTheme($code, $skipRequires = false)
    {
        /** @var self $theme */
        if (empty($code) || !$theme = self::whereCode($code)->first()) {
            return false;
        }

        $extensionManager = resolve(ExtensionManager::class);

        $requires = $skipRequires ? [] : ($theme->getTheme()?->listRequires() ?? []);
        foreach ($requires as $extensionCode => $version) {
            if ($extensionManager->hasExtension($extensionCode)) {
                $extensionManager->installExtension($extensionCode);
            }
        }

        $theme->makeDefault();

        ThemeActivatedEvent::dispatch($theme);

        return $theme;
    }

    public static function generateUniqueCode(string $code, $suffix = null): string
    {
        do {
            $uniqueCode = $code.($suffix ? '-'.$suffix : '');
            $suffix = strtolower(str_random(3));
            $suffix = preg_replace('/[^a-z]/', '', $suffix);
        } while (self::themeCodeExists($uniqueCode)); // Already in the DB or contains a number? Fail. Try again

        return $uniqueCode;
    }

    public static function clearThemeInstances(): void
    {
        self::$instances = [];
    }

    /**
     * Checks whether a code exists in the database or not
     *
     * @param string $uniqueCode
     */
    protected static function themeCodeExists($uniqueCode): bool
    {
        return self::where('code', '=', $uniqueCode)->limit(1)->count() > 0;
    }
}
