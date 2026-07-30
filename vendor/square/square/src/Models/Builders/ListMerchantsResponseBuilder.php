<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\ListMerchantsResponse;

/**
 * Builder for model ListMerchantsResponse
 *
 * @see ListMerchantsResponse
 */
class ListMerchantsResponseBuilder
{
    /**
     * @var ListMerchantsResponse
     */
    private $instance;

    private function __construct(ListMerchantsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new list merchants response Builder object.
     */
    public static function init(): self
    {
        return new self(new ListMerchantsResponse());
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
     * Sets merchant field.
     */
    public function merchant(?array $value): self
    {
        $this->instance->setMerchant($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?int $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Initializes a new list merchants response object.
     */
    public function build(): ListMerchantsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
