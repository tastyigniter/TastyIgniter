<?php

namespace Main\Template;

use Igniter\Flame\Pagic\Contracts\TemplateSource;
use Igniter\Flame\Support\Extendable;
use Igniter\Flame\Support\Facades\File;
use System\Classes\BaseComponent;

class ComponentPartial extends Extendable implements TemplateSource
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
     * @var array Allowable file extensions.
     */
    protected $allowedExtensions = ['php'];

    /**
     * @var string Default file extension.
     */
    protected $defaultExtension = 'php';

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

    /**
     * @param \System\Classes\BaseComponent $component
     * @param string $fileName
     * @return \Main\Template\ComponentPartial|mixed
     */
    public static function load($component, $fileName)
    {
        return (new static($component))->find($fileName);
    }

    /**
     * @param \System\Classes\BaseComponent $component
     * @param string $fileName
     * @return \Main\Template\ComponentPartial|mixed
     */
    public static function loadCached($component, $fileName)
    {
        return static::load($component, $fileName);
    }

    /**
     * @param \Main\Classes\Theme $theme
     * @param \System\Classes\BaseComponent $component
     * @param string $fileName
     * @return mixed
     */
    public static function loadOverrideCached($theme, $component, $fileName)
    {
        $partial = Partial::loadCached($theme, $component->alias.'/'.$fileName);

        if ($partial === null) {
            $partial = Partial::loadCached($theme, strtolower($component->alias).'/'.$fileName);
        }

        return $partial;
    }

    /**
     * Find a single template by its file name.
     *
     * @param string $fileName
     *
     * @return mixed|static
     */
    public function find($fileName)
    {
        $filePath = $this->getFilePath($fileName);

        if (!File::isFile($filePath)) {
            return null;
        }

        if (($content = @File::get($filePath)) === false) {
            return null;
        }

        $this->fileName = File::basename($filePath);
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

        $basename = $fileName;
        if (!strlen(File::extension($basename)))
            $basename .= '.blade.'.$this->defaultExtension;

        if (File::isFile($path = $componentPath.'/'.$basename))
            return $path;

        // Check the shared "/partials" directory for the partial
        $sharedPath = dirname($componentPath).'/partials/'.$basename;
        if (File::isFile($sharedPath)) {
            return $sharedPath;
        }

        return $componentPath.'/'.$fileName;
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
        if ($pos === false) {
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
        return $this->content.PHP_EOL;
    }

    /**
     * Gets the code section of a template
     * @return string The template source code
     */
    public function getCode()
    {
    }
}
