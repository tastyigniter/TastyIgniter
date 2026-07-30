<?php

declare(strict_types=1);

namespace Igniter\Flame\Exception;

use Throwable;

class MarketplaceException extends SystemException
{
    public function __construct(
        string $message,
        public readonly ?string $errorCode = null,
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }
}
