<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CreateDeviceCodeRequest;
use Square\Models\DeviceCode;

/**
 * Builder for model CreateDeviceCodeRequest
 *
 * @see CreateDeviceCodeRequest
 */
class CreateDeviceCodeRequestBuilder
{
    /**
     * @var CreateDeviceCodeRequest
     */
    private $instance;

    private function __construct(CreateDeviceCodeRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new create device code request Builder object.
     */
    public static function init(string $idempotencyKey, DeviceCode $deviceCode): self
    {
        return new self(new CreateDeviceCodeRequest($idempotencyKey, $deviceCode));
    }

    /**
     * Initializes a new create device code request object.
     */
    public function build(): CreateDeviceCodeRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
