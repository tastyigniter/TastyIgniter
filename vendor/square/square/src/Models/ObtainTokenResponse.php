<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ObtainTokenResponse implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $accessToken;

    /**
     * @var string|null
     */
    private $tokenType;

    /**
     * @var string|null
     */
    private $expiresAt;

    /**
     * @var string|null
     */
    private $merchantId;

    /**
     * @var string|null
     */
    private $subscriptionId;

    /**
     * @var string|null
     */
    private $planId;

    /**
     * @var string|null
     */
    private $idToken;

    /**
     * @var string|null
     */
    private $refreshToken;

    /**
     * @var bool|null
     */
    private $shortLived;

    /**
     * @var Error[]|null
     */
    private $errors;

    /**
     * @var string|null
     */
    private $refreshTokenExpiresAt;

    /**
     * Returns Access Token.
     * A valid OAuth access token. OAuth access tokens are 64 bytes long.
     * Provide the access token in a header with every request to Connect API
     * endpoints. For more information, see [OAuth API: Walkthrough](https://developer.squareup.
     * com/docs/oauth-api/walkthrough).
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * Sets Access Token.
     * A valid OAuth access token. OAuth access tokens are 64 bytes long.
     * Provide the access token in a header with every request to Connect API
     * endpoints. For more information, see [OAuth API: Walkthrough](https://developer.squareup.
     * com/docs/oauth-api/walkthrough).
     *
     * @maps access_token
     */
    public function setAccessToken(?string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Returns Token Type.
     * This value is always _bearer_.
     */
    public function getTokenType(): ?string
    {
        return $this->tokenType;
    }

    /**
     * Sets Token Type.
     * This value is always _bearer_.
     *
     * @maps token_type
     */
    public function setTokenType(?string $tokenType): void
    {
        $this->tokenType = $tokenType;
    }

    /**
     * Returns Expires At.
     * The date when the `access_token` expires, in [ISO 8601](http://www.iso.
     * org/iso/home/standards/iso8601.htm) format.
     */
    public function getExpiresAt(): ?string
    {
        return $this->expiresAt;
    }

    /**
     * Sets Expires At.
     * The date when the `access_token` expires, in [ISO 8601](http://www.iso.
     * org/iso/home/standards/iso8601.htm) format.
     *
     * @maps expires_at
     */
    public function setExpiresAt(?string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
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
     * Returns Subscription Id.
     * __LEGACY FIELD__. The ID of a subscription plan the merchant signed up
     * for. The ID is only present if the merchant signed up for a subscription plan during authorization.
     */
    public function getSubscriptionId(): ?string
    {
        return $this->subscriptionId;
    }

    /**
     * Sets Subscription Id.
     * __LEGACY FIELD__. The ID of a subscription plan the merchant signed up
     * for. The ID is only present if the merchant signed up for a subscription plan during authorization.
     *
     * @maps subscription_id
     */
    public function setSubscriptionId(?string $subscriptionId): void
    {
        $this->subscriptionId = $subscriptionId;
    }

    /**
     * Returns Plan Id.
     * __LEGACY FIELD__. The ID of the subscription plan the merchant signed
     * up for. The ID is only present if the merchant signed up for a subscription plan during
     * authorization.
     */
    public function getPlanId(): ?string
    {
        return $this->planId;
    }

    /**
     * Sets Plan Id.
     * __LEGACY FIELD__. The ID of the subscription plan the merchant signed
     * up for. The ID is only present if the merchant signed up for a subscription plan during
     * authorization.
     *
     * @maps plan_id
     */
    public function setPlanId(?string $planId): void
    {
        $this->planId = $planId;
    }

    /**
     * Returns Id Token.
     * The OpenID token belonging to this person. This token is only present if the
     * OPENID scope is included in the authorization request.
     */
    public function getIdToken(): ?string
    {
        return $this->idToken;
    }

    /**
     * Sets Id Token.
     * The OpenID token belonging to this person. This token is only present if the
     * OPENID scope is included in the authorization request.
     *
     * @maps id_token
     */
    public function setIdToken(?string $idToken): void
    {
        $this->idToken = $idToken;
    }

    /**
     * Returns Refresh Token.
     * A refresh token. OAuth refresh tokens are 64 bytes long.
     * For more information, see [Refresh, Revoke, and Limit the Scope of OAuth Tokens](https://developer.
     * squareup.com/docs/oauth-api/refresh-revoke-limit-scope).
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * Sets Refresh Token.
     * A refresh token. OAuth refresh tokens are 64 bytes long.
     * For more information, see [Refresh, Revoke, and Limit the Scope of OAuth Tokens](https://developer.
     * squareup.com/docs/oauth-api/refresh-revoke-limit-scope).
     *
     * @maps refresh_token
     */
    public function setRefreshToken(?string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * Returns Short Lived.
     * A Boolean indicating that the access token is a short-lived access token.
     * The short-lived access token returned in the response expires in 24 hours.
     */
    public function getShortLived(): ?bool
    {
        return $this->shortLived;
    }

    /**
     * Sets Short Lived.
     * A Boolean indicating that the access token is a short-lived access token.
     * The short-lived access token returned in the response expires in 24 hours.
     *
     * @maps short_lived
     */
    public function setShortLived(?bool $shortLived): void
    {
        $this->shortLived = $shortLived;
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
     * Returns Refresh Token Expires At.
     * The date when the `refresh_token` expires, in [ISO 8601](http://www.iso.
     * org/iso/home/standards/iso8601.htm) format.
     */
    public function getRefreshTokenExpiresAt(): ?string
    {
        return $this->refreshTokenExpiresAt;
    }

    /**
     * Sets Refresh Token Expires At.
     * The date when the `refresh_token` expires, in [ISO 8601](http://www.iso.
     * org/iso/home/standards/iso8601.htm) format.
     *
     * @maps refresh_token_expires_at
     */
    public function setRefreshTokenExpiresAt(?string $refreshTokenExpiresAt): void
    {
        $this->refreshTokenExpiresAt = $refreshTokenExpiresAt;
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
        if (isset($this->accessToken)) {
            $json['access_token']             = $this->accessToken;
        }
        if (isset($this->tokenType)) {
            $json['token_type']               = $this->tokenType;
        }
        if (isset($this->expiresAt)) {
            $json['expires_at']               = $this->expiresAt;
        }
        if (isset($this->merchantId)) {
            $json['merchant_id']              = $this->merchantId;
        }
        if (isset($this->subscriptionId)) {
            $json['subscription_id']          = $this->subscriptionId;
        }
        if (isset($this->planId)) {
            $json['plan_id']                  = $this->planId;
        }
        if (isset($this->idToken)) {
            $json['id_token']                 = $this->idToken;
        }
        if (isset($this->refreshToken)) {
            $json['refresh_token']            = $this->refreshToken;
        }
        if (isset($this->shortLived)) {
            $json['short_lived']              = $this->shortLived;
        }
        if (isset($this->errors)) {
            $json['errors']                   = $this->errors;
        }
        if (isset($this->refreshTokenExpiresAt)) {
            $json['refresh_token_expires_at'] = $this->refreshTokenExpiresAt;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
