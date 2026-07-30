<?php

namespace Mollie\Api\HttpAdapter;

use Mollie\Api\Exceptions\UnrecognizedClientException;

class MollieHttpAdapterPicker implements MollieHttpAdapterPickerInterface
{
    /**
     * @param \GuzzleHttp\ClientInterface|\Mollie\Api\HttpAdapter\MollieHttpAdapterInterface|null|\stdClass $httpClient
     *
     * @return \Mollie\Api\HttpAdapter\MollieHttpAdapterInterface
     * @throws \Mollie\Api\Exceptions\UnrecognizedClientException
     */
    public function pickHttpAdapter($httpClient)
    {
        if (! $httpClient) {
            if ($this->guzzleIsDetected()) {
                $guzzleVersion = $this->guzzleMajorVersionNumber();

                if ($guzzleVersion && in_array($guzzleVersion, [6, 7])) {
                    return Guzzle6And7MollieHttpAdapter::createDefault();
                }
            }

            return new CurlMollieHttpAdapter;
        }

        if ($httpClient instanceof MollieHttpAdapterInterface) {
            return $httpClient;
        }

        if ($httpClient instanceof \GuzzleHttp\ClientInterface) {
            return new Guzzle6And7MollieHttpAdapter($httpClient);
        }

        throw new UnrecognizedClientException('The provided http client or adapter was not recognized.');
    }

    /**
     * @return bool
     */
    private function guzzleIsDetected()
    {
        return interface_exists('\\' . \GuzzleHttp\ClientInterface::class);
    }

    /**
     * @return int|null
     */
    private function guzzleMajorVersionNumber()
    {
        // Guzzle 7
        if (defined('\GuzzleHttp\ClientInterface::MAJOR_VERSION')) {
            return (int) \GuzzleHttp\ClientInterface::MAJOR_VERSION;
        }

        // Before Guzzle 7
        if (defined('\GuzzleHttp\ClientInterface::VERSION')) {
            return (int) \GuzzleHttp\ClientInterface::VERSION[0];
        }

        return null;
    }
}
