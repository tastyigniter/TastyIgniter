<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

use Illuminate\Contracts\Log\Log;
use Naxas\RestaurantOps\Contracts\AuditLogger;

final class ActivityLogAdapter implements AuditLogger
{
    public function __construct(private readonly Log $log) {}

    public function info(string $message, array $context = []): void
    {
        $this->log->info($message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->log->warning($message, $context);
    }
}
