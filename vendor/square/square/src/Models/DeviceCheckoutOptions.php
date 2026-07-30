<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class DeviceCheckoutOptions implements \JsonSerializable
{
    /**
     * @var string
     */
    private $deviceId;

    /**
     * @var array
     */
    private $skipReceiptScreen = [];

    /**
     * @var array
     */
    private $collectSignature = [];

    /**
     * @var TipSettings|null
     */
    private $tipSettings;

    /**
     * @var array
     */
    private $showItemizedCart = [];

    /**
     * @param string $deviceId
     */
    public function __construct(string $deviceId)
    {
        $this->deviceId = $deviceId;
    }

    /**
     * Returns Device Id.
     * The unique ID of the device intended for this `TerminalCheckout`.
     * A list of `DeviceCode` objects can be retrieved from the /v2/devices/codes endpoint.
     * Match a `DeviceCode.device_id` value with `device_id` to get the associated device code.
     */
    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    /**
     * Sets Device Id.
     * The unique ID of the device intended for this `TerminalCheckout`.
     * A list of `DeviceCode` objects can be retrieved from the /v2/devices/codes endpoint.
     * Match a `DeviceCode.device_id` value with `device_id` to get the associated device code.
     *
     * @required
     * @maps device_id
     */
    public function setDeviceId(string $deviceId): void
    {
        $this->deviceId = $deviceId;
    }

    /**
     * Returns Skip Receipt Screen.
     * Instructs the device to skip the receipt screen. Defaults to false.
     */
    public function getSkipReceiptScreen(): ?bool
    {
        if (count($this->skipReceiptScreen) == 0) {
            return null;
        }
        return $this->skipReceiptScreen['value'];
    }

    /**
     * Sets Skip Receipt Screen.
     * Instructs the device to skip the receipt screen. Defaults to false.
     *
     * @maps skip_receipt_screen
     */
    public function setSkipReceiptScreen(?bool $skipReceiptScreen): void
    {
        $this->skipReceiptScreen['value'] = $skipReceiptScreen;
    }

    /**
     * Unsets Skip Receipt Screen.
     * Instructs the device to skip the receipt screen. Defaults to false.
     */
    public function unsetSkipReceiptScreen(): void
    {
        $this->skipReceiptScreen = [];
    }

    /**
     * Returns Collect Signature.
     * Indicates that signature collection is desired during checkout. Defaults to false.
     */
    public function getCollectSignature(): ?bool
    {
        if (count($this->collectSignature) == 0) {
            return null;
        }
        return $this->collectSignature['value'];
    }

    /**
     * Sets Collect Signature.
     * Indicates that signature collection is desired during checkout. Defaults to false.
     *
     * @maps collect_signature
     */
    public function setCollectSignature(?bool $collectSignature): void
    {
        $this->collectSignature['value'] = $collectSignature;
    }

    /**
     * Unsets Collect Signature.
     * Indicates that signature collection is desired during checkout. Defaults to false.
     */
    public function unsetCollectSignature(): void
    {
        $this->collectSignature = [];
    }

    /**
     * Returns Tip Settings.
     */
    public function getTipSettings(): ?TipSettings
    {
        return $this->tipSettings;
    }

    /**
     * Sets Tip Settings.
     *
     * @maps tip_settings
     */
    public function setTipSettings(?TipSettings $tipSettings): void
    {
        $this->tipSettings = $tipSettings;
    }

    /**
     * Returns Show Itemized Cart.
     * Show the itemization screen prior to taking a payment. This field is only meaningful when the
     * checkout includes an order ID. Defaults to true.
     */
    public function getShowItemizedCart(): ?bool
    {
        if (count($this->showItemizedCart) == 0) {
            return null;
        }
        return $this->showItemizedCart['value'];
    }

    /**
     * Sets Show Itemized Cart.
     * Show the itemization screen prior to taking a payment. This field is only meaningful when the
     * checkout includes an order ID. Defaults to true.
     *
     * @maps show_itemized_cart
     */
    public function setShowItemizedCart(?bool $showItemizedCart): void
    {
        $this->showItemizedCart['value'] = $showItemizedCart;
    }

    /**
     * Unsets Show Itemized Cart.
     * Show the itemization screen prior to taking a payment. This field is only meaningful when the
     * checkout includes an order ID. Defaults to true.
     */
    public function unsetShowItemizedCart(): void
    {
        $this->showItemizedCart = [];
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
        $json['device_id']               = $this->deviceId;
        if (!empty($this->skipReceiptScreen)) {
            $json['skip_receipt_screen'] = $this->skipReceiptScreen['value'];
        }
        if (!empty($this->collectSignature)) {
            $json['collect_signature']   = $this->collectSignature['value'];
        }
        if (isset($this->tipSettings)) {
            $json['tip_settings']        = $this->tipSettings;
        }
        if (!empty($this->showItemizedCart)) {
            $json['show_itemized_cart']  = $this->showItemizedCart['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
