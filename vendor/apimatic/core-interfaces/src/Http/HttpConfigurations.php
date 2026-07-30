<?php

namespace CoreInterfaces\Http;

interface HttpConfigurations
{
    /**
     * Get timeout for API calls in seconds.
     */
    public function getTimeout(): int;

    /**
     * Get whether to enable retries and backoff feature.
     */
    public function shouldEnableRetries(): bool;

    /**
     * Get the number of retries to make.
     */
    public function getNumberOfRetries(): int;

    /**
     * Get the retry time interval between the endpoint calls.
     */
    public function getRetryInterval(): float;

    /**
     * Get exponential backoff factor to increase interval between retries.
     */
    public function getBackOffFactor(): float;

    /**
     * Get the maximum wait time in seconds for overall retrying requests.
     */
    public function getMaximumRetryWaitTime(): int;

    /**
     * Get whether to retry on request timeout.
     */
    public function shouldRetryOnTimeout(): bool;

    /**
     * Get http status codes to retry against.
     */
    public function getHttpStatusCodesToRetry(): array;

    /**
     * Get http methods to retry against.
     */
    public function getHttpMethodsToRetry(): array;
}
