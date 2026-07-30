<?php

declare(strict_types=1);

namespace Igniter\System\Traits;

use ErrorException;
use Exception;
use Igniter\Admin\Facades\Template;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\View\ViewFinderInterface;
use Throwable;

trait ViewMaker
{
    /** A list of variables to pass to the page. */
    public array $vars = [];

    /** Specifies a path to the views directory. ex. ['package::view' => 'package'] */
    public array $viewPath = [];

    /** Specifies a path to the layout directory. */
    public array $layoutPath = [];

    /** Specifies a path to the partials directory. */
    public array $partialPath = [];

    /** Layout to use for the view. */
    public ?string $layout = null;

    public function getViewPath(string $view, array|string|null $paths = [], ?string $prefix = null): string
    {
        if (!is_array($paths)) {
            $paths = [$paths];
        }

        $guess = collect($paths)
            ->prepend($prefix, $view)
            ->reduce(function($carry, $directory, string $prefix) use ($view) {
                if (!is_null($carry)) {
                    return $carry;
                }

                $viewName = Str::after($view, $prefix.'::');
                $guessedViewName = $this->guessViewName($viewName, $directory);

                if (view()->exists($guessedViewName)) {
                    return view()->getFinder()->find($guessedViewName);
                }

                if (view()->exists($guessedViewName.'.index')) {
                    return view()->getFinder()->find($guessedViewName.'.index');
                }
            });

        if (is_null($guess) && view()->exists($view)) {
            return view()->getFinder()->find($view);
        }

        return $guess ?: $view;
    }

    public function getViewName(string $view, array|string|null $paths = [], ?string $prefix = null): string
    {
        if (!is_array($paths)) {
            $paths = [$paths];
        }

        $guess = collect($paths)
            ->prepend($prefix, $view)
            ->reduce(function($carry, $directory, string $prefix) use ($view) {
                if (!is_null($carry)) {
                    return $carry;
                }

                $viewName = Str::after($view, $prefix.'::');
                $guessedViewName = $this->guessViewName($viewName, $directory);

                if (view()->exists($guessedViewName)) {
                    return $guessedViewName;
                }

                if (view()->exists($guessedViewName.'.index')) {
                    return $guessedViewName.'.index';
                }
            });

        if (is_null($guess) && view()->exists($view)) {
            return $view;
        }

        return $guess ?: $view;
    }

    public function guessViewName(string $name, ?string $prefix = 'components.'): string
    {
        if ($prefix && !Str::endsWith($prefix, '.') && !Str::endsWith($prefix, '::')) {
            $prefix .= '.';
        }

        $delimiter = ViewFinderInterface::HINT_PATH_DELIMITER;

        if (Str::contains($name, $delimiter)) {
            return Str::replaceFirst($delimiter, $delimiter.$prefix, $name);
        }

        return $prefix.$name;
    }

    /**
     * Render a layout.
     *
     * @param string|null $name Specifies the layout name.
     * If this parameter is omitted, the $layout property will be used.
     * @param array $vars Parameter variables to pass to the view.
     * @param bool $throwException Throw an exception if the layout is not found
     *
     * @return string The layout contents, or false.
     * @throws SystemException
     */
    public function makeLayout(?string $name = null, array $vars = [], bool $throwException = true): string
    {
        $layout = $name ?? $this->layout;
        if ($layout == '') {
            return '';
        }

        $layout = $this->getViewName(strtolower((string)$layout), $this->layoutPath, '_layouts');

        return $this->makeViewContent($layout, $vars);
    }

    /**
     * Loads a view with the name specified.
     * Applies layout if its name is provided by the parent object.
     * The view file must be situated in the views directory, and has the extension "htm" or "php".
     *
     * @param string $view Specifies the view name, without extension. Eg: "index".
     */
    public function makeView(string $view, array $data = []): string
    {
        $view = $this->getViewName(strtolower($view), $this->viewPath);
        $contents = $this->makeViewContent($view, $data);

        if ($this->layout === '') {
            return $contents;
        }

        // Append content to the body template
        Template::setBlock('body', $contents);

        return $this->makeLayout();
    }

    /**
     * Render a partial file contents located in the views or partial folder.
     *
     * @param string $partial The view to load.
     * @param array $vars Parameter variables to pass to the view.
     *
     * @return string Partial contents or false if not throwing an exception.
     */
    public function makePartial(string $partial, array $vars = [], bool $throwException = true): string
    {
        $partial = $this->getViewName(strtolower($partial), $this->partialPath, '_partials');

        if (!view()->exists($partial)) {
            if ($throwException) {
                throw new SystemException(sprintf(lang('system::lang.not_found.partial'), $partial));
            }

            return '';
        }

        if (isset($this->controller)) {
            $vars = array_merge($this->controller->vars, $vars);
        }

        return $this->makeViewContent($partial, $vars);
    }

    /**
     * Includes a file path using output buffering.
     * Ensures that vars are available.
     *
     * @param string $filePath Absolute path to the view file.
     * @param array $extraParams Parameters that should be available to the view.
     */
    public function makeFileContent(string $filePath, array $extraParams = []): string
    {
        if (!strlen($filePath) || $filePath === 'index.php' || !File::isFile($filePath)) {
            return '';
        }

        $vars = array_merge($this->vars, $extraParams);

        $filePath = $this->compileFileContent($filePath);

        $vars = $this->gatherViewData($vars);

        $obLevel = ob_get_level();

        ob_start();

        extract($vars);

        // We'll evaluate the contents of the view inside a try/catch block so we can
        // flush out any stray output that might get out before an error occurs or
        // an exception is thrown. This prevents any partial views from leaking.
        try {
            include $filePath;
        } catch (Exception $e) {
            $this->handleViewException($e, $obLevel);
        } catch (Throwable $e) {
            $this->handleViewException(new ErrorException($e->getMessage()), $obLevel);
        }

        return ob_get_clean();
    }

    public function compileFileContent(string $filePath): string
    {
        $compiler = resolve('blade.compiler');

        if ($compiler->isExpired($filePath)) {
            $compiler->compile($filePath);
        }

        return $compiler->getCompiledPath($filePath);
    }

    public function makeViewContent(string $view, array $data = []): string
    {
        $view = view()->make($view, array_merge($this->vars, $data));

        View::callComposer($view);

        return $this->makeFileContent(
            view()->getFinder()->find($view->name()),
            $view->getData(),
        );
    }

    /**
     * Handle a view exception.
     */
    protected function handleViewException(Exception $e, int $obLevel): void
    {
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }

        throw $e;
    }

    /**
     * Get the data bound to the view instance.
     */
    protected function gatherViewData(array $data): array
    {
        $data = array_merge(View::getShared(), $data);

        return array_map(function($value) {
            if ($value instanceof Renderable) {
                return $value->render();
            }

            return $value;
        }, $data);
    }
}
