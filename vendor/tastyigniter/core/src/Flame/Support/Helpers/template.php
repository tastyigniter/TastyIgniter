<?php

declare(strict_types=1);

/**
 * Template helper functions
 */
use Igniter\Flame\Pagic\Environment;
use Illuminate\Support\HtmlString;

if (!function_exists('pagic')) {
    function pagic(?string $name = null, array $vars = []): Environment|string
    {
        if (is_null($name)) {
            return resolve('pagic');
        }

        return resolve('pagic')->render($name, $vars);
    }
}

if (!function_exists('page')) {
    /**
     * Get the page content
     */
    function page(): string
    {
        return controller()->renderPage();
    }
}

if (!function_exists('content')) {
    /**
     * Load a content template file
     */
    function content(string $content = '', array $data = []): string
    {
        return controller()->renderContent($content, $data);
    }
}

if (!function_exists('partial')) {
    /**
     * Load a partial template file
     *
     * @return string
     */
    function partial(string $partial = '', array $data = []): mixed
    {
        return controller()->renderPartial($partial, $data);
    }
}

if (!function_exists('has_component')) {
    /**
     * Check if a component is loaded
     */
    function has_component(string $component = ''): bool
    {
        return controller()->hasComponent($component);
    }
}

if (!function_exists('component')) {
    /**
     * Check if Partial Area has rendered components
     *
     * @return string
     */
    function component(string $component = '', array $params = []): string|false
    {
        return controller()->renderComponent($component, $params);
    }
}

if (!function_exists('get_title')) {
    /**
     * Get page title html tag
     * @return    string
     */
    function get_title()
    {
        return controller()->getPage()->title;
    }
}

if (!function_exists('html')) {
    function html(?string $html): HtmlString
    {
        return new HtmlString($html ?: '');
    }
}
