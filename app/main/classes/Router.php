<?php

namespace Main\Classes;

use Cache;
use Config;
use Event;
use File;
use Igniter\Flame\Router\Router as FlameRouter;
use Igniter\Flame\Support\RouterHelper;
use Lang;
use Main\Template\Page as PageTemplate;

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
 *
 * @package Main
 */
class Router
{
    /**
     * @var \Main\Classes\Theme The Main theme object.
     */
    protected $theme;

    /**
     * @var string The last URL to be looked up using findByUrl().
     */
    protected $url;

    /**
     * @var array A list of parameters names and values extracted from the URL pattern and URL string.
     */
    protected $parameters = [];

    /**
     * @var array Contains the URL map - the list of page file names and corresponding URL patterns.
     */
    protected $urlMap = [];

    /**
     * Router object with routes preloaded.
     */
    protected $routerObj;

    public function __construct(Theme $theme)
    {
        $this->theme = $theme;
    }

    /**
     * Finds a page by its URL. Returns the page object and sets the $parameters property.
     *
     * @param string $url The requested URL string.
     *
     * @return \Main\Template\Page|mixed Returns page object
     * or null if the page cannot be found.
     */
    public function findByUrl($url)
    {
        $this->url = $url;
        $url = RouterHelper::normalizeUrl($url);

        $apiResult = Event::fire('router.beforeRoute', [$url, $this], TRUE);
        if ($apiResult !== null)
            return $apiResult;

        for ($pass = 1; $pass <= 2; $pass++) {
            $fileName = null;
            $urlList = [];

            $cacheable = Config::get('system.enableRoutesCache');
            if ($cacheable) {
                $fileName = $this->getCachedUrlFileName($url, $urlList);
                if (is_array($fileName)) {
                    list($fileName, $this->parameters) = $fileName;
                }
            }

            // Find the page by URL and cache the route
            if (!$fileName) {
                $router = $this->getRouterObject();
                if ($router->match($url)) {
                    $this->parameters = $router->getParameters();

                    $fileName = $router->matchedRoute();

                    if ($cacheable) {
                        if (!$urlList OR !is_array($urlList))
                            $urlList = [];

                        $urlList[$url] = !empty($this->parameters)
                            ? [$fileName, $this->parameters]
                            : $fileName;

                        Cache::put(
                            $this->getUrlListCacheKey(),
                            base64_encode(serialize($urlList)),
                            Config::get('system.urlMapCacheTtl', 1)
                        );
                    }
                }
            }

            // Return the page
            if ($fileName) {
                // If the page was not found on the disk, clear the URL cache
                // and repeat the routing process.
                if (($page = PageTemplate::loadCached($this->theme, $fileName)) === null) {
                    if ($pass == 1) {
                        $this->clearCache();
                        continue;
                    }

                    return null;
                }

                return $page;
            }

            return null;
        }
    }

    /**
     * Finds a URL by it's page. Returns the URL route for linking to the page and uses the supplied
     * parameters in it's address.
     *
     * @param string $fileName Page file name.
     * @param array $parameters Route parameters to consider in the URL.
     *
     * @return string A built URL matching the page route.
     */
    public function findByFile($fileName, $parameters = [])
    {
        if (!strlen(File::extension($fileName))) {
            $fileName .= '.php';
        }

        return $this->getRouterObject()->url($fileName, $parameters);
    }

    /**
     * Autoloads the URL map only allowing a single execution.
     * @return \Igniter\Flame\Router\Router
     */
    protected function getRouterObject()
    {
        if ($this->routerObj !== null) {
            return $this->routerObj;
        }

        // Load up each route rule
        $router = new FlameRouter();
        foreach ($this->getUrlMap() as $pageInfo) {
            $router->route($pageInfo['file'], $pageInfo['pattern']);
        }

        // Sort all the rules
        $router->sortRules();

        return $this->routerObj = $router;
    }

    /**
     * Autoloads the URL map only allowing a single execution.
     * @return array Returns the URL map.
     */
    protected function getUrlMap()
    {
        if (!count($this->urlMap)) {
            $this->loadUrlMap();
        }

        return $this->urlMap;
    }

    /**
     * Loads the URL map - a list of page file names and corresponding URL patterns.
     * The URL map can is cached. The clearUrlMap() method resets the cache. By default
     * the map is updated every time when a page is saved in the back-end, or
     * when the interval defined with the system.urlMapCacheTtl expires.
     * @return boolean Returns true if the URL map was loaded from the cache. Otherwise returns false.
     */
    protected function loadUrlMap()
    {
        $cacheable = Config::get('system.enableRoutesCache');
        $cached = $cacheable ? Cache::get($this->getUrlMapCacheKey(), FALSE) : FALSE;

        if (!$cached OR ($unSerialized = @unserialize(@base64_decode($cached))) === FALSE) {
            // The item doesn't exist in the cache, create the map
            $pages = $this->theme->listPages();
            $map = [];
            foreach ($pages as $page) {
                if (!$page->permalink)
                    continue;

                $map[] = ['file' => $page->getFileName(), 'pattern' => $page->permalink];
            }

            $this->urlMap = $map;
            if ($cacheable) {
                Cache::put(
                    $this->getUrlMapCacheKey(),
                    base64_encode(serialize($map)),
                    Config::get('system.urlMapCacheTtl', 1)
                );
            }

            return FALSE;
        }

        $this->urlMap = $unSerialized;

        return TRUE;
    }

    /**
     * Clears the router cache.
     */
    public function clearCache()
    {
        Cache::forget($this->getUrlMapCacheKey());
        Cache::forget($this->getUrlListCacheKey());
    }

    /**
     * Sets the current routing parameters.
     *
     * @param  array $parameters
     *
     * @return void
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns the current routing parameters.
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Returns the last URL to be looked up.
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Returns a routing parameter.
     *
     * @param $name
     * @param $default
     *
     * @return array
     */
    public function getParameter($name, $default = null)
    {
        if (isset($this->parameters[$name]) AND !empty($this->parameters[$name])) {
            return $this->parameters[$name];
        }

        return $default;
    }

    /**
     * Returns the caching URL key depending on the theme.
     *
     * @param string $keyName Specifies the base key name.
     *
     * @return string Returns the theme-specific key name.
     */
    protected function getCacheKey($keyName)
    {
        return md5($this->theme->getPath()).$keyName.Lang::getLocale();
    }

    /**
     * Returns the cache key name for the URL list.
     * @return string
     */
    protected function getUrlListCacheKey()
    {
        return $this->getCacheKey('page-url-list');
    }

    /**
     * Returns the cache key name for the URL list.
     * @return string
     */
    protected function getUrlMapCacheKey()
    {
        return $this->getCacheKey('page-url-map');
    }

    /**
     * Tries to load a page file name corresponding to a specified URL from the cache.
     *
     * @param string $url Specifies the requested URL.
     * @param array &$urlList The URL list loaded from the cache
     *
     * @return mixed Returns the page file name if the URL exists in the cache. Otherwise returns null.
     */
    protected function getCachedUrlFileName($url, &$urlList)
    {
        $key = $this->getUrlListCacheKey();
        $urlList = Cache::get($key, FALSE);

        if (
            $urlList AND
            ($urlList = @unserialize(@base64_decode($urlList))) AND
            is_array($urlList)
        ) {
            if (array_key_exists($url, $urlList)) {
                return $urlList[$url];
            }
        }

        return null;
    }
}