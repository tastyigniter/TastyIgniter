<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class DeviceMetadata implements \JsonSerializable
{
    /**
     * @var array
     */
    private $batteryPercentage = [];

    /**
     * @var array
     */
    private $chargingState = [];

    /**
     * @var array
     */
    private $locationId = [];

    /**
     * @var array
     */
    private $merchantId = [];

    /**
     * @var array
     */
    private $networkConnectionType = [];

    /**
     * @var array
     */
    private $paymentRegion = [];

    /**
     * @var array
     */
    private $serialNumber = [];

    /**
     * @var array
     */
    private $osVersion = [];

    /**
     * @var array
     */
    private $appVersion = [];

    /**
     * @var array
     */
    private $wifiNetworkName = [];

    /**
     * @var array
     */
    private $wifiNetworkStrength = [];

    /**
     * @var array
     */
    private $ipAddress = [];

    /**
     * Returns Battery Percentage.
     * The Terminal’s remaining battery percentage, between 1-100.
     */
    public function getBatteryPercentage(): ?string
    {
        if (count($this->batteryPercentage) == 0) {
            return null;
        }
        return $this->batteryPercentage['value'];
    }

    /**
     * Sets Battery Percentage.
     * The Terminal’s remaining battery percentage, between 1-100.
     *
     * @maps battery_percentage
     */
    public function setBatteryPercentage(?string $batteryPercentage): void
    {
        $this->batteryPercentage['value'] = $batteryPercentage;
    }

    /**
     * Unsets Battery Percentage.
     * The Terminal’s remaining battery percentage, between 1-100.
     */
    public function unsetBatteryPercentage(): void
    {
        $this->batteryPercentage = [];
    }

    /**
     * Returns Charging State.
     * The current charging state of the Terminal.
     * Options: `CHARGING`, `NOT_CHARGING`
     */
    public function getChargingState(): ?string
    {
        if (count($this->chargingState) == 0) {
            return null;
        }
        return $this->chargingState['value'];
    }

    /**
     * Sets Charging State.
     * The current charging state of the Terminal.
     * Options: `CHARGING`, `NOT_CHARGING`
     *
     * @maps charging_state
     */
    public function setChargingState(?string $chargingState): void
    {
        $this->chargingState['value'] = $chargingState;
    }

    /**
     * Unsets Charging State.
     * The current charging state of the Terminal.
     * Options: `CHARGING`, `NOT_CHARGING`
     */
    public function unsetChargingState(): void
    {
        $this->chargingState = [];
    }

    /**
     * Returns Location Id.
     * The ID of the Square seller business location associated with the Terminal.
     */
    public function getLocationId(): ?string
    {
        if (count($this->locationId) == 0) {
            return null;
        }
        return $this->locationId['value'];
    }

    /**
     * Sets Location Id.
     * The ID of the Square seller business location associated with the Terminal.
     *
     * @maps location_id
     */
    public function setLocationId(?string $locationId): void
    {
        $this->locationId['value'] = $locationId;
    }

    /**
     * Unsets Location Id.
     * The ID of the Square seller business location associated with the Terminal.
     */
    public function unsetLocationId(): void
    {
        $this->locationId = [];
    }

    /**
     * Returns Merchant Id.
     * The ID of the Square merchant account that is currently signed-in to the Terminal.
     */
    public function getMerchantId(): ?string
    {
        if (count($this->merchantId) == 0) {
            return null;
        }
        return $this->merchantId['value'];
    }

    /**
     * Sets Merchant Id.
     * The ID of the Square merchant account that is currently signed-in to the Terminal.
     *
     * @maps merchant_id
     */
    public function setMerchantId(?string $merchantId): void
    {
        $this->merchantId['value'] = $merchantId;
    }

    /**
     * Unsets Merchant Id.
     * The ID of the Square merchant account that is currently signed-in to the Terminal.
     */
    public function unsetMerchantId(): void
    {
        $this->merchantId = [];
    }

    /**
     * Returns Network Connection Type.
     * The Terminal’s current network connection type.
     * Options: `WIFI`, `ETHERNET`
     */
    public function getNetworkConnectionType(): ?string
    {
        if (count($this->networkConnectionType) == 0) {
            return null;
        }
        return $this->networkConnectionType['value'];
    }

    /**
     * Sets Network Connection Type.
     * The Terminal’s current network connection type.
     * Options: `WIFI`, `ETHERNET`
     *
     * @maps network_connection_type
     */
    public function setNetworkConnectionType(?string $networkConnectionType): void
    {
        $this->networkConnectionType['value'] = $networkConnectionType;
    }

    /**
     * Unsets Network Connection Type.
     * The Terminal’s current network connection type.
     * Options: `WIFI`, `ETHERNET`
     */
    public function unsetNetworkConnectionType(): void
    {
        $this->networkConnectionType = [];
    }

    /**
     * Returns Payment Region.
     * The country in which the Terminal is authorized to take payments.
     */
    public function getPaymentRegion(): ?string
    {
        if (count($this->paymentRegion) == 0) {
            return null;
        }
        return $this->paymentRegion['value'];
    }

    /**
     * Sets Payment Region.
     * The country in which the Terminal is authorized to take payments.
     *
     * @maps payment_region
     */
    public function setPaymentRegion(?string $paymentRegion): void
    {
        $this->paymentRegion['value'] = $paymentRegion;
    }

    /**
     * Unsets Payment Region.
     * The country in which the Terminal is authorized to take payments.
     */
    public function unsetPaymentRegion(): void
    {
        $this->paymentRegion = [];
    }

    /**
     * Returns Serial Number.
     * The unique identifier assigned to the Terminal, which can be found on the lower back
     * of the device.
     */
    public function getSerialNumber(): ?string
    {
        if (count($this->serialNumber) == 0) {
            return null;
        }
        return $this->serialNumber['value'];
    }

    /**
     * Sets Serial Number.
     * The unique identifier assigned to the Terminal, which can be found on the lower back
     * of the device.
     *
     * @maps serial_number
     */
    public function setSerialNumber(?string $serialNumber): void
    {
        $this->serialNumber['value'] = $serialNumber;
    }

    /**
     * Unsets Serial Number.
     * The unique identifier assigned to the Terminal, which can be found on the lower back
     * of the device.
     */
    public function unsetSerialNumber(): void
    {
        $this->serialNumber = [];
    }

    /**
     * Returns Os Version.
     * The current version of the Terminal’s operating system.
     */
    public function getOsVersion(): ?string
    {
        if (count($this->osVersion) == 0) {
            return null;
        }
        return $this->osVersion['value'];
    }

    /**
     * Sets Os Version.
     * The current version of the Terminal’s operating system.
     *
     * @maps os_version
     */
    public function setOsVersion(?string $osVersion): void
    {
        $this->osVersion['value'] = $osVersion;
    }

    /**
     * Unsets Os Version.
     * The current version of the Terminal’s operating system.
     */
    public function unsetOsVersion(): void
    {
        $this->osVersion = [];
    }

    /**
     * Returns App Version.
     * The current version of the application running on the Terminal.
     */
    public function getAppVersion(): ?string
    {
        if (count($this->appVersion) == 0) {
            return null;
        }
        return $this->appVersion['value'];
    }

    /**
     * Sets App Version.
     * The current version of the application running on the Terminal.
     *
     * @maps app_version
     */
    public function setAppVersion(?string $appVersion): void
    {
        $this->appVersion['value'] = $appVersion;
    }

    /**
     * Unsets App Version.
     * The current version of the application running on the Terminal.
     */
    public function unsetAppVersion(): void
    {
        $this->appVersion = [];
    }

    /**
     * Returns Wifi Network Name.
     * The name of the Wi-Fi network to which the Terminal is connected.
     */
    public function getWifiNetworkName(): ?string
    {
        if (count($this->wifiNetworkName) == 0) {
            return null;
        }
        return $this->wifiNetworkName['value'];
    }

    /**
     * Sets Wifi Network Name.
     * The name of the Wi-Fi network to which the Terminal is connected.
     *
     * @maps wifi_network_name
     */
    public function setWifiNetworkName(?string $wifiNetworkName): void
    {
        $this->wifiNetworkName['value'] = $wifiNetworkName;
    }

    /**
     * Unsets Wifi Network Name.
     * The name of the Wi-Fi network to which the Terminal is connected.
     */
    public function unsetWifiNetworkName(): void
    {
        $this->wifiNetworkName = [];
    }

    /**
     * Returns Wifi Network Strength.
     * The signal strength of the Wi-FI network connection.
     * Options: `POOR`, `FAIR`, `GOOD`, `EXCELLENT`
     */
    public function getWifiNetworkStrength(): ?string
    {
        if (count($this->wifiNetworkStrength) == 0) {
            return null;
        }
        return $this->wifiNetworkStrength['value'];
    }

    /**
     * Sets Wifi Network Strength.
     * The signal strength of the Wi-FI network connection.
     * Options: `POOR`, `FAIR`, `GOOD`, `EXCELLENT`
     *
     * @maps wifi_network_strength
     */
    public function setWifiNetworkStrength(?string $wifiNetworkStrength): void
    {
        $this->wifiNetworkStrength['value'] = $wifiNetworkStrength;
    }

    /**
     * Unsets Wifi Network Strength.
     * The signal strength of the Wi-FI network connection.
     * Options: `POOR`, `FAIR`, `GOOD`, `EXCELLENT`
     */
    public function unsetWifiNetworkStrength(): void
    {
        $this->wifiNetworkStrength = [];
    }

    /**
     * Returns Ip Address.
     * The IP address of the Terminal.
     */
    public function getIpAddress(): ?string
    {
        if (count($this->ipAddress) == 0) {
            return null;
        }
        return $this->ipAddress['value'];
    }

    /**
     * Sets Ip Address.
     * The IP address of the Terminal.
     *
     * @maps ip_address
     */
    public function setIpAddress(?string $ipAddress): void
    {
        $this->ipAddress['value'] = $ipAddress;
    }

    /**
     * Unsets Ip Address.
     * The IP address of the Terminal.
     */
    public function unsetIpAddress(): void
    {
        $this->ipAddress = [];
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
        if (!empty($this->batteryPercentage)) {
            $json['battery_percentage']      = $this->batteryPercentage['value'];
        }
        if (!empty($this->chargingState)) {
            $json['charging_state']          = $this->chargingState['value'];
        }
        if (!empty($this->locationId)) {
            $json['location_id']             = $this->locationId['value'];
        }
        if (!empty($this->merchantId)) {
            $json['merchant_id']             = $this->merchantId['value'];
        }
        if (!empty($this->networkConnectionType)) {
            $json['network_connection_type'] = $this->networkConnectionType['value'];
        }
        if (!empty($this->paymentRegion)) {
            $json['payment_region']          = $this->paymentRegion['value'];
        }
        if (!empty($this->serialNumber)) {
            $json['serial_number']           = $this->serialNumber['value'];
        }
        if (!empty($this->osVersion)) {
            $json['os_version']              = $this->osVersion['value'];
        }
        if (!empty($this->appVersion)) {
            $json['app_version']             = $this->appVersion['value'];
        }
        if (!empty($this->wifiNetworkName)) {
            $json['wifi_network_name']       = $this->wifiNetworkName['value'];
        }
        if (!empty($this->wifiNetworkStrength)) {
            $json['wifi_network_strength']   = $this->wifiNetworkStrength['value'];
        }
        if (!empty($this->ipAddress)) {
            $json['ip_address']              = $this->ipAddress['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
