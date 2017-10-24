<?php
use Main\Classes\ThemeManager;

/**
 * Theme helper functions
 *
 * @package System
 */

if (!function_exists('get_partial_areas')) {
    /**
     * Get the theme partial areas/regions
     *
     * @param null $theme
     * @param string $domain
     *
     * @return array
     */
    function get_partial_areas($domain = 'main', $theme = null)
    {
        $activeTheme = is_null($theme) ? active_theme($domain) : $theme;
        $theme_config = ThemeManager::instance()->getConfigFromFile(trim($activeTheme, '/'));

        return isset($theme_config['partial_area']) ? $theme_config['partial_area'] : [];
    }
}

// ------------------------------------------------------------------------

if (!function_exists('active_theme')) {
    /**
     * Get the active theme code of the specified domain
     *
     * @param string $domain
     *
     * @return null
     */
    function active_theme($domain = 'main')
    {
//        return ThemeManager::instance()->getActiveThemeCode($domain);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('parent_theme')) {
    /**
     * Get the parent theme code of the specified domain
     * @param string $domain
     *
     * @return null
     */
    function parent_theme($domain = 'main')
    {
        return ThemeManager::instance()->findParent($domain);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('find_theme_files')) {
    /**
     * Search a theme folder for files.
     * @deprecated since 2.2.0 use Theme_manager->findFiles() instead
     *
     * Searches an individual folder for any theme files and returns an array
     * appropriate for display in the theme tree view.
     *
     * @param string $themeCode The theme to search
     *
     * @return array $theme_files
     */
    function find_theme_files($themeCode)
    {
//        return ThemeManager::instance()->findFiles($themeCode);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('list_themes')) {
    /**
     * List existing themes in the system
     * @deprecated since 2.2.0 use Theme_manager->listThemes() instead
     *
     * Lists the existing themes in the system by examining the
     * theme folders in both admin and main domain, and also gets the theme
     * config.
     *
     * @return array The names,path,config of the theme directories.
     */
    function list_themes()
    {
        return ThemeManager::instance()->listThemes();
    }
}

// ------------------------------------------------------------------------

if (!function_exists('load_theme_config')) {
    /**
     * Load a single theme config file into an array.
     * @deprecated since 2.2.0 use Theme_manager->getConfigFromFile() instead
     *
     * @param string $filename The name of the theme to locate. The config file
     *                         will be found and loaded by looking in the admin and main theme folders.
     * @param string $domain The domain where the theme is located.
     *
     * @return mixed The $theme array from the file or false if not found. Returns
     * null if $filename is empty.
     */
    function load_theme_config($filename = null, $domain = MAINDIR)
    {
        return ThemeManager::instance()->getConfigFromFile($filename);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('load_theme_file')) {
    /**
     * Load a single theme generic file into an array.
     * @deprecated since 2.2.0 use Theme_manager->readFile() instead
     *
     * @param string $filename The name of the file to locate. The file will be
     *                         found by looking in the admin and main themes folders.
     * @param string $theme The theme to check.
     *
     * @return mixed The $theme_file array from the file or false if not found. Returns
     * null if $filename is empty.
     */
    function load_theme_file($filename, $theme)
    {
        return ThemeManager::instance()->readFile($filename, $theme);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('delete_theme')) {
    /**
     * Delete existing theme folder.
     * @deprecated since 2.2.0 use Theme_manager->removeTheme() instead
     *
     * @param null $theme
     * @param      $domain
     *
     * @return bool
     */
    function delete_theme($theme, $domain = MAINDIR)
    {
        return ThemeManager::instance()->removeTheme($theme, $domain);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('save_theme_file')) {
    /**
     * Save a theme file.
     * @deprecated since 2.2.0 use Theme_manager->writeFile() instead
     *
     * @param string $filename The name of the file to locate. The file will be
     *                          found by looking in the admin and main themes folders.
     * @param string $theme The theme to check.
     * @param array $new_data A string of the theme file content replace.
     * @param boolean|string $return True to return the contents or false to return bool.
     *
     * @return bool|string False if there was a problem loading the file. Otherwise,
     * returns true when $return is false or a string containing the file's contents
     * when $return is true.
     */
    function save_theme_file($filename = null, $theme = null, $new_data = null, $return = FALSE)
    {
        return ThemeManager::instance()->writeFile($filename, $theme, $new_data, $return);
    }
}

// ------------------------------------------------------------------------

if (!function_exists('create_child_theme_files')) {
    /**
     * Create child theme file(s).
     * @deprecated since 2.2.0 use Theme_manager->createChild() instead
     *
     * @param array $files The name of the files to locate. The file will be
     *                          found by looking in the main themes folders.
     * @param string $source_theme The theme folder to copy the file from.
     * @param string $child_theme_data The child theme data.
     *
     * @return bool Returns false if file is not found in $source_theme
     * or $child_theme already exist.
     */
    function create_child_theme_files($files = [], $source_theme = null, $child_theme_data = null)
    {
        return ThemeManager::instance()->createChild($source_theme, $child_theme_data);
    }
}

// ------------------------------------------------------------------------
