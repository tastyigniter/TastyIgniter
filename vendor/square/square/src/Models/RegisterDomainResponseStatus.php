<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * The status of the domain registration.
 */
class RegisterDomainResponseStatus
{
    /**
     * The domain is added, but not verified.
     */
    public const PENDING = 'PENDING';

    /**
     * The domain is added and verified. It can be used to accept Apple Pay transactions.
     */
    public const VERIFIED = 'VERIFIED';
}
