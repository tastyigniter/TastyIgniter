<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Factory;

use Igniter\Flame\Assetic\Asset\AssetCollection;
use Igniter\Flame\Assetic\Asset\AssetCollectionInterface;
use Igniter\Flame\Assetic\Asset\AssetInterface;
use Igniter\Flame\Assetic\Asset\FileAsset;
use Igniter\Flame\Assetic\Asset\HttpAsset;
use Igniter\Flame\Assetic\Filter\DependencyExtractorInterface;

/**
 * The asset factory creates asset objects.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 */
class AssetFactory
{
    private readonly string $root;

    private string $output = 'assetic/*';

    /**
     * Constructor.
     *
     * @param string $root The default root directory
     * @param bool $debug Filters prefixed with a "?" will be omitted in debug mode
     */
    public function __construct(string $root, private bool $debug = false)
    {
        $this->root = rtrim($root, '/');
    }

    /**
     * Sets debug mode for the current factory.
     *
     * @param bool $debug Debug mode
     */
    public function setDebug(bool $debug): void
    {
        $this->debug = $debug;
    }

    /**
     * Checks if the factory is in debug mode.
     *
     * @return bool Debug mode
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * Sets the default output string.
     *
     * @param string $output The default output string
     */
    public function setDefaultOutput(string $output): void
    {
        $this->output = $output;
    }

    /**
     * Creates a new asset.
     *
     * Prefixing a filter name with a question mark will cause it to be
     * omitted when the factory is in debug mode.
     *
     * Available options:
     *
     *  * output: An output string
     *  * name:   An asset name for interpolation in output patterns
     *  * debug:  Forces debug mode on or off for this asset
     *  * root:   An array or string of more root directories
     *
     * @param array|string $inputs An array of input strings
     * @param array $filters An array of filter names
     * @param array $options An array of options
     *
     * @return AssetCollection An asset collection
     */
    public function createAsset(array|string $inputs = [], array $filters = [], array $options = []): AssetCollection
    {
        if (!is_array($inputs)) {
            $inputs = [$inputs];
        }

        if (!isset($options['output'])) {
            $options['output'] = $this->output;
        }

        if (!isset($options['vars'])) {
            $options['vars'] = [];
        }

        if (!isset($options['debug'])) {
            $options['debug'] = $this->debug;
        }

        if (!isset($options['root'])) {
            $options['root'] = [$this->root];
        } else {
            if (!is_array($options['root'])) {
                $options['root'] = [$options['root']];
            }

            $options['root'][] = $this->root;
        }

        if (!isset($options['name'])) {
            $options['name'] = $this->generateAssetName($inputs, $filters, $options);
        }

        $asset = $this->createAssetCollection([], $options);
        $extensions = [];

        // inner assets
        foreach ($inputs as $input) {
            if (is_array($input)) {
                // nested formula
                $asset->add($this->createAsset(...$input));
            } else {
                $asset->add($this->parseInput($input, $options));
                $extensions[pathinfo((string)$input, PATHINFO_EXTENSION)] = true;
            }
        }

        // filters
        foreach ($filters as $filter) {
            if (!$options['debug']) {
                $asset->ensureFilter($filter);
            }
        }

        // append variables
        if (!empty($options['vars'])) {
            $toAdd = [];
            foreach ($options['vars'] as $var) {
                if (str_contains((string)$options['output'], '{'.$var.'}')) {
                    continue;
                }

                $toAdd[] = '{'.$var.'}';
            }

            if (!empty($toAdd)) {
                $options['output'] = str_replace('*', '*.'.implode('.', $toAdd), $options['output']);
            }
        }

        // append consensus extension if missing
        if (count($extensions) === 1 && !pathinfo((string)$options['output'], PATHINFO_EXTENSION) && $extension = key($extensions)) {
            $options['output'] .= '.'.$extension;
        }

        // output --> target url
        $asset->setTargetPath(str_replace('*', $options['name'], $options['output']));

        return $asset;
    }

    public function generateAssetName($inputs, $filters, array $options = []): string
    {
        foreach (array_diff(array_keys($options), ['output', 'debug', 'root']) as $key) {
            unset($options[$key]);
        }

        ksort($options);

        return substr(sha1(serialize($inputs).serialize($filters).serialize($options)), 0, 7);
    }

    public function getLastModified(AssetInterface $asset)
    {
        $mtime = 0;
        foreach ($asset instanceof AssetCollectionInterface ? $asset : [$asset] as $leaf) {
            $mtime = max($mtime, $leaf->getLastModified());

            if (!$filters = $leaf->getFilters()) {
                continue;
            }

            $prevFilters = [];
            foreach ($filters as $filter) {
                $prevFilters[] = $filter;

                if (!$filter instanceof DependencyExtractorInterface) {
                    continue;
                }

                // extract children from leaf after running all preceeding filters
                $clone = clone $leaf;
                $clone->clearFilters();
                foreach (array_slice($prevFilters, 0, -1) as $prevFilter) {
                    $clone->ensureFilter($prevFilter);
                }

                $clone->load();

                foreach ($filter->getChildren($this, $clone->getContent(), $clone->getSourceDirectory()) as $child) {
                    $mtime = max($mtime, $this->getLastModified($child));
                }
            }
        }

        return $mtime;
    }

    /**
     * Parses an input string string into an asset.
     *
     * The input string can be one of the following:
     *
     *  * A reference:     If the string starts with an "at" sign it will be interpreted as a reference to an asset in the asset manager
     *  * An absolute URL: If the string contains "://" or starts with "//" it will be interpreted as an HTTP asset
     *  * A glob:          If the string contains a "*" it will be interpreted as a glob
     *  * A path:          Otherwise the string is interpreted as a filesystem path
     *
     * Both globs and paths will be absolutized using the current root directory.
     *
     * @param string $input An input string
     * @param array $options An array of options
     *
     * @return AssetInterface An asset
     */
    protected function parseInput(string $input, array $options = []): AssetInterface
    {
        if (str_contains($input, '://') || str_starts_with($input, '//')) {
            return $this->createHttpAsset($input, $options['vars']);
        }

        if ($this->isAbsolutePath($input)) {
            $path = ($root = $this->findRootDir($input, $options['root']))
                ? ltrim(substr($input, strlen($root)), '/')
                : null;
        } else {
            $root = $this->root;
            $path = $input;
            $input = $this->root.'/'.$path;
        }

        return $this->createFileAsset($input, $root, $path, $options['vars']);
    }

    protected function createAssetCollection(array $assets = [], array $options = []): AssetCollection
    {
        return new AssetCollection($assets, [], null, $options['vars'] ?? []);
    }

    protected function createHttpAsset($sourceUrl, $vars): HttpAsset
    {
        return new HttpAsset($sourceUrl, [], false, $vars);
    }

    protected function createFileAsset($source, $root = null, $path = null, $vars = []): FileAsset
    {
        return new FileAsset($source, [], $root, $path, $vars);
    }

    private function isAbsolutePath(string $path): bool
    {
        return $path[0] === '/' || $path[0] === '\\' || (strlen($path) > 3 && ctype_alpha($path[0]) && $path[1] === ':' && ($path[2] === '\\' || $path[2] === '/'));
    }

    /**
     * Loops through the root directories and returns the first match.
     *
     * @param string $path An absolute path
     * @param array $roots An array of root directories
     *
     * @return string|null The matching root directory, if found
     */
    private function findRootDir(string $path, array $roots): ?string
    {
        foreach ($roots as $root) {
            if (str_starts_with($path, (string)$root)) {
                return $root;
            }
        }

        return null;
    }
}
