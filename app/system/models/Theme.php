<?php

namespace System\Models;

use Exception;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Exception\ApplicationException;
use Illuminate\Support\Facades\Event;
use Main\Classes\ThemeManager;
use Main\Template\Layout;
use System\Classes\ComponentManager;
use System\Classes\ExtensionManager;

/**
 * Theme Model Class
 */
class Theme extends Model
{
    use Purgeable;

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

    public $timestamps = TRUE;

    /**
     * @var ThemeManager
     */
    public $manager;

    /**
     * @var \Main\Classes\Theme
     */
    public $themeClass;

    protected $fieldConfig;

    protected $fieldValues = [];

    public static function forTheme(\Main\Classes\Theme $theme)
    {
        $dirName = $theme->getDirName();
        if ($instance = array_get(self::$instances, $dirName)) {
            return $instance;
        }

        $instance = self::firstOrCreate(['code' => $dirName]);

        return self::$instances[$dirName] = $instance;
    }

    public static function onboardingIsComplete()
    {
        if (!$code = params('default_themes.main'))
            return FALSE;

        if (!$model = self::where('code', $code)->first())
            return FALSE;

        return !is_null($model->data);
    }

    public function getLayoutOptions()
    {
        return Layout::getDropdownOptions($this->getTheme(), TRUE);
    }

    public static function getComponentOptions()
    {
        $components = [];
        $manager = ComponentManager::instance();
        foreach ($manager->listComponents() as $code => $definition) {
            try {
                $componentObj = $manager->makeComponent($code, null, $definition);

                if ($componentObj->isHidden) continue;

                $components[$code] = [$definition['name'], lang($definition['description'])];
            }
            catch (Exception $ex) {
            }
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
        return $this->getTheme()->locked;
    }

    public function getScreenshotAttribute()
    {
        return $this->getTheme()->screenshot;
    }

    public function setAttribute($key, $value)
    {
        if (!$this->isFillable($key)) {
            $this->fieldValues[$key] = $value;
        }
        else {
            parent::setAttribute($key, $value);
        }
    }

    //
    // Events
    //

    protected function beforeSave()
    {
        if ($this->fieldValues) {
            $this->data = $this->fieldValues;
        }
    }

    protected function afterFetch()
    {
        $this->applyThemeManager();
    }

    //
    // Scopes
    //

    public function scopeIsEnabled($query)
    {
        $query->where('status', 1);
    }

    //
    // Manager
    //

    /**
     * Attach the theme object to this class
     * @return bool
     */
    public function applyThemeManager()
    {
        $code = $this->code;

        if (!$code)
            return FALSE;

        $themeManager = ThemeManager::instance();
        if (!$themeClass = $themeManager->findTheme($code)) {
            return FALSE;
        }

        $this->manager = $themeManager;
        $this->themeClass = $themeClass;

        return TRUE;
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function getTheme()
    {
        return $this->themeClass;
    }

    public function getFieldsConfig()
    {
        if (!is_null($this->fieldConfig))
            return $this->fieldConfig;

        $fields = [];
        $formConfig = $this->getTheme()->getFormConfig();
        foreach ($formConfig as $section => $item) {
            foreach (array_get($item, 'fields', []) as $name => $field) {
                if (!isset($field['tab']))
                    $field['tab'] = $item['title'];

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
        $data = [];
        $formConfig = $this->getTheme()->getFormConfig();
        foreach ($formConfig as $section => $item) {
            foreach (array_get($item, 'fields', []) as $name => $field) {
                $data[$name] = array_get($this->data, $name, array_get($field, 'default'));
            }
        }

        return $data;
    }

    //
    // Helpers
    //

    public static function syncAll()
    {
        $installedThemes = [];
        $themeManager = ThemeManager::instance();
        foreach ($themeManager->paths() as $code => $path) {
            if (!($themeObj = $themeManager->findTheme($code))) continue;

            $installedThemes[] = $name = $themeObj->name ?? $code;

            // Only add themes whose meta code match their directory name
            if ($code != $name) continue;

            $theme = self::firstOrNew(['code' => $name]);
            $theme->name = $themeObj->label ?? title_case($code);
            $theme->code = $name;
            $theme->version = $theme->version ?? '0.1.0';
            $theme->description = $themeObj->description ?? '';
            $theme->save();
        }

        // Disable themes not found in file system
        // This allows admin to remove an enabled theme from admin UI after deleting files
        self::whereNotIn('code', $installedThemes)->update(['status' => FALSE]);
        self::whereIn('code', $installedThemes)->update(['status' => TRUE]);

        self::updateInstalledThemes();
    }

    /**
     * Update installed extensions config value
     */
    public static function updateInstalledThemes()
    {
        $installedThemes = self::select('status', 'code')->lists('status', 'code')->all();

        if (!is_array($installedThemes))
            $installedThemes = [];

        $installedThemes = array_map(function ($status) {
            return (bool)$status;
        }, $installedThemes);

        setting()->set('installed_themes', $installedThemes);
        setting()->save();
    }

    /**
     * Activate theme
     *
     * @param string $code
     *
     * @return bool|mixed
     */
    public static function activateTheme($code)
    {
        if (empty($code) || !$theme = self::whereCode($code)->first())
            return FALSE;

        $extensionManager = ExtensionManager::instance();

        $notFound = [];
        foreach ($theme->getTheme()->requires as $require => $version) {
            if (!$extensionManager->hasExtension($require)) {
                $notFound[] = $require;
            }
            else {
                $extensionManager->installExtension($require);
            }
        }

        if (count($notFound))
            throw new ApplicationException(sprintf('The following required extensions must be installed before activating this theme, %s', implode(', ', $notFound)));

        params()->set('default_themes.main', $theme->code);
        params()->save();

        Event::fire('main.theme.activated', [$theme]);

        return $theme;
    }

    /**
     * Delete a single theme by code
     *
     * @param string $theme_code
     * @param bool $delete_data
     *
     * @return bool
     */
    public static function deleteTheme($themeCode, $deleteData = TRUE)
    {
        $themeModel = self::where('code', $themeCode)->first();

        if ($themeModel && ($deleteData || !$themeModel->data)) {
            $themeModel->delete();
        }

        $filesDeleted = ThemeManager::instance()->removeTheme($themeCode);

        return $filesDeleted;
    }

    public static function generateUniqueCode($code, $suffix = null)
    {
        do {
            $uniqueCode = $code.($suffix ? '-'.$suffix : '');
            $suffix = strtolower(str_random('3'));
        } while (self::themeCodeExists($uniqueCode)); // Already in the DB? Fail. Try again

        return $uniqueCode;
    }

    /**
     * Checks whether a code exists in the database or not
     *
     * @param string $uniqueCode
     * @return bool
     */
    protected static function themeCodeExists($uniqueCode)
    {
        return self::where('code', '=', $uniqueCode)->limit(1)->count() > 0;
    }
}

class_alias('System\Models\Theme', 'System\Models\Themes_model', FALSE);
