<?php

namespace Main\Template\Concerns;

use Igniter\Flame\Pagic\Parsers\FileParser;
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

    /**
     * Returns component property names and values.
     * This method implements caching and can be used in the run-time on the front-end.
     *
     * @param string $componentName Specifies the component name.
     *
     * @return array Returns an associative array with property names in the keys and property values in the values.
     */
    public function getComponentProperties($componentName)
    {
        $key = md5($this->theme->getPath()).'component-properties';

        if (self::$objectComponentPropertyMap !== null) {
            $objectComponentMap = self::$objectComponentPropertyMap;
        }
        else {
            $cached = Cache::get($key, FALSE);
            $unserialized = $cached ? @unserialize(@base64_decode($cached)) : FALSE;
            $objectComponentMap = $unserialized ? $unserialized : [];
            if ($objectComponentMap) {
                self::$objectComponentPropertyMap = $objectComponentMap;
            }
        }

        $objectCode = $this->getBaseFileName();

        if (array_key_exists($objectCode, $objectComponentMap)) {
            if (array_key_exists($componentName, $objectComponentMap[$objectCode])) {
                return $objectComponentMap[$objectCode][$componentName];
            }

            return [];
        }

        if (!isset($this->settings['components'])) {
            $objectComponentMap[$objectCode] = [];
        }
        else {
            foreach ($this->settings['components'] as $name => $settings) {
                $nameParts = explode(' ', $name);
                if (count($nameParts > 1)) {
                    $name = trim($nameParts[0]);
                }

                $component = $this->getComponent($name);
                if (!$component) {
                    continue;
                }

                $componentProperties = [];
                $propertyDefinitions = $component->defineProperties();
                foreach ($propertyDefinitions as $propertyName => $propertyInfo) {
                    $componentProperties[$propertyName] = $component->property($propertyName);
                }

                $objectComponentMap[$objectCode][$name] = $componentProperties;
            }
        }

        self::$objectComponentPropertyMap = $objectComponentMap;

        Cache::put($key, base64_encode(serialize($objectComponentMap)), Config::get('system.parsedTemplateCacheTTL', 10));

        if (array_key_exists($componentName, $objectComponentMap[$objectCode])) {
            return $objectComponentMap[$objectCode][$componentName];
        }

        return [];
    }
}