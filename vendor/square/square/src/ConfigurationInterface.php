<?php

declare(strict_types=1);

namespace Square;

use CoreInterfaces\Http\HttpConfigurations;

/**
 * An interface for all configuration parameters required by the SDK.
 */
interface ConfigurationInterface extends HttpConfigurations
{
    /**
     * Get square Connect API versions
     */
    public function getSquareVersion(): string;

    /**
     * Get additional headers to add to each API call
     */
    public function getAdditionalHeaders(): array;

    /**
     * Get user agent detail, to be appended with user-agent header.
     */
    public function getUserAgentDetail(): string;

    /**
     * Get current API environment
     */
    public function getEnvironment(): string;

    /**
     * Get sets the base URL requests are made to. Defaults to `https://connect.squareup.com`
     */
    public function getCustomUrl(): string;

    /**
     * Get the credentials to use with BearerAuth
     */
    public function getBearerAuthCredentials(): ?BearerAuthCredentials;

    /**
     * Get the base uri for a given server in the current environment.
     *
     * @param string $server Server name
     *
     * @return string Base URI
     */
    public function getBaseUri(string $server = Server::DEFAULT_): string;
}
