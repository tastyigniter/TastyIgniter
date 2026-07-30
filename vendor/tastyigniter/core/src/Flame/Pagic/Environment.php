<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic;

use Exception;
use Igniter\Flame\Pagic\Cache\FileSystem;
use Igniter\Flame\Pagic\Contracts\TemplateInterface;
use Igniter\Flame\Pagic\Contracts\TemplateLoader;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Compilers\CompilerInterface;
use Throwable;

class Environment
{
    protected array $loadedTemplates;

    protected bool $debug;

    protected string $templateClass;

    protected string $charset;

    protected ?FileSystem $cache;

    protected static array $globalsCache;

    protected string $templateClassPrefix = '__PagicTemplate_';

    /**
     * Constructor.
     * Available options:
     *  * debug: When set to true, it automatically set "auto_reload" to true as
     *           well (default to false).
     *  * charset: The charset used by the templates (default to UTF-8).
     *  * templateClass: The base template class to use for generated
     *                         templates.
     *  * cache: An absolute path where to store the compiled templates,
     *           or false to disable compilation cache.
     *
     * @param array $options An array of options
     */
    public function __construct(protected TemplateLoader $loader, array $options = [])
    {
        $this->setLoader($loader);

        $options = array_merge([
            'debug' => false,
            'charset' => 'UTF-8',
            'templateClass' => Template::class,
            'cache' => null,
        ], $options);

        $this->debug = (bool)$options['debug'];
        $this->templateClass = $options['templateClass'];
        $this->setCharset($options['charset']);
        $this->setCache($options['cache']);

        View::share('___env', $this);
    }

    public function setLoader(TemplateLoader $loader): void
    {
        $this->loader = $loader;
    }

    /**
     * Gets the Loader instance.
     */
    public function getLoader(): TemplateLoader
    {
        return $this->loader;
    }

    public function setDebug(bool $debug): static
    {
        $this->debug = $debug;

        return $this;
    }

    public function getDebug(): bool
    {
        return $this->debug;
    }

    public function setTemplateClass(string $templateClass): static
    {
        $this->templateClass = $templateClass;

        return $this;
    }

    public function getTemplateClass(): string
    {
        return $this->templateClass;
    }

    /**
     * Sets the default template charset.
     *
     * @param string $charset The default charset
     */
    public function setCharset(string $charset): void
    {
        $this->charset = strtoupper($charset);
    }

    /**
     * Gets the default template charset.
     * @return string The default charset
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * Gets the current cache implementation.
     */
    public function getCache(): FileSystem
    {
        return $this->cache;
    }

    /**
     * Sets the current cache implementation.
     */
    public function setCache(FileSystem $cache): void
    {
        $this->cache = $cache;
    }

    public function getCompiler(): CompilerInterface
    {
        return resolve(BladeCompiler::class);
    }

    public function renderSource(TemplateInterface $source, array $vars = []): string
    {
        return $this->loadSource($source)->render($vars);
    }

    public function loadSource(TemplateInterface $source): Template
    {
        $this->loader->setSource($source);

        return $this->load($source->getFilePath());
    }

    /**
     * Renders a template.
     *
     * @param string $name The template name
     * @param array $context An array of parameters to pass to the template
     *
     * @return string The rendered template
     * @throws Exception
     * @throws Throwable
     */
    public function render(string $name, array $context = []): string
    {
        return $this->load($name)->render($context);
    }

    /**
     * Loads a template.
     */
    public function load(string $name): Template
    {
        return $this->loadTemplate($name, $this->getCache()->getCacheKey($name, true));
    }

    /**
     * Loads a template internal representation.
     *
     * @param string $name The template path
     * @param string $path The template cache path
     */
    public function loadTemplate(string $name, string $path): Template
    {
        if (isset($this->loadedTemplates[$name])) {
            return $this->loadedTemplates[$name];
        }

        $fileCache = $this->getCache();
        $isFresh = $this->isTemplateFresh($name, $fileCache->getTimestamp($path));

        if (!$isFresh || !File::isFile($path)) {
            $markup = $this->getLoader()->getMarkup($name);

            $this->getCompiler()->setPath(
                $this->getLoader()->getFilename($name),
            );
            $compiled = $this->getCompiler()->compileString($markup);

            $fileCache->write($path, $compiled);
        }

        $class = $this->getTemplateClass();

        return $this->loadedTemplates[$name] = new $class($this, $path);
    }

    /**
     * Creates a template from source.
     *
     * @param string $template The template name
     */
    public function createTemplate(string $template): Template
    {
        $name = hash('sha256', $template, false);
        $key = $this->getCache()->getCacheKey($name, true);

        $loader = new ArrayLoader([$name => $template]);

        $current = $this->getLoader();
        $this->setLoader($loader);

        try {
            return $this->loadTemplate($name, $key);
        } finally {
            $this->setLoader($current);
        }
    }

    /**
     * Returns true if the template is still fresh.
     *
     * @param string $name The template name
     * @param int $time The last modification time of the cached template
     *
     * @return bool true if the template is fresh, false otherwise
     * @throws Exception
     */
    public function isTemplateFresh(string $name, int $time): bool
    {
        return $this->getLoader()->isFresh($name, $time);
    }

    /**
     * Registers a Global.
     *
     * New globals can be added before compiling or rendering a template;
     * but after, you can only update existing globals.
     */
    public function addGlobal(string $name, mixed $value): void
    {
        self::$globalsCache[$name] = $value;
    }

    /**
     * Gets the registered Globals.
     */
    public function getGlobals(): array
    {
        return self::$globalsCache;
    }

    /**
     * Merges a context with the defined globals.
     */
    public function mergeGlobals(array $context): array
    {
        // we don't use array_merge as the context being generally
        // bigger than globals, this code is faster.
        foreach ($this->getGlobals() as $key => $value) {
            if (!array_key_exists($key, $context)) {
                $context[$key] = $value;
            }
        }

        return $context;
    }
}
