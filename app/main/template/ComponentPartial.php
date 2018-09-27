<?php

namespace Main\Template;

use File;
use System\Classes\BaseComponent;

class ComponentPartial extends Partial
{
    /**
     * @var \System\Classes\BaseComponent The component object.
     */
    protected $component;

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
     * @var int The maximum allowed path nesting level. The default value is 2,
     * meaning that files can only exist in the root directory, or in a
     * subdirectory. Set to null if any level is allowed.
     */
    protected $maxNesting = 2;

    /**
     * Creates an instance of the object and associates it with a component.
     *
     * @param \System\Classes\BaseComponent $component
     */
    public function __construct(BaseComponent $component)
    {
        $this->component = $component;

        $this->extendableConstruct();
    }

    public static function load($component, $fileName)
    {
        return (new static($component))->find($fileName);
    }

    public static function loadCached($component, $fileName)
    {
        return static::load($component, $fileName);
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
        if ('' === File::extension($fileName))
            $fileName .= '.'.$this->defaultExtension;

        $filePath = $this->getFilePath($fileName);

        if (!File::isFile($filePath)) {
            return null;
        }

        if (($content = @File::get($filePath)) === FALSE) {
            return null;
        }

        $this->fileName = $fileName;
        $this->mTime = File::lastModified($filePath);
        $this->content = $content;

        return $this;
    }

    /**
     * Returns true if the specific component contains a matching partial.
     *
     * @param BaseComponent $component Specifies a component the file belongs to.
     * @param string $fileName Specifies the file name to check.
     *
     * @return bool
     */
    public static function check(BaseComponent $component, $fileName)
    {
        $partial = new static($component);
        $filePath = $partial->getFilePath($fileName);
        if ('' === File::extension($filePath)) {
            $filePath .= '.'.$partial->getDefaultExtension();
        }

        return File::isFile($filePath);
    }

    /**
     * Returns the key used by the Template cache.
     * @return string
     */
    public function getTemplateCacheKey()
    {
        return $this->getFilePath();
    }

    /**
     * Returns the default extension used by this template.
     * @return string
     */
    public function getDefaultExtension()
    {
        return $this->defaultExtension;
    }

    /**
     * Returns the absolute file path.
     *
     * @param string $fileName Specifies the file name to return the path to.
     *
     * @return string
     */
    public function getFilePath($fileName = null)
    {
        if ($fileName === null) {
            $fileName = $this->fileName;
        }

        $component = $this->component;
        $componentPath = $component->getPath();

        if (!File::isFile($path = $componentPath.'/'.$fileName)) {
            // Check the shared "/partials" directory for the partial
            $sharedPath = dirname($componentPath).'/partials'.'/'.$fileName;
            if (File::isFile($sharedPath)) {
                return $sharedPath;
            }
        }

        return $path;
    }
}