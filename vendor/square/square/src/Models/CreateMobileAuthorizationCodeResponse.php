<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the `CreateMobileAuthorizationCode` endpoint.
 */
class CreateMobileAuthorizationCodeResponse implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $authorizationCode;

    /**
     * @var string|null
     */
    private $expiresAt;

    /**
     * @var Error|null
     */
    private $error;

    /**
     * Returns Authorization Code.
     * The generated authorization code that connects a mobile application instance
     * to a Square account.
     */
    public function getAuthorizationCode(): ?string
    {
        return $this->authorizationCode;
    }

    /**
     * Sets Authorization Code.
     * The generated authorization code that connects a mobile application instance
     * to a Square account.
     *
     * @maps authorization_code
     */
    public function setAuthorizationCode(?string $authorizationCode): void
    {
        $this->authorizationCode = $authorizationCode;
    }

    /**
     * Returns Expires At.
     * The timestamp when `authorization_code` expires, in
     * [RFC 3339](https://tools.ietf.org/html/rfc3339) format (for example, "2016-09-04T23:59:33.123Z").
     */
    public function getExpiresAt(): ?string
    {
        return $this->expiresAt;
    }

    /**
     * Sets Expires At.
     * The timestamp when `authorization_code` expires, in
     * [RFC 3339](https://tools.ietf.org/html/rfc3339) format (for example, "2016-09-04T23:59:33.123Z").
     *
     * @maps expires_at
     */
    public function setExpiresAt(?string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * Returns Error.
     * Represents an error encountered during a request to the Connect API.
     *
     * See [Handling errors](https://developer.squareup.com/docs/build-basics/handling-errors) for more
     * information.
     */
    public function getError(): ?Error
    {
        return $this->error;
    }

    /**
     * Sets Error.
     * Represents an error encountered during a request to the Connect API.
     *
     * See [Handling errors](https://developer.squareup.com/docs/build-basics/handling-errors) for more
     * information.
     *
     * @maps error
     */
    public function setError(?Error $error): void
    {
        $this->error = $error;
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
        if (isset($this->authorizationCode)) {
            $json['authorization_code'] = $this->authorizationCode;
        }
        if (isset($this->expiresAt)) {
            $json['expires_at']         = $this->expiresAt;
        }
        if (isset($this->error)) {
            $json['error']              = $this->error;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
