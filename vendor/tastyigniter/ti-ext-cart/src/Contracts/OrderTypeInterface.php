<?php

declare(strict_types=1);

namespace Igniter\Cart\Contracts;

interface OrderTypeInterface
{
    public function getOpenDescription(): string;

    public function getOpeningDescription(string $format): string;

    public function getClosedDescription(): string;

    public function getDisabledDescription(): string;

    public function isActive(): bool;

    public function isDisabled(): bool;
}
