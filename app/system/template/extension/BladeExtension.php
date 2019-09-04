<?php

namespace System\Template\Extension;

use Igniter\Flame\Pagic\Extension\AbstractExtension;
use System\Classes\ExtensionManager;

class BladeExtension extends AbstractExtension
{
    /**
     * @var array Cache of registration callbacks.
     */
    protected $callbacks = [];

    /**
     * @var array Globally registered extension items
     */
    protected $items;

    public function __construct()
    {
        $this->extensionManager = ExtensionManager::instance();
    }

    public function getDirectives()
    {
        return $this->listDirectives();
    }

    /**
     * Registers the Blade directives items.
     * The argument is an array of the directives definitions. The array keys represent the
     * directive name, specific for the extension. Each element in the
     * array should be an associative array.
     * @param array $definitions An array of the extension definitions.
     */
    public function registerDirectives(array $definitions)
    {
        if ($this->items === null)
            $this->items = [];

        foreach ($definitions as $name => $callback) {
            $this->items[$name] = $callback;
        }
    }

    /**
     * Returns a list of the registered directives.
     * @return array
     */
    public function listDirectives()
    {
        if ($this->items === null)
            $this->loadDirectives();

        return $this->items ?? [];
    }

    protected function loadDirectives()
    {
        foreach ($this->callbacks as $callback) {
            $callback($this);
        }

        $bundles = $this->extensionManager->getRegistrationMethodValues('registerBladeDirectives');

        foreach ($bundles as $extensionCode => $definitions) {
            $this->registerDirectives($definitions);
        }
    }
}