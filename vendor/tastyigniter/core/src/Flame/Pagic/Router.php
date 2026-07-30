<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic;

use Igniter\Flame\Support\RouterHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Lang;

/**
 * Router Class
 * The router parses page URL patterns and finds pages by URLs.
 *
 * The page URL format is explained below.
 * <pre>/pages/:page_id</pre>
 * Name of parameters should be compatible with PHP variable names. To make a parameter optional
 * add the question mark after its name:
 * <pre>/pages/:page_id?</pre>
 * By default parameters in the middle of the URL are required, for example:
 * <pre>/pages/:page_id?/comments - although the :post_id parameter is marked as optional,
 * it will be processed as required.</pre>
 * Optional parameters can have default values which are used as fallback values in case if the real
 * parameter value is not presented in the URL. Default values cannot contain the pipe symbols and question marks.
 * Specify the default value after the question mark:
 * <pre>/pages/category/:page_id?10 - The page_id parameter would be 10 for this URL: /pages/category</pre>
 * You can also add regular expression validation to parameters. To add a validation expression
 * add the pipe symbol after the parameter name (or the question mark) and specify the expression.
 * The forward slash symbol is not allowed in the expressions. Examples:
 * <pre>/pages/:page_id|^[0-9]+$/comments - this will match /pages/10/comments
 * /pages/:page_id|^[0-9]+$ - this will match /pages/3
 * /pages/:page_name?|^[a-z0-9\-]+$ - this will match /pages/my-page</pre>
 *
 * Based on october\cms\Router
 */
class Router
{
    /**
     * @var string Value to use when a required parameter is not specified
     */
    public static string $defaultValue = 'default';

    public static string $templateClass = Model::class;

    protected string $url;

    protected array $parameters = [];

    protected array $urlMap = [];

    public function __construct(protected string $theme = 'default') {}

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Finds a page by its route name. Returns the page object and sets the $parameters property.
     */
    public function findPage(string $url, array $parameters = []): mixed
    {
        $fileName = array_get($parameters, '_file_', $url);

        for ($pass = 1; $pass <= 2; $pass++) {
            if (($page = static::$templateClass::loadCached($this->theme, $fileName)) === null) {
                if ($pass === 1) {
                    $this->clearCache();
                }

                continue;
            }

            return $page;
        }

        return null;
    }

    public function getRouteMap(): Collection
    {
        return collect($this->getUrlMap())->map(fn(array $page): array => RouterHelper::convertToRouteProperties($page));
    }

    /**
     * Autoloads the URL map only allowing a single execution.
     */
    public function getUrlMap(): array
    {
        if ($this->urlMap === []) {
            $this->loadUrlMap();
        }

        return $this->urlMap;
    }

    /**
     * Loads the URL map - a list of page file names and corresponding URL patterns.
     * The URL map can is cached. The clearUrlMap() method resets the cache. By default
     * the map is updated every time when a page is saved in the back-end, or
     * when the interval defined with the system.urlMapCacheTtl expires.
     */
    protected function loadUrlMap(): void
    {
        $cacheable = app()->routesAreCached() ? -1 : 0;

        $this->urlMap = Cache::remember($this->getUrlMapCacheKey(), $cacheable, function(): array {
            $map = [];
            $pages = static::$templateClass::listInTheme($this->theme, true);
            foreach ($pages as $page) {
                if ($page?->permalink) {
                    $map[] = [
                        'file' => $page->getBaseFileName(),
                        'route' => $page->getKey(),
                        'pattern' => $page->permalink,
                    ];
                }
            }

            return $map;
        });
    }

    /**
     * Clears the router cache.
     */
    public function clearCache(): void
    {
        Cache::forget($this->getUrlMapCacheKey());
    }

    /**
     * Returns the current routing parameters.
     */
    public function getParameters(): array
    {
        return request()->route()?->parameters() ?? [];
    }

    /**
     * Returns a routing parameter.
     */
    public function getParameter($name, $default = null): string|null|object
    {
        return request()->route()->parameter($name, $default);
    }

    /**
     * Returns the caching URL key depending on the theme.
     */
    protected function getCacheKey(string $keyName): string
    {
        return md5($this->theme).$keyName.Lang::getLocale();
    }

    /**
     * Returns the cache key name for the URL list.
     */
    protected function getUrlMapCacheKey(): string
    {
        return $this->getCacheKey('page-url-map');
    }

    /**
     * Builds a URL together by matching route name and supplied parameters
     */
    public function url(string $name, array $parameters = []): ?string
    {
        if (!$routeRule = $this->findRouteRule($name)) {
            return null;
        }

        return $this->urlFromPattern($routeRule['pattern'], $parameters);
    }

    public function pageUrl(string $name, array $parameters = []): ?string
    {
        $parameters = array_merge($this->getParameters(), $parameters);

        return $this->url($name, $parameters) ?? $name;
    }

    /**
     * Builds a URL together by matching route pattern and supplied parameters
     */
    public function urlFromPattern(string $pattern, array $parameters = []): string
    {
        $patternSegments = RouterHelper::segmentizeUrl($pattern);

        // Normalize the parameters, colons (:) in key names are removed.
        foreach ($parameters as $param => $value) {
            if (!starts_with($param, ':')) {
                continue;
            }

            $normalizedParam = substr((string)$param, 1);
            $parameters[$normalizedParam] = $value;
            unset($parameters[$param]);
        }

        // Build the URL segments, remember the last populated index
        $url = [];
        $lastPopulatedIndex = 0;

        foreach ($patternSegments as $index => $patternSegment) {
            // Static segment
            if (!starts_with($patternSegment, ':')) {
                $url[] = $patternSegment;
            }// Dynamic segment
            else {
                $paramName = RouterHelper::getParameterName($patternSegment);

                // Determine whether it is optional
                $optional = RouterHelper::segmentIsOptional($patternSegment);

                // Default value
                $defaultValue = RouterHelper::getSegmentDefaultValue($patternSegment);

                // Check if parameter has been supplied and is not a default value
                $parameterExists = array_key_exists($paramName, $parameters) &&
                    $parameters[$paramName] &&
                    $parameters[$paramName] !== $defaultValue;

                // Use supplied parameter value
                if ($parameterExists) {
                    $url[] = $parameters[$paramName];
                }// Look for a specified default value
                elseif ($optional) {
                    $url[] = $defaultValue ?: static::$defaultValue;

                    // Do not set $lastPopulatedIndex
                    continue;
                }// Non-optional field, use the default value
                else {
                    $url[] = static::$defaultValue;
                }
            }

            $lastPopulatedIndex = $index;
        }

        // Trim the URL to only include populated segments
        $url = array_slice($url, 0, $lastPopulatedIndex + 1);

        return RouterHelper::rebuildUrl($url);
    }

    public function findRouteRule($name)
    {
        return collect($this->getUrlMap())->first(fn(array $page): bool => $page['route'] === $name || $page['file'] === $name);
    }
}
