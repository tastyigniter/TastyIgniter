<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use Igniter\Flame\Support\Extendable;
use Igniter\Flame\Traits\EventEmitter;
use ReflectionMethod;

/**
 * Base Controller Class
 * @deprecated No longer used, will be removed in v5.0.0
 * @codeCoverageIgnore
 */
class BaseController extends Extendable
{
    use EventEmitter;

    /**
     * A list of controller behavours/traits to be implemented
     */
    public array $implement = [];

    /**
     * @var string Page controller class name being called.
     */
    protected $class;

    /**
     * @var string Page method name being called.
     */
    protected $action;

    /**
     * @var array Routed parameters.
     */
    protected $params;

    /**
     * @var array Default actions which cannot be called as actions.
     */
    public $hiddenActions = [
        'checkAction',
        'execPageAction',
        'handleError',
    ];

    /**
     * @var array Array of actions available without authentication.
     */
    protected $publicActions = [];

    /**
     * @var int Response status code
     */
    protected $statusCode = 200;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->class = Controller::$class;
        $this->action = Controller::$action;
        $this->params = Controller::$segments;

        $this->extendableConstruct();

        $this->fireSystemEvent('main.controller.beforeConstructor', [$this]);
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function checkAction($action)
    {
        if (!$methodExists = $this->methodExists($action)) {
            return false;
        }

        if (in_array(strtolower((string)$action), array_map('strtolower', $this->hiddenActions), true)) {
            return false;
        }

        if ($ownMethod = method_exists($this, $action)) {
            $methodInfo = new ReflectionMethod($this, $action);

            return $methodInfo->isPublic();
        }

        return $methodExists;
    }

    public function setStatusCode($code): void
    {
        $this->statusCode = $code;
    }
}
