<?php

namespace Main\Contracts;

use Exception;

interface TemplateLoader
{
    public function getFilename($name);

    /**
     * Gets the markup section of a template, given its name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The template source code
     *
     * @throws Exception When $name is not found
     */
    public function getMarkup($name);

    /**
     * Gets the source code of a template, given its name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The template source code
     *
     * @throws Exception When $name is not found
     */
    public function getContents($name);

    /**
     * Gets the cache key to use for the cache for a given template name.
     *
     * @param string $name The name of the template to load
     *
     * @return string The cache key
     *
     * @throws Exception When $name is not found
     */
    public function getCacheKey($name);

    /**
     * Returns true if the template is still fresh.
     *
     * @param string $name The template name
     * @param int $time Timestamp of the last modification time of the
     *                     cached template
     *
     * @return bool true if the template is fresh, false otherwise
     *
     * @throws Exception When $name is not found
     */
    public function isFresh($name, $time);

    public function exists($name);
}