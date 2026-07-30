<?php

declare(strict_types=1);

namespace Igniter\Flame\Geolite;

use Igniter\Flame\Geolite\Contracts\LocationInterface;

class AddressMatch
{
    public function __construct(protected array $components) {}

    public function matches(LocationInterface $position): bool
    {
        $matched = collect($this->components)->filter(function($component) use ($position): bool {
            foreach ($component as $item) {
                $type = array_get($item, 'type');
                $value = array_get($item, 'value');

                if ($this->matchComponentValue($position, $type, $value)) {
                    return true;
                }
            }

            return false;
        });

        return $matched->isNotEmpty();
    }

    protected function matchComponentValue(LocationInterface $position, string $type, mixed $value): int|bool
    {
        if (!is_string($value) && !is_numeric($value)) {
            return false;
        }

        switch ($type) {
            case 'street':
                return $this->evalComponentValue(
                    $value, $position->getStreetName()
                );
            case 'sub_locality':
                return $this->evalComponentValue(
                    $value, $position->getSubLocality()
                );
            case 'locality':
                return $this->evalComponentValue(
                    $value, $position->getLocality()
                );
            case 'admin_level_2':
            case 'admin_level_1':
                $adminLevel = $position->getAdminLevels()->get((int)substr($type, -1));

                return $this->evalComponentValue(
                    $value, $adminLevel ? $adminLevel->getName() : null
                );
            case 'postal_code':
                return $this->evalComponentValue(
                    $value, $position->getPostalCode()
                );
        }

        return false;
    }

    protected function evalComponentValue(?string $left, ?string $right): int|bool
    {
        if (empty($right)) {
            return false;
        }

        if (@preg_match($left, '') !== false) {
            return preg_match($left, $right) > 0;
        }

        return strtolower((string)$left) === strtolower($right);
    }
}
