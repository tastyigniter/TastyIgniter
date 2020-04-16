<?php namespace System\Models;

use Exception;
use Igniter\Flame\Database\Traits\Purgeable;
use Main\Classes\Theme;
use Main\Classes\ThemeManager;
use Main\Template\Layout;
use Model;
use System\Classes\ComponentManager;
use System\Classes\ExtensionManager;

/**
 * Themes Model Class
 * @package System
 */
class Themes_model extends Model
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

    public $casts = [
        'data' => 'serialize',
        'status' => 'boolean',
        'is_default' => 'boolean',
    ];

    protected $purgeable = ['template', 'settings', 'markup', 'codeSection'];

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

    public static function forTheme(Theme $theme)
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

                $components[$code] = [$definition['name'], $definition['description']];
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
        return $this->getTheme()->label;
    }

    public function getDescriptionAttribute()
    {
        return $this->getTheme()->description;
    }

    public function getVersionAttribute()
    {
        return $this->getTheme()->version;
    }

    public function getAuthorAttribute()
    {
        return $this->getTheme()->author;
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

    public function beforeSave()
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
     * @return boolean
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
        $themes = self::get();

        $installedThemes = [];
        $themeManager = ThemeManager::instance();
        foreach ($themeManager->paths() as $code => $path) {

            if (!($themeObj = $themeManager->findTheme($code))) continue;

            $installedThemes[] = $name = $themeObj->name ?? $code;

            // Only add themes whose meta code match their directory name
            // or theme has no record
            if (
                $code != $name OR
                $extension = $themes->where('code', $name)->first()
            ) continue;

            self::create([
                'name' => $themeObj->label ?? title_case($code),
                'code' => $name,
                'version' => $themeObj->version ?? '1.0.0',
                'description' => $themeObj->description ?? '',
            ]);
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
        if (empty($code) OR !$theme = self::whereCode($code)->first())
            return FALSE;

        params()->set('default_themes.main', $theme->code);
        params()->save();

        foreach ($theme->getTheme()->requires as $require => $version) {
            ExtensionManager::instance()->installExtension($require);
        }

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

        if ($themeModel AND ($deleteData OR !$themeModel->data)) {
            $themeModel->delete();
        }

        $filesDeleted = ThemeManager::instance()->removeTheme($themeCode);

        return $filesDeleted;
    }
}