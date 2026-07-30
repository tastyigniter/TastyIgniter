<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Describes receipt action fields.
 */
class ReceiptOptions implements \JsonSerializable
{
    /**
     * @var string
     */
    private $paymentId;

    /**
     * @var array
     */
    private $printOnly = [];

    /**
     * @var array
     */
    private $isDuplicate = [];

    /**
     * @param string $paymentId
     */
    public function __construct(string $paymentId)
    {
        $this->paymentId = $paymentId;
    }

    /**
     * Returns Payment Id.
     * The reference to the Square payment ID for the receipt.
     */
    public function getPaymentId(): string
    {
        return $this->paymentId;
    }

    /**
     * Sets Payment Id.
     * The reference to the Square payment ID for the receipt.
     *
     * @required
     * @maps payment_id
     */
    public function setPaymentId(string $paymentId): void
    {
        $this->paymentId = $paymentId;
    }

    /**
     * Returns Print Only.
     * Instructs the device to print the receipt without displaying the receipt selection screen.
     * Requires `printer_enabled` set to true.
     * Defaults to false.
     */
    public function getPrintOnly(): ?bool
    {
        if (count($this->printOnly) == 0) {
            return null;
        }
        return $this->printOnly['value'];
    }

    /**
     * Sets Print Only.
     * Instructs the device to print the receipt without displaying the receipt selection screen.
     * Requires `printer_enabled` set to true.
     * Defaults to false.
     *
     * @maps print_only
     */
    public function setPrintOnly(?bool $printOnly): void
    {
        $this->printOnly['value'] = $printOnly;
    }

    /**
     * Unsets Print Only.
     * Instructs the device to print the receipt without displaying the receipt selection screen.
     * Requires `printer_enabled` set to true.
     * Defaults to false.
     */
    public function unsetPrintOnly(): void
    {
        $this->printOnly = [];
    }

    /**
     * Returns Is Duplicate.
     * Identify the receipt as a reprint rather than an original receipt.
     * Defaults to false.
     */
    public function getIsDuplicate(): ?bool
    {
        if (count($this->isDuplicate) == 0) {
            return null;
        }
        return $this->isDuplicate['value'];
    }

    /**
     * Sets Is Duplicate.
     * Identify the receipt as a reprint rather than an original receipt.
     * Defaults to false.
     *
     * @maps is_duplicate
     */
    public function setIsDuplicate(?bool $isDuplicate): void
    {
        $this->isDuplicate['value'] = $isDuplicate;
    }

    /**
     * Unsets Is Duplicate.
     * Identify the receipt as a reprint rather than an original receipt.
     * Defaults to false.
     */
    public function unsetIsDuplicate(): void
    {
        $this->isDuplicate = [];
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
        $json['payment_id']       = $this->paymentId;
        if (!empty($this->printOnly)) {
            $json['print_only']   = $this->printOnly['value'];
        }
        if (!empty($this->isDuplicate)) {
            $json['is_duplicate'] = $this->isDuplicate['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
