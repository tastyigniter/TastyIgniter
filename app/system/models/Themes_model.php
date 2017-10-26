<?php namespace System\Models;

use File;
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
     * @var string The database table code
     */
    protected $table = 'themes';

    /**
     * @var string The database table primary key
     */
    protected $primaryKey = 'theme_id';

    public $casts = [
        'data' => 'serialize',
    ];

    public $manager = null;

    public $themeClass = null;

    public function afterFetch()
    {
        $this->applyThemeManager();
    }

    //
    // Scopes
    //

    public function scopeIsCustomisable($query)
    {
        return $query; // @todo: remove, no longer needed
    }

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
        $customizeConfig = array_get($this->themeObj, 'customizeConfig.sections', []);
        foreach ($customizeConfig as $section => $item) {
            foreach ($item['fields'] as $name => $field) {
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

    //
    // Helpers
    //

    /**
     * Update installed extensions config value
     *
     * @param string $theme
     * @param bool $install
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function updateInstalledThemes($theme = null, $install = TRUE)
    {
        $installed_themes = setting('installed_themes');

        if (empty($installed_themes) OR !is_array($installed_themes)) {
            $installed_themes = $this->select('code')
                                     ->where('status', '1')->get();
            if ($installed_themes) {
                $installed_themes = array_flip(array_column($installed_themes, 'code'));
                $installed_themes = array_fill_keys(array_keys($installed_themes), TRUE);
            }
        }

        if (!is_null($theme) AND ThemeManager::instance()->hasTheme($theme)) {
            if ($install) {
                $installed_themes[$theme] = TRUE;
            }
            else {
                unset($installed_themes[$theme]);
            }
        }

        setting()->add('installed_themes', $installed_themes);
    }

    /**
     * Activate theme
     *
     * @param string $code
     *
     * @return bool|mixed
     */
    public function activateTheme($code)
    {
        $query = FALSE;

        if (!empty($code) AND $theme = $this->getTheme($code)) {
            $default_themes = setting('default_themes');
            $default_themes['main'] = $code.'/';

            unset($default_themes['main_parent']);
            if (!empty($theme['parent'])) {
                $default_themes['main_parent'] = $theme['parent'].'/';
            }

            if (setting()->add('default_themes', $default_themes)) {
                $query = $theme['code'];
            }

            if ($query !== FALSE) {
                $this->updateInstalledThemes($code);

                $active_theme_options = setting('active_theme_options');
                $active_theme_options['main'] = [$theme['code'], $theme['data']];

                setting()->add('active_theme_options', $active_theme_options);
            }
        }

        return $query;
    }

    /**
     * Create a new or update existing theme
     *
     * @param array $update
     *
     * @return bool
     */
    public function updateTheme($update = [])
    {
        if (empty($update)) return FALSE;

        $update['status'] = '1';

        $query = FALSE;

        $themeModel = $this->where([
            ['type', '=', 'theme'],
            ['code', '=', $update['name']],
        ])->first();

        if ($themeModel) {
            $themeModel->fill($update)->save();
            $query = TRUE;
        }
        else if (!empty($update['name'])) {
            unset($update['old_title']);
            $query = $this->insertGetId(array_merge($update, [
                'type' => 'theme',
                'code' => $update['name'],
            ]));
        }

        if ($query) {
            $this->updateInstalledThemes($update['name']);

            if (!empty($update['data']) AND setting('main', 'default_themes') == $update['name'].'/') {
                $active_theme_options = setting('active_theme_options');
                $active_theme_options['main'] = [$update['name'], $update['data']];

                setting()->add('active_theme_options', $active_theme_options);
            }
        }

        return $query;
    }

    /**
     * Create child theme from existing theme files and data
     *
     * @param string $theme_code
     * @param array $files
     * @param bool $copy_data
     *
     * @return bool
     */
    public function copyTheme($theme_code = null, $copy_data = TRUE)
    {
        $query = FALSE;

        if (!empty($theme_code)) {

            $themeModel = $this->where('code', $theme_code)->first();

            if (!is_null($themeModel)) {
                $row = $themeModel->toArray();
                unset($row['extension_id']);
                $row['code'] = $this->findThemeCode("{$row['code']}-child");
                $row['old_title'] = $row['title'];
                $row['title'] = "{$row['title']} Child";

                if ($query = $this->updateTheme($row)) {
                    $query = ThemeManager::instance()->createChild($theme_code, $row);
                }
            }
        }

        return $query;
    }

    /**
     * Find an existing theme in DB by theme code
     *
     * @param string $code
     *
     * @return bool TRUE on success, FALSE on failure
     */
    public function themeExists($code)
    {
        return $this->where('code', $code)->first() ? TRUE : FALSE;
    }

    /**
     * Create a unique theme code
     *
     * @param string $theme_code
     * @param int $count
     *
     * @return string
     */
    protected function findThemeCode($theme_code, $count = 0)
    {
        do {
            $newThemeCode = ($count > 0) ? "{$theme_code}-{$count}" : $theme_code;
            $count++;
        } // Already exist in DB? Try again
        while ($this->themeExists($newThemeCode));

        return $newThemeCode;
    }

    /**
     * Delete a single theme by code
     *
     * @param string $theme_code
     * @param bool $delete_data
     *
     * @return bool
     */
    public function deleteTheme($theme_code, $delete_data = TRUE)
    {
        $themeModel = $this->where('code', $theme_code)->first();

        if ($delete_data) {
            $themeModel->delete();
        }
        else {
            $themeModel->status = 0;
            $themeModel->save();
        }

        $this->updateInstalledThemes($theme_code, FALSE);

        $query = ThemeManager::instance()->removeTheme($theme_code);

        return $query;
    }
}