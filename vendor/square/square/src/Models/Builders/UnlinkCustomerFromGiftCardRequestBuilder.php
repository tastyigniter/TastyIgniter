<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\UnlinkCustomerFromGiftCardRequest;

/**
 * Builder for model UnlinkCustomerFromGiftCardRequest
 *
 * @see UnlinkCustomerFromGiftCardRequest
 */
class UnlinkCustomerFromGiftCardRequestBuilder
{
    /**
     * @var UnlinkCustomerFromGiftCardRequest
     */
    private $instance;

    private function __construct(UnlinkCustomerFromGiftCardRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new unlink customer from gift card request Builder object.
     */
    public static function init(string $customerId): self
    {
        return new self(new UnlinkCustomerFromGiftCardRequest($customerId));
    }

    /**
     * Initializes a new unlink customer from gift card request object.
     */
    public function build(): UnlinkCustomerFromGiftCardRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
