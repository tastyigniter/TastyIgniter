<?php

namespace System\Classes;

use Igniter\Flame\Support\Facades\File;

class Language
{
    /**
     * @var string Language code.
     */
    public $code;

    /**
     * @var string The language name
     */
    public $name;

    /**
     * @var string Specifies a description to accompany the language
     */
    public $description;

    /**
     * @var string The language version
     */
    public $version;

    /**
     * @var string The language path absolute base path
     */
    public $path;

    /**
     * @var string The language path relative to base path
     */
    public $localPath;

    /**
     * @var boolean Determine if this language should be loaded (false) or not (true).
     */
    public $disabled;

    public static function load($path, array $config)
    {
        $language = new static;
        $language->path = realpath($path);
        $language->localPath = File::localToPublic($language->path);
        $language->fillFromArray($config);

        return $language;
    }

    public function fillFromArray($config)
    {
        if (isset($config['code'])) {
            $this->code = $config['code'];
        }

        if (isset($config['name']))
            $this->name = $config['name'];

        if (isset($config['description']))
            $this->description = $config['description'];

        if (isset($config['version']))
            $this->version = $config['version'];

        if (array_key_exists('disabled', $config))
            $this->disabled = $config['disabled'];
    }

    public function getNamespace()
    {
        $locale = explode('.', $this->code);

        return current($locale);
    }

    public function getLocale()
    {
        $locale = explode('.', $this->code);

        return end($locale);
    }
}