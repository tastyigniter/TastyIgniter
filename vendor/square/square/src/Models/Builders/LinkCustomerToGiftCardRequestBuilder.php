<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\LinkCustomerToGiftCardRequest;

/**
 * Builder for model LinkCustomerToGiftCardRequest
 *
 * @see LinkCustomerToGiftCardRequest
 */
class LinkCustomerToGiftCardRequestBuilder
{
    /**
     * @var LinkCustomerToGiftCardRequest
     */
    private $instance;

    private function __construct(LinkCustomerToGiftCardRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new link customer to gift card request Builder object.
     */
    public static function init(string $customerId): self
    {
        return new self(new LinkCustomerToGiftCardRequest($customerId));
    }

    /**
     * Initializes a new link customer to gift card request object.
     */
    public function build(): LinkCustomerToGiftCardRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
