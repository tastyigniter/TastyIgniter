<?php

declare(strict_types=1);

namespace Igniter\Admin\Classes;

use Igniter\Admin\Traits\WidgetMaker;
use Igniter\Flame\Support\Extendable;
use Igniter\Flame\Traits\EventEmitter;
use Igniter\System\Traits\AssetMaker;
use Igniter\System\Traits\ConfigMaker;
use Igniter\System\Traits\SessionMaker;
use Igniter\System\Traits\ViewMaker;

/**
 * Base Widget Class
 * Adapted from october\backend\classes\WidgetBase
 */
class BaseWidget extends Extendable
{
    use AssetMaker;
    use ConfigMaker;
    use EventEmitter;
    use SessionMaker;
    use ViewMaker;
    use WidgetMaker;

    public ?array $config = null;

    /** Defined alias used for this widget. */
    public ?string $alias = null;

    /** A unique alias to identify this widget. */
    protected string $defaultAlias = 'widget';

    public function __construct(protected AdminController $controller, array $config = [])
    {
        $parts = explode('\\', strtolower(static::class));
        $namespace = implode('.', array_slice($parts, 0, 2));
        $path = implode('/', array_slice($parts, 2));

        // Add paths from the controller context
        $this->partialPath = $this->controller->partialPath;

        // Add paths from the extension / module context
        $this->partialPath[] = 'igniter.admin::_partials.'.$path;
        $this->partialPath[] = 'igniter.admin::_partials.'.dirname($path);
        $this->partialPath[] = $namespace.'::_partials.'.$path;
        $this->partialPath[] = $namespace.'::_partials.'.dirname($path);
        $this->partialPath[] = $namespace.'::_partials';

        // Add paths from the controller context
        $this->partialPath = array_unique($this->partialPath);

        $this->assetPath[] = 'igniter::css/'.dirname($path);
        $this->assetPath[] = 'igniter::js/'.dirname($path);
        $this->assetPath[] = $namespace.'::css/'.dirname($path);
        $this->assetPath[] = $namespace.'::js/'.dirname($path);
        $this->assetPath[] = $namespace.'::css';
        $this->assetPath[] = $namespace.'::js';
        $this->assetPath = array_merge($this->assetPath, $this->controller->assetPath);

        $this->configPath = $this->controller->configPath;

        // Set config values, if a parent constructor hasn't set already.
        if ($this->config === null) {
            $this->setConfig($config);
        }

        if (is_null($this->alias)) {
            $this->alias = $this->config['alias'] ?? $this->defaultAlias;
        }

        $this->loadAssets();

        parent::__construct();

        $this->initialize();
    }

    /**
     * Initialize the widget called by the constructor.
     * @return void
     */
    public function initialize() {}

    /**
     * Renders the widgets primary contents.
     */
    public function render() {}

    /**
     * Reloads the widgets primary contents.
     */
    public function reload(): array
    {
        return [
            '#notification' => $this->makePartial('flash'),
            '~#'.$this->getId() => $this->render(),
        ];
    }

    /**
     * Binds a widget to the controller for safe use.
     */
    public function bindToController(): void
    {
        $this->controller->widgets[$this->alias] = $this;
    }

    /**
     * Transfers config values stored inside the $config property directly
     * on to the root object properties.
     *
     * @return void
     */
    protected function fillFromConfig(?array $properties = null)
    {
        $properties ??= array_keys((array)$this->config);

        foreach ($properties as $property) {
            if (property_exists($this, $property)) {
                $this->{$property} = $this->getConfig($property, $this->{$property});
            }
        }
    }

    /**
     * Returns a unique ID for this widget. Useful in creating HTML markup.
     *
     * @param string $suffix An extra string to append to the ID.
     *
     * @return string A unique identifier.
     */
    public function getId(?string $suffix = null): string
    {
        $id = class_basename(static::class);

        if ($this->alias != $this->defaultAlias) {
            $id .= '-'.$this->alias;
        }

        if ($suffix !== null) {
            $id .= '-'.$suffix;
        }

        return strtolower(name_to_id($id));
    }

    /**
     * Returns a fully qualified event handler name for this widget.
     *
     * @param string $name The ajax event handler name.
     */
    public function getEventHandler(string $name): string
    {
        return $this->alias.'::'.$name;
    }

    /**
     * Returns the controller using this widget.
     */
    public function getController(): AdminController
    {
        return $this->controller;
    }

    /**
     * Sets the widget configuration values
     *
     * @param array $required Required config items
     */
    public function setConfig(array $config, array $required = []): void
    {
        $this->config = $this->makeConfig($config, $required);
    }

    /**
     * Get the widget configuration values.
     *
     * @param ?string $name Config name, supports array names like "field[key]"
     * @param mixed $default Default value if nothing is found
     */
    public function getConfig(?string $name = null, mixed $default = null): mixed
    {
        if (is_null($name)) {
            return $this->config;
        }

        $nameArray = name_to_array($name);

        $fieldName = array_shift($nameArray);
        $result = $this->config[$fieldName] ?? $default;

        foreach ($nameArray as $key) {
            if (!is_array($result) || !array_key_exists($key, $result)) {
                return $default;
            }

            $result = $result[$key];
        }

        return $result;
    }

    /**
     * Adds widget specific asset files.
     * use $this->addCss or $this->addJs
     * @return void
     */
    public function loadAssets() {}

    /**
     * Returns a unique session identifier for this widget and controller action.
     */
    protected function makeSessionKey(): string
    {
        // The controller action is intentionally omitted, session should be shared for all actions
        return 'widget.'.class_basename($this->controller).'-'.$this->getId();
    }
}
