<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveGiftCardFromGANRequest;

/**
 * Builder for model RetrieveGiftCardFromGANRequest
 *
 * @see RetrieveGiftCardFromGANRequest
 */
class RetrieveGiftCardFromGANRequestBuilder
{
    /**
     * @var RetrieveGiftCardFromGANRequest
     */
    private $instance;

    private function __construct(RetrieveGiftCardFromGANRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve gift card from ganrequest Builder object.
     */
    public static function init(string $gan): self
    {
        return new self(new RetrieveGiftCardFromGANRequest($gan));
    }

    /**
     * Initializes a new retrieve gift card from ganrequest object.
     */
    public function build(): RetrieveGiftCardFromGANRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
