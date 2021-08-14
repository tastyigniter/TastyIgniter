<?php

namespace System\Traits;

use Admin\Facades\Template;
use Exception;
use Igniter\Flame\Exception\SystemException;
use Igniter\Flame\Support\Facades\File;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use Throwable;

trait ViewMaker
{
    /**
     * @var array A list of variables to pass to the page.
     */
    public $vars = [];

    /**
     * @var array Specifies a path to the views directory.
     */
    public $viewPath;

    /**
     * @var array Specifies a path to the layout directory.
     */
    public $layoutPath;

    /**
     * @var array Specifies a path to the partials directory.
     */
    public $partialPath;

    /**
     * @var string Layout to use for the view.
     */
    public $layout;

    /**
     * @var bool Prevents the use of a layout.
     */
    public $suppressLayout = FALSE;

    protected $viewFileExtension = ['.blade.php', '.php'];

    public function getViewPath($view, $viewPath = null)
    {
        $view = File::symbolizePath($view);

        if (File::isLocalPath($view, FALSE)) {
            return $this->guessViewFileExtension($view) ?? $view;
        }

        if (!isset($this->viewPath)) {
            $this->viewPath = $this->guessViewPath();
        }

        if (!$viewPath) {
            $viewPath = $this->viewPath;
        }

        if (!is_array($viewPath))
            $viewPath = [$viewPath];

        foreach ($viewPath as $path) {
            if ($vPath = $this->guessViewFileExtension(File::symbolizePath($path).'/'.$view)) {
                return $vPath;
            }
        }

        return $this->guessViewFileExtension($view) ?? $view;
    }

    public function guessViewFileExtension($path)
    {
        if (strlen(File::extension($path)))
            return $path;

        $path = preg_replace('#/+#', '/', $path);

        foreach ($this->viewFileExtension as $viewFileExtension) {
            if (File::isFile($path.$viewFileExtension)) {
                return $path.$viewFileExtension;
            }
        }
    }

    /**
     * Guess the package path from a specified class.
     *
     * @param string $suffix An extra path to attach to the end
     * @param bool $isPublic
     *
     * @return string
     */
    public function guessViewPath($suffix = '', $isPublic = FALSE)
    {
        $classFolder = strtolower(class_basename($class = get_called_class()));
        $classFile = realpath(dirname(File::fromClass(strtolower($class))));

        $guessedPath = $classFile ? $classFile.'/'.$classFolder.$suffix : null;

        return ($isPublic) ? File::localToPublic($guessedPath) : $guessedPath;
    }

    /**
     * Render a layout.
     *
     * @param string $name Specifies the layout name.
     * If this parameter is omitted, the $layout property will be used.
     * @param array $vars Parameter variables to pass to the view.
     * @param bool $throwException Throw an exception if the layout is not found
     *
     * @return mixed The layout contents, or false.
     * @throws \Igniter\Flame\Exception\SystemException
     */
    public function makeLayout($name = null, $vars = [], $throwException = TRUE)
    {
        $layout = $name === null ? $this->layout : $name;
        if ($layout == '') {
            return '';
        }

        $layoutPath = $this->getViewPath($layout, $this->layoutPath);

        if (!File::exists($layoutPath)) {
            if ($throwException)
                throw new SystemException(Lang::get('system::lang.not_found.layout', ['name' => $layoutPath]));

            return FALSE;
        }

        return $this->makeFileContent($layoutPath, $vars);
    }

    /**
     * Loads a view with the name specified.
     * Applies layout if its name is provided by the parent object.
     * The view file must be situated in the views directory, and has the extension "htm" or "php".
     *
     * @param string $view Specifies the view name, without extension. Eg: "index".
     *
     * @return string
     */
    public function makeView($view)
    {
        $viewPath = $this->getViewPath(strtolower($view));
        $contents = $this->makeFileContent($viewPath);

        if ($this->suppressLayout OR $this->layout === '')
            return $contents;

        // Append content to the body template
        Template::setBlock('body', $contents);

        return $this->makeLayout();
    }

    /**
     * Render a partial file contents located in the views or partial folder.
     *
     * @param string $partial The view to load.
     * @param array $vars Parameter variables to pass to the view.
     * @param bool $throwException Throw an exception if the partial is not found.
     *
     * @return mixed Partial contents or false if not throwing an exception.
     * @throws \Igniter\Flame\Exception\SystemException
     */
    public function makePartial($partial, $vars = [], $throwException = TRUE)
    {
        $partial = strtolower($partial);

        $partialPath = $this->getViewPath($partial, $this->partialPath);

        if (!File::exists($partialPath)) {
            if ($throwException)
                throw new SystemException(Lang::get('system::lang.not_found.partial', ['name' => $partialPath]));

            return FALSE;
        }

        if (isset($this->controller))
            $vars = array_merge($this->controller->vars, $vars);

        return $this->makeFileContent($partialPath, $vars);
    }

    /**
     * Includes a file path using output buffering.
     * Ensures that vars are available.
     *
     * @param string $filePath Absolute path to the view file.
     * @param array $extraParams Parameters that should be available to the view.
     *
     * @return string
     */
    public function makeFileContent($filePath, $extraParams = [])
    {
        if (!strlen($filePath) OR $filePath == 'index.php' OR !File::isFile($filePath)) {
            return '';
        }

        if (!is_array($extraParams)) {
            $extraParams = [];
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
        }
        catch (Exception $e) {
            $this->handleViewException($e, $obLevel);
        }
        catch (Throwable $e) {
            $this->handleViewException(new FatalThrowableError($e), $obLevel);
        }

        return ob_get_clean();
    }

    public function compileFileContent($filePath)
    {
        $pagic = App::make('pagic.environment');

        $compiler = $pagic->getCompiler();

        if ($compiler->isExpired($filePath)) {
            $compiler->compile($filePath);
        }

        return $compiler->getCompiledPath($filePath);
    }

    /**
     * Handle a view exception.
     *
     * @param \Exception $e
     * @param int $obLevel
     *
     * @return void
     */
    protected function handleViewException($e, $obLevel)
    {
        while (ob_get_level() > $obLevel) {
            ob_end_clean();
        }

        throw $e;
    }

    /**
     * Get the data bound to the view instance.
     *
     * @param $data
     * @return array
     */
    protected function gatherViewData($data)
    {
        $data = array_merge(View::getShared(), $data);

        return array_map(function ($value) {
            if ($value instanceof Renderable)
                return $value->render();

            return $value;
        }, $data);
    }
}
