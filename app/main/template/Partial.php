<?php

namespace Main\Template;

use File;
use Igniter\Flame\Support\Extendable;
use Illuminate\Support\Collection;
use Main\Classes\Theme;
use Main\Contracts\TemplateSource;
use October\Rain\Halcyon\Exception\MissingFileNameException;
use Symfony\Component\Finder\Finder;

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
     * Get an array with the values of a given column.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get($dirName = null, $columns = ['*'])
    {
        $result = [];
        $dirPath = $this->theme->getPath().'/'.$this->dirName;
        if ($dirName)
            $dirPath .= '/'.$dirName;

        $finder = Finder::create()
                        ->files()->ignoreVCS(TRUE)
                        ->ignoreDotFiles(TRUE)
                        ->depth('<= 1');

        $finder->filter(function (\SplFileInfo $file) {
            // Filter by extension
            $fileExt = $file->getExtension();
            if (!is_null($this->allowedExtensions) AND !in_array($fileExt, $this->allowedExtensions))
                return FALSE;
        });

        $files = iterator_to_array($finder->in($dirPath), FALSE);

        foreach ($files as $file) {
            $item = [];

            $path = $file->getPathName();

            $item['fileName'] = $fileName = $file->getRelativePathName();
            $item['baseFileName'] = ($pos = strrpos($fileName, '.')) == FALSE ? $fileName : substr($fileName, 0, $pos);

            if (!$columns OR array_key_exists('mTime', $columns)) {
                $item['mTime'] = $this->files->lastModified($path);
            }

            if (!$columns OR array_key_exists('content', $columns)) {
                $item['content'] = $this->files->get($path);
            }

            $result[] = $item;
        }

        return new Collection($result);
    }

    /**
     * Update the source in the filesystem.
     *
     * @param  array $attributes
     *
     * @return bool|int
     */
    public function update(array $attributes = [])
    {
        return $this->save($attributes);
    }

    /**
     * Save the source to the filesystem.
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function save(array $attributes = [])
    {
        $fileName = array_get($attributes, 'fileName', $this->fileName);
        $content = array_get($attributes, 'markup', $this->content);

        if (!strlen($fileName)) {
            throw (new MissingFileNameException)->setModel($this);
        }

        if (!strlen(File::extension($fileName)))
            $fileName .= '.'.$this->defaultExtension;

        $oldPath = $this->getFilePath($this->fileName);
        $filePath = $this->getFilePath($fileName);

        if (!File::exists($filePath)) {
            @File::makeDirectory(dirname($filePath), 0777, TRUE);
        }

        File::delete($oldPath);

        return File::put($filePath, $content);
    }

    /**
     * Delete a source from the filesystem.
     *
     * @return bool
     */
    public function delete()
    {
        if (!$this->fileName)
            throw (new MissingFileNameException)->setModel($this);

        $filePath = $this->getFilePath($this->fileName);

        return File::delete($filePath);
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

    public static function listInTheme(Theme $theme, $dirName = null, $columns = ['*'])
    {
        if (is_string($theme)) {
            $theme = Theme::load($theme);
        }

        return (new static($theme))->get($dirName, $columns);
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

        return $this->theme->getPath().'/'.$this->dirName.'/'.$fileName;
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
    }

    /**
     * Returns the key used by the Template cache.
     * @return string
     */
    public function getTemplateCacheKey()
    {
    }

    /**
     * Returns the base file name and extension. Applies a default extension, if none found.
     *
     * @param string $fileName
     *
     * @return array
     */
    public function getFileNameParts($fileName = null)
    {
        if ($fileName === null) {
            $fileName = $this->fileName;
        }

        if (!strlen($extension = pathinfo($fileName, PATHINFO_EXTENSION))) {
            $extension = $this->defaultExtension;
            $baseFile = $fileName;
        }
        else {
            $pos = strrpos($fileName, '.');
            $baseFile = substr($fileName, 0, $pos);
        }

        return [$baseFile, $extension];
    }
}