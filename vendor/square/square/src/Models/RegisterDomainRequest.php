<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the parameters that can be included in the body of
 * a request to the [RegisterDomain]($e/ApplePay/RegisterDomain) endpoint.
 */
class RegisterDomainRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $domainName;

    /**
     * @param string $domainName
     */
    public function __construct(string $domainName)
    {
        $this->domainName = $domainName;
    }

    /**
     * Returns Domain Name.
     * A domain name as described in RFC-1034 that will be registered with ApplePay.
     */
    public function getDomainName(): string
    {
        return $this->domainName;
    }

    /**
     * Sets Domain Name.
     * A domain name as described in RFC-1034 that will be registered with ApplePay.
     *
     * @required
     * @maps domain_name
     */
    public function setDomainName(string $domainName): void
    {
        $this->domainName = $domainName;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        $json['domain_name'] = $this->domainName;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
