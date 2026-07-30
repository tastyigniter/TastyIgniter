<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RetrieveGiftCardFromNonceRequest;

/**
 * Builder for model RetrieveGiftCardFromNonceRequest
 *
 * @see RetrieveGiftCardFromNonceRequest
 */
class RetrieveGiftCardFromNonceRequestBuilder
{
    /**
     * @var RetrieveGiftCardFromNonceRequest
     */
    private $instance;

    private function __construct(RetrieveGiftCardFromNonceRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve gift card from nonce request Builder object.
     */
    public static function init(string $nonce): self
    {
        return new self(new RetrieveGiftCardFromNonceRequest($nonce));
    }

    /**
     * Initializes a new retrieve gift card from nonce request object.
     */
    public function build(): RetrieveGiftCardFromNonceRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
