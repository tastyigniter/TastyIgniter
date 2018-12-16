<?php namespace System\Models;

use File;
use Main\Classes\Theme;
use Main\Classes\ThemeManager;
use Model;
use URL;

/**
 * Themes Model Class
 * @package System
 */
class Themes_model extends Model
{
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

    protected $fillable = ['name', 'code', 'version', 'description'];

    public $casts = [
        'data' => 'serialize',
    ];

    /**
     * @var ThemeManager
     */
    public $manager;

    /**
     * @var \Main\Classes\Theme
     */
    public $themeClass;

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

    //
    // Events
    //

    public function afterFetch()
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

        $themePath = File::localToPublic($themeClass->getPath());
        $themeClass->screenshot = URL::asset($themePath.'/screenshot.png');

        $this->manager = $themeManager;
        $this->themeClass = $themeClass;

        $this->description = !strlen($this->description) ? $themeClass->description : $this->description;

        return TRUE;
    }

    public function getManager()
    {
        return $this->manager;
    }

    public function getFieldsConfig()
    {
        $fields = [];
        $customizeConfig = $this->themeClass->getConfigValue('form', []);
        foreach ($customizeConfig as $section => $item) {
            foreach (array_get($item, 'fields', []) as $name => $field) {
                if (!isset($field['tab']))
                    $field['tab'] = $item['title'];

                $fields[$name] = $field;
            }
        }

        return $fields;
    }

    public function getFieldValues()
    {
        return $this->data ?: [];
    }

    public function getThemeData()
    {
        $data = [];
        $customizeConfig = $this->themeClass->getConfigValue('form', []);
        foreach ($customizeConfig as $section => $item) {
            foreach (array_get($item, 'fields', []) as $name => $field) {
                $data[$name] = array_get($field, 'default');
            }
        }

        return array_merge($data, $this->data ?? []);
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

            if (!($themeClass = $themeManager->findTheme($code))) continue;

            $themeMeta = (object)$themeClass;
            $installedThemes[] = $name = $themeMeta->name ?? $code;

            // Only add themes whose meta code match their directory name
            // or theme has no record
            if (
                $code != $name OR
                $extension = $themes->where('code', $name)->first()
            ) continue;

            self::create([
                'name' => $themeMeta->label ?? title_case($code),
                'code' => $name,
                'version' => $themeMeta->version ?? '1.0.0',
                'description' => $themeMeta->description ?? '',
            ]);
        }

        // Disable themes not found in file system
        // This allows admin to remove an enabled theme from admin UI after deleting files
        self::whereNotIn('code', $installedThemes)->update(['status' => FALSE]);

        self::updateInstalledThemes();
    }

    /**
     * Update installed extensions config value
     */
    public static function updateInstalledThemes()
    {
        $installedThemes = self::select('status', 'name')->lists('status', 'code')->all();

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

        foreach ($theme->themeClass->requires as $require => $version) {
            Extensions_model::install($require);
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