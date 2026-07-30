<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class RevokeTokenRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $clientId = [];

    /**
     * @var array
     */
    private $accessToken = [];

    /**
     * @var array
     */
    private $merchantId = [];

    /**
     * @var array
     */
    private $revokeOnlyAccessToken = [];

    /**
     * Returns Client Id.
     * The Square-issued ID for your application, which is available in the OAuth page in the
     * [Developer Dashboard](https://developer.squareup.com/apps).
     */
    public function getClientId(): ?string
    {
        if (count($this->clientId) == 0) {
            return null;
        }
        return $this->clientId['value'];
    }

    /**
     * Sets Client Id.
     * The Square-issued ID for your application, which is available in the OAuth page in the
     * [Developer Dashboard](https://developer.squareup.com/apps).
     *
     * @maps client_id
     */
    public function setClientId(?string $clientId): void
    {
        $this->clientId['value'] = $clientId;
    }

    /**
     * Unsets Client Id.
     * The Square-issued ID for your application, which is available in the OAuth page in the
     * [Developer Dashboard](https://developer.squareup.com/apps).
     */
    public function unsetClientId(): void
    {
        $this->clientId = [];
    }

    /**
     * Returns Access Token.
     * The access token of the merchant whose token you want to revoke.
     * Do not provide a value for `merchant_id` if you provide this parameter.
     */
    public function getAccessToken(): ?string
    {
        if (count($this->accessToken) == 0) {
            return null;
        }
        return $this->accessToken['value'];
    }

    /**
     * Sets Access Token.
     * The access token of the merchant whose token you want to revoke.
     * Do not provide a value for `merchant_id` if you provide this parameter.
     *
     * @maps access_token
     */
    public function setAccessToken(?string $accessToken): void
    {
        $this->accessToken['value'] = $accessToken;
    }

    /**
     * Unsets Access Token.
     * The access token of the merchant whose token you want to revoke.
     * Do not provide a value for `merchant_id` if you provide this parameter.
     */
    public function unsetAccessToken(): void
    {
        $this->accessToken = [];
    }

    /**
     * Returns Merchant Id.
     * The ID of the merchant whose token you want to revoke.
     * Do not provide a value for `access_token` if you provide this parameter.
     */
    public function getMerchantId(): ?string
    {
        if (count($this->merchantId) == 0) {
            return null;
        }
        return $this->merchantId['value'];
    }

    /**
     * Sets Merchant Id.
     * The ID of the merchant whose token you want to revoke.
     * Do not provide a value for `access_token` if you provide this parameter.
     *
     * @maps merchant_id
     */
    public function setMerchantId(?string $merchantId): void
    {
        $this->merchantId['value'] = $merchantId;
    }

    /**
     * Unsets Merchant Id.
     * The ID of the merchant whose token you want to revoke.
     * Do not provide a value for `access_token` if you provide this parameter.
     */
    public function unsetMerchantId(): void
    {
        $this->merchantId = [];
    }

    /**
     * Returns Revoke Only Access Token.
     * If `true`, terminate the given single access token, but do not
     * terminate the entire authorization.
     * Default: `false`
     */
    public function getRevokeOnlyAccessToken(): ?bool
    {
        if (count($this->revokeOnlyAccessToken) == 0) {
            return null;
        }
        return $this->revokeOnlyAccessToken['value'];
    }

    /**
     * Sets Revoke Only Access Token.
     * If `true`, terminate the given single access token, but do not
     * terminate the entire authorization.
     * Default: `false`
     *
     * @maps revoke_only_access_token
     */
    public function setRevokeOnlyAccessToken(?bool $revokeOnlyAccessToken): void
    {
        $this->revokeOnlyAccessToken['value'] = $revokeOnlyAccessToken;
    }

    /**
     * Unsets Revoke Only Access Token.
     * If `true`, terminate the given single access token, but do not
     * terminate the entire authorization.
     * Default: `false`
     */
    public function unsetRevokeOnlyAccessToken(): void
    {
        $this->revokeOnlyAccessToken = [];
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
        if (!empty($this->clientId)) {
            $json['client_id']                = $this->clientId['value'];
        }
        if (!empty($this->accessToken)) {
            $json['access_token']             = $this->accessToken['value'];
        }
        if (!empty($this->merchantId)) {
            $json['merchant_id']              = $this->merchantId['value'];
        }
        if (!empty($this->revokeOnlyAccessToken)) {
            $json['revoke_only_access_token'] = $this->revokeOnlyAccessToken['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
