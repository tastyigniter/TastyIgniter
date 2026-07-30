<?php

declare(strict_types=1);

use Igniter\Main\Classes\ThemeManager;

/**
 * Theme helper functions
 */
if (!function_exists('active_theme')) {
    /**
     * Get the active theme code of the specified domain
     */
    function active_theme(): ?string
    {
        return resolve(ThemeManager::class)->getActiveThemeCode();
    }
}

if (!function_exists('parent_theme')) {
    /**
     * Get the parent theme code of the specified domain
     */
    function parent_theme(?string $theme): ?string
    {
        return resolve(ThemeManager::class)->findParentCode($theme);
    }
}
