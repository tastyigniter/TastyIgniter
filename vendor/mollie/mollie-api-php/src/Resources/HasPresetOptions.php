<?php

namespace Mollie\Api\Resources;

use Mollie\Api\MollieApiClient;

/**
 * @property MollieApiClient $client
 * @property string $mode
 */
trait HasPresetOptions
{
    /**
     * When accessed by oAuth we want to pass the testmode by default
     *
     * @return array
     */
    protected function getPresetOptions()
    {
        $options = [];
        if ($this->client->usesOAuth()) {
            $options["testmode"] = $this->mode === "test" ? true : false;
        }

        return $options;
    }

    /**
     * Apply the preset options.
     *
     * @param array $options
     * @return array
     */
    protected function withPresetOptions(array $options)
    {
        return array_merge($this->getPresetOptions(), $options);
    }
}
