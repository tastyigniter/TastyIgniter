<?php

declare(strict_types=1);

namespace Igniter\System\Classes;

use BadMethodCallException;
use Igniter\Flame\Pagic\TemplateCode;
use Igniter\Flame\Support\Extendable;
use Igniter\Flame\Traits\EventEmitter;
use Igniter\Main\Classes\MainController;
use Igniter\System\Traits\AssetMaker;
use Igniter\System\Traits\PropertyContainer;
use Illuminate\Support\Facades\Lang;
use Override;
use Stringable;

/**
 * Base Component Class
 */
abstract class BaseComponent extends Extendable implements Stringable
{
    use AssetMaker;
    use EventEmitter;
    use PropertyContainer;

    public $defaultPartial = 'default';

    /** Alias used for this component. */
    public ?string $alias = null;

    /** Component class name or class alias. */
    public ?string $name = null;

    /** Determines whether the component is hidden from the admin UI. */
    public bool $isHidden = false;

    /** Icon of the extension that defines the component. * This field is used internally.
     */
    public ?string $extensionIcon = null;

    protected ?string $path = null;

    /** Specifies the component directory name. */
    protected ?string $dirName = null;

    /** Holds the component layout settings array. */
    protected array $properties = [];

    protected ?MainController $controller = null;

    protected ?TemplateCode $page = null;

    public function __construct(?TemplateCode $page = null, array $properties = [])
    {
        if ($page instanceof TemplateCode) {
            $this->page = $page;
            $this->controller = $page->controller;
        }

        $this->setProperties($properties);

        $this->dirName = strtolower(str_replace('\\', '/', static::class));
        $namespace = implode('.', array_slice(explode('/', $this->dirName), 0, 2));
        $this->assetPath[] = $namespace.'::assets/'.basename($this->dirName);
        $this->assetPath[] = $namespace.'::assets';
        $this->assetPath[] = $namespace.'::';

        parent::__construct();
    }

    /**
     * Returns the absolute component view path.
     */
    public function getPath(): string
    {
        $namespace = implode('.', array_slice(explode('/', (string)$this->dirName), 0, 2));

        return $namespace.'::views/_components/'.basename((string)$this->dirName);
    }

    /**
     * Executed when this component is first initialized, before AJAX requests.
     */
    public function initialize() {}

    /**
     * Executed when this component is bound to a layout.
     */
    public function onRun() {}

    /**
     * Executed when this component is rendered on a layout.
     */
    public function onRender() {}

    /**
     * Renders a requested partial in context of this component,
     * @see MainController::renderPartial for usage.
     */
    public function renderPartial(): mixed
    {
        $this->controller->setComponentContext($this);
        $result = call_user_func_array([$this->controller, 'renderPartial'], func_get_args());
        $this->controller->setComponentContext(null);

        return $result;
    }

    /**
     * Executes an AJAX handler.
     */
    public function runEventHandler(string $handler): mixed
    {
        $result = $this->{$handler}();

        $this->fireSystemEvent('main.component.afterRunEventHandler', [$handler, &$result]);

        return $result;
    }

    public function getEventHandler(string $handler): string
    {
        return $this->alias.'::'.$handler;
    }

    public function isHidden()
    {
        return $this->isHidden;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public static function resolve(string $name, ?TemplateCode $page = null, array $properties = []): self
    {
        $component = new static($page, $properties);
        $component->setName($name);

        return $component;
    }

    //
    // Property helpers
    //

    public function param(string $name, mixed $default = null): mixed
    {
        $segment = $this->controller->param($name);
        if (is_null($segment)) {
            $segment = input($name);
        }

        return $segment ?? $default;
    }

    //
    // Magic methods
    //

    /**
     * Dynamically handle calls into the controller instance.
     */
    #[Override]
    public function __call(string $name, ?array $params): mixed
    {
        try {
            return parent::__call($name, $params);
        } catch (BadMethodCallException) {
        }

        if (method_exists($this->controller, $name)) {
            return call_user_func_array([$this->controller, $name], $params);
        }

        throw new BadMethodCallException(Lang::get('igniter::main.not_found.method', [
            'name' => static::class,
            'method' => $name,
        ]));
    }

    #[Override]
    public function __toString(): string
    {
        return (string)$this->alias;
    }
}
