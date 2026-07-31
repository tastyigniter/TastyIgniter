<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Contracts;

interface AuditLogger
{
    public function info(string $message, array $context = []): void;

    public function warning(string $message, array $context = []): void;
}
