<?php

declare(strict_types=1);

namespace Igniter\Admin\Traits;

use Igniter\Flame\Exception\FlashException;
use Igniter\Flame\Support\RouterHelper;
use ReflectionMethod;

trait ControllerUtils
{
    /** Page method name being called. */
    protected string $action = '';

    /** Routed parameters. */
    protected array $params = [];

    /** Default actions which cannot be called as actions. */
    public array $hiddenActions = [
        'checkAction',
        'pageAction',
        'execPageAction',
        'handleError',
        'pageCycle',
    ];

    /** Controller specified methods which cannot be called as actions. */
    protected array $guarded = [];

    protected function setRequiredProperties()
    {
        $slug = request()->route('slug');
        $segments = RouterHelper::segmentizeUrl(is_string($slug) ? $slug : '');

        // Apply $guarded methods to hidden actions
        $this->hiddenActions = array_merge($this->hiddenActions, $this->guarded);

        $this->action = $segments[0] ?? 'index';
        $this->params = array_slice($segments, 1);
    }

    public function checkAction(string $action): bool
    {
        if (!$methodExists = $this->handlerMethodExists($action)) {
            return false;
        }

        throw_if(in_array(strtolower($action), array_map('strtolower', $this->hiddenActions), true),
            new FlashException(sprintf('Method [%s] is not allowed in the controller [%s]', $action, $this::class)),
        );

        if (method_exists($this, $action)) {
            $methodInfo = new ReflectionMethod($this, $action);

            return $methodInfo->isPublic();
        }

        return $methodExists;
    }

    /** @noRector \Rector\TypeDeclaration\Rector\ClassMethod\AddParamStringTypeFromSprintfUseRector */
    public function callAction($method, $parameters)
    {
        $this->action = $method === 'remap' ? $this->action : $method;

        if (method_exists($this, 'initialize')) {
            $this->initialize();
        }

        throw_unless($this->checkAction($method), new FlashException(
            sprintf('Method [%s] is not found in the controller [%s]', $method, $this::class),
        ));

        if (method_exists($this, 'remap')) {
            return $this->remap($this->action, $this->params);
        }

        return $this->{$method}(...$parameters);
    }

    public function getClass(): string
    {
        return $this::class;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    protected function runHandler(string $handler, array $params = [], $action = null): mixed
    {
        $pageHandler = $handler;
        if (!is_null($action)) {
            $pageHandler = $action.'_'.$handler;
        }

        if ($this->handlerMethodExists($pageHandler)) {
            $result = call_user_func_array([$this, $pageHandler], array_values($params));

            return $result ?: true;
        }

        // Process page global handler (onSomething)
        if ($this->handlerMethodExists($handler)) {
            $result = call_user_func_array([$this, $handler], array_values($params));

            return $result ?: true;
        }

        return null;
    }

    protected function handlerMethodExists(string $handler): bool
    {
        return method_exists($this, 'methodExists')
            ? $this->methodExists($handler)
            : method_exists($this, $handler);
    }

    //
    // Extendable
    //

    public function __get(string $name): mixed
    {
        return $this->extendableGet($name);
    }

    public function __set(string $name, mixed $value): void
    {
        $this->extendableSet($name, $value);
    }

    public function __call($method, $parameters): mixed
    {
        return $this->extendableCall($method, $parameters);
    }

    public static function __callStatic(string $name, array $params): mixed
    {
        return self::extendableCallStatic($name, $params);
    }

    public static function extend(callable $callback): void
    {
        self::extendableExtendCallback($callback);
    }
}
