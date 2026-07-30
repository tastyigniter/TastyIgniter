<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * DeviceCode.Status enum.
 */
class DeviceCodeStatus
{
    /**
     * The status cannot be determined or does not exist.
     */
    public const UNKNOWN = 'UNKNOWN';

    /**
     * The device code is just created and unpaired.
     */
    public const UNPAIRED = 'UNPAIRED';

    /**
     * The device code has been signed in and paired to a device.
     */
    public const PAIRED = 'PAIRED';

    /**
     * The device code was unpaired and expired before it was paired.
     */
    public const EXPIRED = 'EXPIRED';
}
