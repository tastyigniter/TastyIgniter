<?php

declare(strict_types=1);

namespace Igniter\System\Traits;

use Carbon\Carbon;
use Exception;
use Igniter\Flame\Assetic\Asset\AssetCache;
use Igniter\Flame\Assetic\Asset\AssetCollection;
use Igniter\Flame\Assetic\Asset\FileAsset;
use Igniter\Flame\Assetic\Asset\HttpAsset;
use Igniter\Flame\Assetic\AssetManager;
use Igniter\Flame\Assetic\Cache\FilesystemCache;
use Igniter\Flame\Assetic\Filter\CssImportFilter;
use Igniter\Flame\Assetic\Filter\CssRewriteFilter;
use Igniter\Flame\Assetic\Filter\FilterInterface;
use Igniter\Flame\Assetic\Filter\ScssphpFilter;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\File;
use Igniter\Flame\Support\Facades\Igniter;
use Igniter\Main\Classes\Theme;
use Igniter\System\Events\AssetsBeforePrepareCombinerEvent;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

trait CombinesAssets
{
    /** Compiled bundles in the filesystem. */
    protected array $bundles = [];

    /** Filters to apply to on each file. */
    protected array $filters = [];

    /** The output folder for storing combined files. */
    protected ?string $storagePath = null;

    /** Cache key prefix. */
    public ?string $cacheKeyPrefix = null;

    /** Cache combined asset files. */
    public bool $useCache = false;

    protected ?string $assetsCombinerUri = null;

    protected function initCombiner()
    {
        $this->cacheKeyPrefix = 'ti.combiner.';
        $this->useCache = config('igniter-system.enableAssetCache', true);
        $this->storagePath = storage_path('igniter/combiner/data');
        $this->assetsCombinerUri = config('igniter-routes.assetsCombinerUri', '/_assets');

        if (Igniter::runningInAdmin()) {
            $this->assetsCombinerUri = Igniter::adminUri().$this->assetsCombinerUri;
        }

        $this->registerFilter('css', new CssImportFilter);
        $this->registerFilter(['css', 'scss'], new CssRewriteFilter);

        $scssPhpFilter = new ScssphpFilter;
        $scssPhpFilter->addImportPath(public_path());
        $this->registerFilter('scss', $scssPhpFilter);
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
     * @param array $assets Collection of assets
     *
     * @return string URL to contents.
     */
    public function combine(string $type, array $assets = []): string
    {
        $combiner = $this->prepareCombiner($assets);
        $lastMod = $combiner->getLastModified();

        $cacheKey = $this->getCacheKey($assets);
        $cacheData = $this->useCache ? $this->getCache($cacheKey.$lastMod) : false;

        if (!$cacheData) {
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
     */
    public function combineToFile(array $assets, string $destination): void
    {
        // Disable cache always
        $this->storagePath = null;

        $targetPath = File::localToPublic(dirname($destination));
        $assetCollection = $this->prepareCombiner($assets);
        $assetCollection->setTargetPath($this->getCombinerPath($targetPath));

        File::makeDirectory(dirname($destination), 0777, true, true);

        File::put($destination, $assetCollection->dump());
    }

    public function combineGetContents(string $cacheKey): \Illuminate\Http\Response
    {
        $cacheData = $this->getCache($cacheKey);
        if (!$cacheData) {
            throw new SystemException(sprintf(lang('igniter::system.not_found.combiner'), $cacheKey));
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
            $assetCollection = $this->prepareCombiner($cacheData['files']);
            $assetCollection->setTargetPath($this->getCombinerPath());
            $contents = $assetCollection->dump();
            $response->setContent($contents);
        }

        return $response;
    }

    public function buildBundles(Theme $theme): array
    {
        $this->addAssetsFromThemeManifest($theme);

        $assetVars = $theme->getAssetVariables();
        foreach (array_flatten($this->getFilters()) as $filter) {
            if (method_exists($filter, 'setVariables')) {
                $filter->setVariables($assetVars);
            }
        }

        $notes = [];

        try {
            $notes = $this->combineBundles();

            Event::dispatch('assets.combiner.afterBuildBundles', [$this, $theme]);
        } catch (Exception $exception) {
            flash()->error('Building assets bundle error: '.$exception->getMessage())->important();
        }

        return $notes;
    }

    protected function combineBundles(string $type = 'scss', $appContext = 'main'): array
    {
        $notes = [];
        foreach ($this->getBundles($type, $appContext) ?? [] as $destination => $assets) {
            $destination = File::symbolizePath($destination, false, false);
            $publicDestination = File::localToPublic(realpath(dirname($destination))).'/'.basename($destination);

            $this->combineToFile($assets, $destination);
            $notes[] = implode(', ', array_map('basename', $assets));
            $notes[] = sprintf(' -> %s', $publicDestination);
        }

        return $notes;
    }

    protected function prepareAssets(array $assets): array
    {
        $assets = array_map(fn($path) => $this->getAssetPath($path), $assets);

        return array_filter($assets);
    }

    protected function prepareCombiner(array $assets): AssetCollection
    {
        // Extensibility
        AssetsBeforePrepareCombinerEvent::dispatch($this, $assets);

        $files = [];
        foreach ($assets as $path) {
            $filters = $this->getFilters(File::extension($path)) ?: [];

            if (starts_with($path, ['//', 'http://', 'https://'])) {
                $asset = new HttpAsset($path, $filters);
            } else {
                if (File::exists($basePath = base_path($path))) {
                    $path = $basePath;
                }

                if (!File::exists($path)) {
                    $path = File::symbolizePath($path, null) ?? $path;
                }

                if (!File::exists($path)) {
                    continue;
                }

                $source = str_starts_with((string)$path, public_path())
                    ? public_path()
                    : dirname((string)$path);

                $asset = new FileAsset($path, $filters, $source);
            }

            $files[] = $asset;
        }

        $files = $this->applyCacheOnFiles($files);

        return resolve(AssetManager::class)->makeCollection($files);
    }

    /**
     * Returns the target path used with the combiner.
     *
     * /index.php/_assets    returns index-php/_assets/
     *
     * @return string The new target path
     */
    protected function getCombinerPath(?string $path = null): string
    {
        if (is_null($path)) {
            $baseUri = substr(Request::getBaseUrl(), strlen(Request::getBasePath()));
            $path = $baseUri.$this->assetsCombinerUri;
        }

        if (str_starts_with($path, '/')) {
            $path = substr($path, 1);
        }

        return str_replace('.', '-', $path).'/';
    }

    protected function applyCacheOnFiles(array $files): array
    {
        if ($this->storagePath === null) {
            return $files;
        }

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
     */
    public function registerFilter(string|array $extension, ?FilterInterface $filter): self
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
     */
    public function registerBundle(string $extension, string|array $files, ?string $destination = null, string $appContext = 'main'): void
    {
        if (!is_array($files)) {
            $files = [$files];
        }

        $firstFile = array_values($files)[0];

        $extension = strtolower(trim($extension));

        if (is_null($destination)) {
            $file = File::name($firstFile);
            $path = dirname((string)$firstFile);

            if ($extension !== 'js') {
                $cssPath = $path.'/../css';
                if (File::isDirectory(File::symbolizePath($cssPath))) {
                    $path = $cssPath;
                }

                $destination = $path.'/'.$file.'.css';
            } else {
                $destination = $path.'/'.$file.'.min.'.$extension;
            }
        }

        $this->bundles[$appContext][$extension][$destination] = $files;
    }

    /**
     * Returns bundles.
     */
    public function getBundles(?string $extension = null, string $appContext = 'main'): ?array
    {
        if (is_null($extension)) {
            return $this->bundles[$appContext] ?? [];
        }

        return $this->bundles[$appContext][$extension] ?? null;
    }

    /**
     * Returns filters.
     */
    public function getFilters($extension = null): ?array
    {
        if (is_null($extension)) {
            return $this->filters;
        }

        return $this->filters[$extension] ?? null;
    }

    /**
     * Clears any registered filters.
     */
    public function resetFilters(?string $extension = null): self
    {
        if ($extension === null) {
            $this->filters = [];
        } else {
            $this->filters[$extension] = [];
        }

        return $this;
    }

    //
    // Cache
    //

    protected function getCacheKey(array $assets): string
    {
        $cacheKey = implode('|', $assets);

        return md5($cacheKey);
    }

    protected function getCache(string $cacheKey): array|false
    {
        if (!Cache::has($this->cacheKeyPrefix.$cacheKey)) {
            return false;
        }

        return @unserialize(@base64_decode((string)Cache::get($this->cacheKeyPrefix.$cacheKey)));
    }

    protected function putCache(string $cacheKey, array $cacheData): bool
    {
        return Cache::forever($this->cacheKeyPrefix.$cacheKey, base64_encode(serialize($cacheData)));
    }
}
