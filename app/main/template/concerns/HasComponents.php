<?php

namespace Main\Template\Concerns;

use System\Classes\ComponentManager;

trait HasComponents
{
    /**
     * @var \System\Classes\BaseComponent[]
     */
    public $components = [];

    /**
     * Boot the sortable trait for this model.
     *
     * @return void
     */
    public static function bootHasComponents()
    {
        static::retrieved(function (self $model) {
            $model->parseComponentSettings();
        });
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
        if (!($name = $this->hasComponent($componentName)))
            return null;

        return ComponentManager::instance()->makeComponent(
            $componentName,
            null,
            $this->settings['components'][$name]
        );
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

        foreach ($this->settings['components'] as $name => $values) {
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
            if ($event = $component->fireEvent('component.beforeRun', [], TRUE))
                return $event;

            if ($result = $component->onRun())
                return $result;

            if ($event = $component->fireEvent('component.run', [], TRUE))
                return $event;
        }
    }

    public function updateComponent($alias, array $properties)
    {
        $attributes = $this->attributes;

        $newAlias = array_get($properties, 'alias');
        if ($newAlias AND $newAlias !== $alias) {
            $attributes = array_replace_key($attributes, $alias, $newAlias);
            $alias = $newAlias;
        }

        $attributes[$alias] = array_except($properties, 'alias');

        $this->attributes = $attributes;

        return $this->save();
    }
}