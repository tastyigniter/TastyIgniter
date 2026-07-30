<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the fields that are included in the response body of
 * a request to the `RetrieveTokenStatus` endpoint
 */
class RetrieveTokenStatusResponse implements \JsonSerializable
{
    /**
     * @var string[]|null
     */
    private $scopes;

    /**
     * @var string|null
     */
    private $expiresAt;

    /**
     * @var string|null
     */
    private $clientId;

    /**
     * @var string|null
     */
    private $merchantId;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * Returns Scopes.
     * The list of scopes associated with an access token.
     *
     * @return string[]|null
     */
    public function getScopes(): ?array
    {
        return $this->scopes;
    }

    /**
     * Sets Scopes.
     * The list of scopes associated with an access token.
     *
     * @maps scopes
     *
     * @param string[]|null $scopes
     */
    public function setScopes(?array $scopes): void
    {
        $this->scopes = $scopes;
    }

    /**
     * Returns Expires At.
     * The date and time when the `access_token` expires, in RFC 3339 format. Empty if token never expires.
     */
    public function getExpiresAt(): ?string
    {
        return $this->expiresAt;
    }

    /**
     * Sets Expires At.
     * The date and time when the `access_token` expires, in RFC 3339 format. Empty if token never expires.
     *
     * @maps expires_at
     */
    public function setExpiresAt(?string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * Returns Client Id.
     * The Square-issued application ID associated with the access token. This is the same application ID
     * used to obtain the token.
     */
    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    /**
     * Sets Client Id.
     * The Square-issued application ID associated with the access token. This is the same application ID
     * used to obtain the token.
     *
     * @maps client_id
     */
    public function setClientId(?string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * Returns Merchant Id.
     * The ID of the authorizing merchant's business.
     */
    public function getMerchantId(): ?string
    {
        return $this->merchantId;
    }

    /**
     * Sets Merchant Id.
     * The ID of the authorizing merchant's business.
     *
     * @maps merchant_id
     */
    public function setMerchantId(?string $merchantId): void
    {
        $this->merchantId = $merchantId;
    }

    /**
     * Returns Errors.
     * Any errors that occurred during the request.
     *
     * @return Error[]|null
     */
    public function getErrors(): ?array
    {
        return $this->errors;
    }

    /**
     * Sets Errors.
     * Any errors that occurred during the request.
     *
     * @maps errors
     *
     * @param Error[]|null $errors
     */
    public function setErrors(?array $errors): void
    {
        $this->errors = $errors;
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
        if (isset($this->scopes)) {
            $json['scopes']      = $this->scopes;
        }
        if (isset($this->expiresAt)) {
            $json['expires_at']  = $this->expiresAt;
        }
        if (isset($this->clientId)) {
            $json['client_id']   = $this->clientId;
        }
        if (isset($this->merchantId)) {
            $json['merchant_id'] = $this->merchantId;
        }
        if (isset($this->errors)) {
            $json['errors']      = $this->errors;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
