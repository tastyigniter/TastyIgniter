<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

abstract class OfficialModelAdapter
{
    abstract public function modelClass(): string;

    public function available(): bool
    {
        return class_exists($this->modelClass());
    }
}
