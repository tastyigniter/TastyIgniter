<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\SearchVendorsResponse;

/**
 * Builder for model SearchVendorsResponse
 *
 * @see SearchVendorsResponse
 */
class SearchVendorsResponseBuilder
{
    /**
     * @var SearchVendorsResponse
     */
    private $instance;

    private function __construct(SearchVendorsResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new search vendors response Builder object.
     */
    public static function init(): self
    {
        return new self(new SearchVendorsResponse());
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
     * Sets vendors field.
     */
    public function vendors(?array $value): self
    {
        $this->instance->setVendors($value);
        return $this;
    }

    /**
     * Sets cursor field.
     */
    public function cursor(?string $value): self
    {
        $this->instance->setCursor($value);
        return $this;
    }

    /**
     * Initializes a new search vendors response object.
     */
    public function build(): SearchVendorsResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
