<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * A request to retrieve gift cards by their GANs.
 */
class RetrieveGiftCardFromGANRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $gan;

    /**
     * @param string $gan
     */
    public function __construct(string $gan)
    {
        $this->gan = $gan;
    }

    /**
     * Returns Gan.
     * The gift card account number (GAN) of the gift card to retrieve.
     * The maximum length of a GAN is 255 digits to account for third-party GANs that have been imported.
     * Square-issued gift cards have 16-digit GANs.
     */
    public function getGan(): string
    {
        return $this->gan;
    }

    /**
     * Sets Gan.
     * The gift card account number (GAN) of the gift card to retrieve.
     * The maximum length of a GAN is 255 digits to account for third-party GANs that have been imported.
     * Square-issued gift cards have 16-digit GANs.
     *
     * @required
     * @maps gan
     */
    public function setGan(string $gan): void
    {
        $this->gan = $gan;
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
        $json['gan'] = $this->gan;
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
