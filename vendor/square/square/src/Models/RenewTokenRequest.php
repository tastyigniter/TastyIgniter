<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class RenewTokenRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $accessToken = [];

    /**
     * Returns Access Token.
     * The token you want to renew.
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
     * The token you want to renew.
     *
     * @maps access_token
     */
    public function setAccessToken(?string $accessToken): void
    {
        $this->accessToken['value'] = $accessToken;
    }

    /**
     * Unsets Access Token.
     * The token you want to renew.
     */
    public function unsetAccessToken(): void
    {
        $this->accessToken = [];
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
        if (!empty($this->accessToken)) {
            $json['access_token'] = $this->accessToken['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
