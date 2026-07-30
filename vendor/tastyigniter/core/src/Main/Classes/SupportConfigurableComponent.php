<?php

declare(strict_types=1);

namespace Igniter\Main\Classes;

use Igniter\Main\Traits\ConfigurableComponent;
use Livewire\ComponentHook;

class SupportConfigurableComponent extends ComponentHook
{
    public function mount($params, $key): void
    {
        if (!in_array(ConfigurableComponent::class, class_uses_recursive($this->component))) {
            return;
        }

        $componentName = $this->component->getName();
        if ($this->component->getAlias()) {
            $componentName .= ' '.$this->component->getAlias();
        }

        $properties = controller()->getConfiguredComponent($componentName);
        $this->component->fill($properties);
    }
}
