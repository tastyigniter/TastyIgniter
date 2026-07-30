<?php

declare(strict_types=1);

namespace Igniter\Flame\Pagic;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\View;
use Throwable;

class Template
{
    /** A stack of the last compiled templates */
    private array $lastCompiled = [];

    protected $page;

    protected $layout;

    protected $theme;

    protected $param;

    protected $controller;

    protected $session;

    /**
     * This method is for internal use only and should never be called
     * directly (use Environment::load() instead).
     * @internal
     */
    public function __construct(private readonly Environment $env, protected string $path) {}

    /**
     * Renders the template.
     *
     * @param array $data An array of parameters to pass to the template
     *
     * @return string The rendered template
     * @throws Exception
     * @throws Throwable
     */
    public function render(array $data = []): string
    {
        $this->lastCompiled[] = $this->getSourceFilePath();

        $this->mergeGlobals($data);

        unset($data['this']);

        $result = $this->getContents($data);

        array_pop($this->lastCompiled);

        return $result;
    }

    protected function mergeGlobals(array $data): void
    {
        if (array_key_exists('this', $data)) {
            foreach ($data['this'] as $key => $object) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $object;
                }
            }
        }
    }

    protected function getContents(array $data): string
    {
        return $this->evaluatePath($this->path, $this->gatherData($data));
    }

    /**
     * Get the data bound to the view instance.
     */
    protected function gatherData(array $data): array
    {
        $data = array_merge(View::getShared(), $data);

        return array_map(function($value) {
            if ($value instanceof Renderable) {
                return $value->render();
            }

            return $value;
        }, $data);
    }

    protected function evaluatePath(string $path, array $data): string
    {
        $obLevel = ob_get_level();
        ob_start();

        extract($data, EXTR_SKIP);

        // We'll evaluate the contents of the view inside a try/catch block so we can
        // flush out any stray output that might get out before an error occurs or
        // an exception is thrown. This prevents any partial views from leaking.
        try {
            include $path;
        } catch (Throwable $throwable) {
            $this->handleException($throwable, $obLevel);
        }

        return ltrim(ob_get_clean());
    }

    protected function handleException(Throwable $ex, $level): void
    {
        while (ob_get_level() > $level) {
            ob_end_clean();
        }

        throw $ex;
    }

    protected function getSourceFilePath(): string
    {
        /** @var Loader $loader */
        $loader = $this->env->getLoader();
        if ($source = $loader->getSource()) {
            return $source->getFilePath();
        }

        return $this->path;
    }
}
