<?php

namespace Main\Template;

use File;
use Igniter\Flame\Support\Extendable;
use Main\Classes\Theme;
use Main\Contracts\TemplateSource;

class Partial extends Extendable implements TemplateSource
{
    /**
     * @var string The directory name associated with the model
     */
    protected $dirName = '_partials';

    /**
     * @var \Main\Classes\Theme The theme object.
     */
    protected $theme;

    /**
     * @var string The component partial file name.
     */
    public $fileName;

    /**
     * @var string Last modified time.
     */
    public $mTime;

    /**
     * @var string Partial content.
     */
    public $content;

    /**
     * @var array Allowable file extensions.
     */
    protected $allowedExtensions = ['php'];

    /**
     * @var string Default file extension.
     */
    protected $defaultExtension = 'php';

    /**
     * Creates an instance of the object and associates it with a theme.
     *
     * @param \Main\Classes\Theme $theme Specifies the theme the partial belongs to.
     */
    public function __construct(Theme $theme)
    {
        $this->theme = $theme;

        parent::__construct();
    }

    /**
     * Find a single template by its file name.
     *
     * @param  string $fileName
     *
     * @return mixed|static
     */
    public function find($fileName)
    {
        if (!strlen(File::extension($fileName)))
            $fileName .= '.'.$this->defaultExtension;

        $filePath = $this->getFilePath($fileName);

        if (!File::isFile($filePath) OR ($content = File::get($filePath)) === FALSE)
            return null;

        $this->fileName = $fileName;
        $this->mTime = File::lastModified($filePath);
        $this->content = $content;

        return $this;
    }

    /**
     * Loads the template.
     *
     * @param  \Main\Classes\Theme|\System\Classes\BaseComponent $source
     * @param  string $fileName
     *
     * @return mixed
     */
    public static function load($source, $fileName)
    {
        return (new static($source))->find($fileName);
    }

    /**
     * Loads and caches the template.
     *
     * @param  \Main\Classes\Theme|\System\Classes\BaseComponent $source
     * @param  string $fileName
     *
     * @return mixed
     */
    public static function loadCached($source, $fileName)
    {
        return static::load($source, $fileName);
    }

    /**
     * Returns the local file path to the template.
     *
     * @param  string $fileName
     *
     * @return string
     */
    public function getFilePath($fileName = null)
    {
        if ($fileName === null) {
            $fileName = $this->fileName;
        }

        $theme = $this->theme;

        return $theme->getPath().'/'.$this->dirName.'/'.$fileName;
    }

    /**
     * Returns the file name.
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Returns the file name without the extension.
     * @return string
     */
    public function getBaseFileName()
    {
        $pos = strrpos($this->fileName, '.');
        if ($pos === FALSE) {
            return $this->fileName;
        }

        return substr($this->fileName, 0, $pos);
    }

    /**
     * Returns the file content.
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Gets the markup section of a template
     * @return string The template source code
     */
    public function getMarkup()
    {
//        $content = "<!-- Partial: {$this->getBaseFileName()} -->".PHP_EOL;
        $content = $this->content.PHP_EOL;

//        $content .= "<!-- Partial: {$this->getBaseFileName()} -->";
        return $content;
    }

    /**
     * Gets the code section of a template
     * @return string The template source code
     */
    public function getCode()
    {
        // TODO: Implement getCode() method.
    }

    /**
     * Returns the key used by the Template cache.
     * @return string
     */
    public function getTemplateCacheKey()
    {
        // TODO: Implement getTemplateCacheKey() method.
    }
}