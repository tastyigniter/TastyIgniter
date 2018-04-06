<?php namespace Main\Contracts;

interface TemplateSource
{
    /**
     * Loads the template.
     *
     * @param  string $hostObj
     * @param  string $fileName
     *
     * @return mixed
     */
    public static function load($hostObj, $fileName);

    /**
     * Loads and caches the template.
     *
     * @param  string $hostObj
     * @param  string $fileName
     *
     * @return mixed
     */
    public static function loadCached($hostObj, $fileName);

    /**
     * Returns the local file path to the template.
     *
     * @param  string $fileName
     *
     * @return string
     */
    public function getFilePath($fileName = null);

    /**
     * Returns the file name.
     * @return string
     */
    public function getFileName();

    /**
     * Returns the file name without the extension.
     * @return string
     */
    public function getBaseFileName();

    /**
     * Returns the file content.
     * @return string
     */
    public function getContent();

    /**
     * Gets the markup section of a template
     * @return string The template source code
     */
    public function getMarkup();

    /**
     * Gets the code section of a template
     * @return string The template source code
     */
    public function getCode();

    /**
     * Returns the key used by the Template cache.
     * @return string
     */
    public function getTemplateCacheKey();
}
