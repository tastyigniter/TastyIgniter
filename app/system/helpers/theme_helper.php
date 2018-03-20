<?php

use Main\Classes\ThemeManager;

/**
 * Theme helper functions
 * @package System
 */

// ------------------------------------------------------------------------

if (!function_exists('active_theme')) {
    /**
     * Get the active theme code of the specified domain
     *
     * @return null
     */
    function active_theme()
    {
        return ThemeManager::instance()->getActiveThemeCode();
    }
}

// ------------------------------------------------------------------------

if (!function_exists('parent_theme')) {
    /**
     * Get the parent theme code of the specified domain
     *
     * @param string $theme
     *
     * @return null
     */
    function parent_theme($theme)
    {
        return ThemeManager::instance()->findParent($theme);
    }
}

// ------------------------------------------------------------------------
