<?php

declare(strict_types=1);

namespace Igniter\Flame\Assetic\Asset;

use Igniter\Flame\Assetic\Filter\FilterInterface;

/**
 * An asset has a mutable URL and content and can be loaded and dumped.
 *
 * @author Kris Wallsmith <kris.wallsmith@gmail.com>
 */
interface AssetInterface
{
    /**
     * Ensures the current asset includes the supplied filter.
     *
     * @param FilterInterface $filter A filter
     */
    public function ensureFilter(FilterInterface $filter);

    /**
     * Returns an array of filters currently applied.
     *
     * @return array An array of filters
     */
    public function getFilters(): array;

    /**
     * Clears all filters from the current asset.
     */
    public function clearFilters();

    /**
     * Loads the asset into memory and applies load filters.
     *
     * You may provide an additional filter to apply during load.
     *
     * @param ?FilterInterface $additionalFilter An additional filter
     */
    public function load(?FilterInterface $additionalFilter = null);

    /**
     * Applies dump filters and returns the asset as a string.
     *
     * You may provide an additional filter to apply during dump.
     *
     * Dumping an asset should not change its state.
     *
     * If the current asset has not been loaded yet, it should be
     * automatically loaded at this time.
     *
     * @param ?FilterInterface $additionalFilter An additional filter
     *
     * @return string The filtered content of the current asset
     */
    public function dump(?FilterInterface $additionalFilter = null): string;

    /**
     * Returns the loaded content of the current asset.
     *
     * @return string The content
     */
    public function getContent(): string;

    /**
     * Sets the content of the current asset.
     *
     * Filters can use this method to change the content of the asset.
     *
     * @param string $content The asset content
     */
    public function setContent(string $content);

    /**
     * Returns an absolute path or URL to the source asset's root directory.
     *
     * This value should be an absolute path to a directory in the filesystem,
     * an absolute URL with no path, or null.
     *
     * For example:
     *
     *  * '/path/to/web'
     *  * 'http://example.com'
     *  * null
     *
     * @return string|null The asset's root
     */
    public function getSourceRoot(): ?string;

    /**
     * Returns the relative path for the source asset.
     *
     * This value can be combined with the asset's source root (if both are
     * non-null) to get something compatible with file_get_contents().
     *
     * For example:
     *
     *  * 'js/main.js'
     *  * 'main.js'
     *  * null
     *
     * @return string|null The source asset path
     */
    public function getSourcePath(): ?string;

    /**
     * Returns the asset's source directory.
     *
     * The source directory is the directory the asset was located in
     * and can be used to resolve references relative to an asset.
     *
     * @return string|null The asset's source directory
     */
    public function getSourceDirectory(): ?string;

    /**
     * Returns the URL for the current asset.
     *
     * @return string|null A web URL where the asset will be dumped
     */
    public function getTargetPath(): ?string;

    /**
     * Sets the URL for the current asset.
     *
     * @param string $targetPath A web URL where the asset will be dumped
     */
    public function setTargetPath(string $targetPath);

    /**
     * Returns the time the current asset was last modified.
     *
     * @return int|null A UNIX timestamp
     */
    public function getLastModified(): ?int;

    /**
     * Returns an array of variable names for this asset.
     */
    public function getVars(): array;

    /**
     * Sets the values for the asset's variables.
     */
    public function setValues(array $values);

    /**
     * Returns the current values for this asset.
     *
     * @return array an array of strings
     */
    public function getValues(): array;
}
