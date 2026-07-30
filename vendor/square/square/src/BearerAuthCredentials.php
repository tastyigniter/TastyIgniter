<?php

declare(strict_types=1);

namespace Square;

/**
 * Interface for defining the behavior of Authentication.
 */
interface BearerAuthCredentials
{
    /**
     * String value for accessToken.
     */
    public function getAccessToken(): string;

    /**
     * Checks if provided credentials match with existing ones.
     *
     * @param string $accessToken The OAuth 2.0 Access Token to use for API requests.
     */
    public function equals(string $accessToken): bool;
}
