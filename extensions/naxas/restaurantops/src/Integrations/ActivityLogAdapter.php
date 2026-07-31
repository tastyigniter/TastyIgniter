<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Integrations;

use Naxas\RestaurantOps\Contracts\AuditLogger;
use Psr\Log\LoggerInterface;

final class ActivityLogAdapter implements AuditLogger
{
    public function __construct(private readonly LoggerInterface $log) {}

    public function info(string $message, array $context = []): void
    {
        $this->log->info($message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->log->warning($message, $context);
    }
}
