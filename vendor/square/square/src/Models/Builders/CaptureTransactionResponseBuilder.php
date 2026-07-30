<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CaptureTransactionResponse;

/**
 * Builder for model CaptureTransactionResponse
 *
 * @see CaptureTransactionResponse
 */
class CaptureTransactionResponseBuilder
{
    /**
     * @var CaptureTransactionResponse
     */
    private $instance;

    private function __construct(CaptureTransactionResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new capture transaction response Builder object.
     */
    public static function init(): self
    {
        return new self(new CaptureTransactionResponse());
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new capture transaction response object.
     */
    public function build(): CaptureTransactionResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
