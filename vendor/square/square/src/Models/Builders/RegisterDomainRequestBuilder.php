<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\RegisterDomainRequest;

/**
 * Builder for model RegisterDomainRequest
 *
 * @see RegisterDomainRequest
 */
class RegisterDomainRequestBuilder
{
    /**
     * @var RegisterDomainRequest
     */
    private $instance;

    private function __construct(RegisterDomainRequest $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new register domain request Builder object.
     */
    public static function init(string $domainName): self
    {
        return new self(new RegisterDomainRequest($domainName));
    }

    /**
     * Initializes a new register domain request object.
     */
    public function build(): RegisterDomainRequest
    {
        return CoreHelper::clone($this->instance);
    }
}
