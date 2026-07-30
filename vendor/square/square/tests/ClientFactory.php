<?php

declare(strict_types=1);

namespace Square\Tests;

use Core\Types\CallbackCatcher;

class ClientFactory
{
    public static function create(CallbackCatcher $httpCallback): \Square\SquareClient
    {
        $clientBuilder = \Square\SquareClientBuilder::init();
        $clientBuilder = self::addConfigurationFromEnvironment($clientBuilder);
        $clientBuilder = self::addTestConfiguration($clientBuilder);
        return $clientBuilder->httpCallback($httpCallback)->build();
    }

    public static function addTestConfiguration(\Square\SquareClientBuilder $builder): \Square\SquareClientBuilder
    {
        return $builder;
    }

    public static function addConfigurationFromEnvironment(
        \Square\SquareClientBuilder $builder
    ): \Square\SquareClientBuilder {
        $timeout = getenv('SQUARE_TIMEOUT');
        $numberOfRetries = getenv('SQUARE_NUMBER_OF_RETRIES');
        $maximumRetryWaitTime = getenv('SQUARE_MAXIMUM_RETRY_WAIT_TIME');
        $squareVersion = getenv('SQUARE_SQUARE_VERSION');
        $userAgentDetail = getenv('SQUARE_USER_AGENT_DETAIL');
        $environment = getenv('SQUARE_ENVIRONMENT');
        $customUrl = getenv('SQUARE_CUSTOM_URL');
        $accessToken = getenv('SQUARE_ACCESS_TOKEN');

        if ($timeout !== false && \is_numeric($timeout)) {
            $builder->timeout(intval($timeout));
        }

        if ($numberOfRetries !== false && \is_numeric($numberOfRetries)) {
            $builder->numberOfRetries(intval($numberOfRetries));
        }

        if ($maximumRetryWaitTime !== false && \is_numeric($maximumRetryWaitTime)) {
            $builder->maximumRetryWaitTime(intval($maximumRetryWaitTime));
        }

        if ($squareVersion !== false) {
            $builder->squareVersion($squareVersion);
        }

        if ($userAgentDetail !== false) {
            $builder->userAgentDetail($userAgentDetail);
        }

        if ($environment !== false) {
            $builder->environment($environment);
        }

        if ($customUrl !== false) {
            $builder->customUrl($customUrl);
        }

        if ($accessToken !== false) {
            $builder->accessToken($accessToken);
        }

        return $builder;
    }
}
