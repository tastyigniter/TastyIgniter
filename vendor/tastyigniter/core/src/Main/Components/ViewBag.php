<?php

declare(strict_types=1);

namespace Igniter\Main\Components;

use Igniter\System\Classes\BaseComponent;
use Override;

/**
 * The view bag stores custom template properties.
 * This is a hidden component ignored by the back-end UI.
 */
class ViewBag extends BaseComponent
{
    /** This component is hidden from the admin UI. */
    public bool $isHidden = true;

    #[Override]
    public function validateProperties(array $properties): array
    {
        return $properties;
    }

    /**
     * Implements the getter functionality.
     */
    #[Override]
    public function __get(string $name): mixed
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * Determine if an attribute exists on the object.
     */
    public function __isset(string $key): bool
    {
        return array_key_exists($key, $this->properties);
    }

    #[Override]
    public function defineProperties(): array
    {
        $result = [];

        foreach (array_keys($this->properties) as $name) {
            $result[$name] = [
                'title' => $name,
                'type' => 'text',
            ];
        }

        return $result;
    }
}
