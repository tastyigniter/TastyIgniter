<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * The hourly wage rate used to compensate an employee for this shift.
 */
class ShiftWage implements \JsonSerializable
{
    /**
     * @var array
     */
    private $title = [];

    /**
     * @var Money|null
     */
    private $hourlyRate;

    /**
     * Returns Title.
     * The name of the job performed during this shift. Square
     * labor-reporting UIs might group shifts together by title.
     */
    public function getTitle(): ?string
    {
        if (count($this->title) == 0) {
            return null;
        }
        return $this->title['value'];
    }

    /**
     * Sets Title.
     * The name of the job performed during this shift. Square
     * labor-reporting UIs might group shifts together by title.
     *
     * @maps title
     */
    public function setTitle(?string $title): void
    {
        $this->title['value'] = $title;
    }

    /**
     * Unsets Title.
     * The name of the job performed during this shift. Square
     * labor-reporting UIs might group shifts together by title.
     */
    public function unsetTitle(): void
    {
        $this->title = [];
    }

    /**
     * Returns Hourly Rate.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getHourlyRate(): ?Money
    {
        return $this->hourlyRate;
    }

    /**
     * Sets Hourly Rate.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps hourly_rate
     */
    public function setHourlyRate(?Money $hourlyRate): void
    {
        $this->hourlyRate = $hourlyRate;
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
        if (!empty($this->title)) {
            $json['title']       = $this->title['value'];
        }
        if (isset($this->hourlyRate)) {
            $json['hourly_rate'] = $this->hourlyRate;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
