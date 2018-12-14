<?php

namespace System\Traits;

use App;
use ApplicationException;
use Assetic\Asset\AssetCache;
use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\HttpAsset;
use Assetic\Cache\FilesystemCache;
use Cache;
use Carbon\Carbon;
use Event;
use File;
use Request;
use Response;

trait CombinesAssets
{
    /**
     * @var array Compiled bundles in the filesystem.
     */
    protected $bundles = [];

    /**
     * @var array Filters to apply to on each file.
     */
    protected $filters = [];

    /**
     * @var string The output folder for storing combined files.
     */
    protected $storagePath;

    /**
     * @var bool Cache key prefix.
     */
    public $cacheKeyPrefix = FALSE;

    /**
     * @var bool Cache combined asset files.
     */
    public $useCache = FALSE;

    /**
     * @var bool Compress (minify) asset files.
     */
    public $useMinify = FALSE;

    protected $assetsCombinerUri;

    protected $combineAssets;

    protected function initCombiner()
    {
        $this->useCache = config('system.enableAssetCache', TRUE);
        $this->useMinify = config('system.enableAssetMinify', null);
        $this->cacheKeyPrefix = 'ti.combiner.';

        $this->storagePath = storage_path('system/combiner/data');
        $this->assetsCombinerUri = config('system.assetsCombinerUri', '/_assets');

        if (app()->runningInAdmin())
            $this->assetsCombinerUri = config('system.adminUri', '/admin').$this->assetsCombinerUri;

        if ($this->useMinify === null)
            $this->useMinify = !config('app.debug', FALSE);

        if (!$this->combineAssets = config('system.enableAssetCombiner', FALSE))
            return;

        $this->registerFilter('css', new \Assetic\Filter\CssImportFilter);
        $this->registerFilter(['css', 'scss'], new \Assetic\Filter\CssRewriteFilter);

        $scssPhpFilter = new \Assetic\Filter\ScssphpFilter;
        $scssPhpFilter->addImportPath(base_path());
        $this->registerFilter('scss', $scssPhpFilter);

        if ($this->useMinify) {
            $this->registerFilter('js', new \Assetic\Filter\JSMinFilter);
            $this->registerFilter(['css', 'scss'], new \Assetic\Filter\CssMinFilter);
        }
    }

    /**
     * Combines JavaScript or StyleSheet file references
     * to produce a page relative URL to the combined contents.
     *
     *     $assets = [
     *         'assets/css/vendor/animate.css',
     *         'assets/css/vendor/dropzone.css',
     *         'assets/css/vendor/select2.min.css',
     *     ];
     *
     *     Assets::combine('css', $assets);
     *
     * @param string $type
     * @param array $assets Collection of assets
     *
     * @return string URL to contents.
     */
    public function combine($type, array $assets = [])
    {
        $assets = $this->prepareAssets($assets);

        $cacheKey = $this->getCacheKey($assets);
        $cacheData = $this->useCache ? $this->getCache($cacheKey) : FALSE;

        if (!$cacheData) {
            $combiner = $this->prepareCombiner($assets);

            $lastMod = $combiner->getLastModified();

            $cacheData = [
                'type' => $type,
                'uri' => $cacheKey.'-'.$lastMod.'.'.$type,
                'eTag' => $cacheKey,
                'lastMod' => $lastMod,
                'files' => $assets,
            ];

            $this->putCache($cacheKey, $cacheData);
        }

        return $this->assetsCombinerUri.'/'.$cacheData['uri'];
    }

    /**
     * Combines a collection of assets files to a destination file
     *
     *     $assets = [
     *         'assets/scss/flame.scss',
     *         'assets/scss/main.scss',
     *     ];
     *
     *     CombineAssets::combineToFile(
     *         $assets,
     *         base_path('themes/demo/assets/css/theme.css'),
     *     );
     *
     * @param array $assets Collection of assets
     * @param string $destination Write the combined file to this location
     *
     * @return void
     */
    public function combineToFile(array $assets, $destination)
    {
        $targetPath = File::localToPublic(dirname($destination));
        $combiner = $this->prepareCombiner($assets, $targetPath);

        $contents = $combiner->dump();

        File::put($destination, $contents);
    }

    public function combineGetContents($cacheKey)
    {
        $cacheData = $this->getCache($cacheKey);
        if (!$cacheData) {
            throw new ApplicationException(sprintf(lang('system::lang.not_found.combiner'), $cacheKey));
        }

        $lastModTime = gmdate("D, d M Y H:i:s \G\M\T", array_get($cacheData, 'lastMod'));
        $eTag = array_get($cacheData, 'eTag');
        $mime = (array_get($cacheData, 'type') == 'css')
            ? 'text/css' : 'application/javascript';

        header_remove();
        $response = Response::make();
        $response->header('Content-Type', $mime);
        $response->setLastModified(new Carbon($lastModTime));
        $response->setEtag($eTag);
        $response->setPublic();
        $modified = !$response->isNotModified(App::make('request'));

        // Request says response is cached, no code evaluation needed
        if ($modified) {
            $combiner = $this->prepareCombiner($cacheData['files']);
            $contents = $combiner->dump();
            $response->setContent($contents);
        }

        return $response;
    }

    protected function prepareAssets(array $assets)
    {
        $assets = array_map(function ($path) {
            return $this->getAssetPath($path);
        }, $assets);

        return $assets;
    }

    protected function prepareCombiner(array $assets, $targetPath = null)
    {
        // Extensibility
        Event::fire('assets.combiner.beforePrepare', [$this, $assets]);

        $files = [];
        foreach ($assets as $path) {
            $filters = $this->getFilters(File::extension($path)) ?: [];

            if (file_exists($publicPath = public_path($path)))
                $path = $publicPath;

            if (!file_exists($path))
                $path = File::symbolizePath($path, null) ?? $path;

            $asset = starts_with($path, ['//', 'http://', 'https://'])
                ? new HttpAsset($path, $filters)
                : new FileAsset($path, $filters, public_path());

            $files[] = $asset;
        }

        $files = $this->applyCacheOnFiles($files);

        $collection = new AssetCollection($files, []);
        $collection->setTargetPath($this->getCombinerPath($targetPath));

        return $collection;
    }

    /**
     * Returns the target path used with the combiner.
     *
     * /index.php/_assets    returns index-php/_assets/
     *
     * @param string|null $path
     *
     * @return string The new target path
     */
    protected function getCombinerPath($path = null)
    {
        if (is_null($path)) {
            $baseUri = substr(Request::getBaseUrl(), strlen(Request::getBasePath()));
            $path = $baseUri.$this->assetsCombinerUri;
        }

        if (strpos($path, '/') === 0)
            $path = substr($path, 1);

        return str_replace('.', '-', $path).'/';
    }

    protected function applyCacheOnFiles($files)
    {
        if (!File::isDirectory($this->storagePath)) {
            @File::makeDirectory($this->storagePath);
        }

        $cache = new FilesystemCache($this->storagePath);

        $cachedFiles = [];
        foreach ($files as $file) {
            $cachedFiles[] = new AssetCache($file, $cache);
        }

        return $cachedFiles;
    }

    //
    // Registration
    //

    /**
     * Register a filter to apply to the combining process.
     *
     * @param string|array $extension Extension name. Eg: css
     * @param object $filter Collection of files to combine.
     *
     * @return self
     */
    public function registerFilter($extension, $filter)
    {
        if (is_array($extension)) {
            foreach ($extension as $item) {
                $this->registerFilter($item, $filter);
            }

            return $this;
        }

        $extension = strtolower($extension);

        if (!isset($this->filters[$extension])) {
            $this->filters[$extension] = [];
        }

        if (!is_null($filter)) {
            $this->filters[$extension][] = $filter;
        }

        return $this;
    }

    /**
     * Registers bundle.
     *
     * @param $extension
     * @param $files
     * @param null $destination
     *
     * @return void
     */
    public function registerBundle($extension, $files, $destination = null)
    {
        if (!is_array($files))
            $files = [$files];

        $firstFile = array_values($files)[0];

        $extension = strtolower(trim($extension));

        if (is_null($destination)) {
            $file = File::name($firstFile);
            $path = dirname($firstFile);

            if ($extension != 'js') {
                $cssPath = $path.'/../css';
                if (File::isDirectory(File::symbolizePath($cssPath)))
                    $path = $cssPath;

                $destination = $path.'/'.$file.'.css';
            }
            else {
                $destination = $path.'/'.$file.'.min.'.$extension;
            }
        }

        $this->bundles[$extension][$destination] = $files;
    }

    /**
     * Returns bundles.
     *
     * @param string $extension
     *
     * @return array
     */
    public function getBundles($extension = null)
    {
        if (is_null($extension))
            return $this->bundles;

        if (isset($this->bundles[$extension]))
            return $this->bundles[$extension];

        return null;
    }

    /**
     * Returns filters.
     *
     * @param string $extension
     *
     * @return array
     */
    public function getFilters($extension = null)
    {
        if (is_null($extension))
            return $this->filters;

        if (isset($this->filters[$extension]))
            return $this->filters[$extension];

        return null;
    }

    /**
     * Clears any registered filters.
     *
     * @param string $extension
     *
     * @return self
     */
    public function resetFilters($extension = null)
    {
        if ($extension === null) {
            $this->filters = [];
        }
        else {
            $this->filters[$extension] = [];
        }

        return $this;
    }

    //
    // Cache
    //

    protected function getCacheKey(array $assets)
    {
        $cacheKey = implode('|', $assets);

        return md5($cacheKey);
    }

    protected function getCache($cacheKey)
    {
        if (!Cache::has($this->cacheKeyPrefix.$cacheKey)) {
            return FALSE;
        }

        return @unserialize(@base64_decode(Cache::get($this->cacheKeyPrefix.$cacheKey)));
    }

    protected function putCache($cacheKey, $cacheData)
    {
        if (Cache::has($this->cacheKeyPrefix.$cacheKey))
            return FALSE;

        Cache::forever($this->cacheKeyPrefix.$cacheKey, base64_encode(serialize($cacheData)));

        return TRUE;
    }
}