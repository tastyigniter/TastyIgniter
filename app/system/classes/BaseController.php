<?php

namespace System\Classes;

use Igniter\Flame\Support\Extendable;
use Request;
use Igniter\Flame\Traits\EventEmitter;

/**
 * Base Controller Class
 *
 * @package System
 */
class BaseController extends Extendable
{
    use EventEmitter;

    /**
     * A list of controller behavours/traits to be implemented
     */
    public $implement = [];

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
     * @var object Object used for storing a fatal error.
     */
    protected $fatalError;

    /**
     * @var array Default actions which cannot be called as actions.
     */
    public $hiddenActions = [
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
     * @var array A list of libraries to be auto-loaded
     */
    protected $libraries = [];

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->class = Controller::$class;
        $this->action = Controller::$action;
        $this->params = Controller::$segments;

        $this->extendableConstruct();

        $this->fireEvent('controller.beforeConstructor', [$this]);
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
        if (!$methodExists = $this->methodExists($action))
            return false;

        if (in_array(strtolower($action), array_map('strtolower', $this->hiddenActions)))
            return false;

        if ($ownMethod = method_exists($this, $action)) {
            $methodInfo = new \ReflectionMethod($this, $action);
            return $methodInfo->isPublic();
        }

        return $methodExists;
    }

    public function pageUrl($uri = '', $protocol = null)
    {
        return site_url($uri, $protocol);
    }

    protected function showProfiler()
    {
        if (TI_DEBUG == TRUE AND !is_cli() AND !$this->input->is_ajax_request()) {
            if (!class_exists('Console', FALSE))
                $this->load->library('Console');

            $this->output->enable_profiler(TI_DEBUG);
        }
    }

    public function setStatusCode($code)
    {
        $this->statusCode = $code;
    }

    /**
     * Sets standard page variables in the case of a controller error.
     *
     * @param $exception
     */
    public function handleError($exception)
    {
        $errorMessage = $exception->getMessage();
        $this->fatalError = $errorMessage;
        if (!Request::ajax())
            throw $exception;

        flash()->set('error', $errorMessage);
    }
}