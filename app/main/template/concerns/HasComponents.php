<?php

namespace Main\Template\Concerns;

use System\Classes\ComponentManager;

trait HasComponents
{
    public $settings = [
        'components' => [],
    ];

    public $components = [];

    /**
     * Boot the sortable trait for this model.
     *
     * @return void
     */
    public static function bootHasComponents()
    {
        static::retrieving(function ($model) {
        });
    }

    /**
     * Triggered after the object is loaded.
     * @return void
     */
    public function afterRetrieve()
    {
        $this->parseComponentSettings();
        $this->parseSettings();
    }

    public function parseComponentSettings()
    {
        $this->settings = $this->getSettingsAttribute();

        $components = [];
        foreach ($this->settings as $setting => $value) {
            preg_match('/\[(.*?)\]/', $setting, $match);
            if (!isset($match[1]))
                continue;

            $components[$match[1]] = is_array($value) ? $value : [];
            unset($this->settings[$setting]);
        }

        $this->settings['components'] = $components;
    }

    public function parseSettings()
    {
        $this->fillViewBagArray();
    }

    /**
     * Returns a component by its name.
     * This method is used only in the admin and for internal system needs when
     * the standard way to access components is not an option.
     *
     * @param string $componentName Specifies the component name.
     *
     * @return \System\Classes\BaseComponent
     */
    public function getComponent($componentName)
    {
        if (!isset($this->components[$componentName])) {
            return null;
        }

        return $this->components[$componentName];
    }

    /**
     * Checks if the object has a component with the specified name.
     *
     * @param string $componentName Specifies the component name.
     *
     * @return mixed Return false or the full component name used on the page (it could include the alias).
     */
    public function hasComponent($componentName)
    {
        $componentManager = ComponentManager::instance();
        $componentName = $componentManager->resolve($componentName);

        foreach ($this->components as $name => $component) {
            $result = $name;
            if ($name == $componentName)
                return $result;

            $parts = explode(' ', $name);
            if (count($parts) > 1) {
                $name = trim($parts[0]);
                if ($name == $componentName)
                    return $result;
            }

            $name = $componentManager->resolve($name);
            if ($name == $componentName)
                return $result;
        }

        return FALSE;
    }

    public function runComponents()
    {
        foreach ($this->components as $component) {
            if ($result = $component->onRun())
                return $result;
        }
    }
}