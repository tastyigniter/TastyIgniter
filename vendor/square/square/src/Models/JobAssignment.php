<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * An object describing a job that a team member is assigned to.
 */
class JobAssignment implements \JsonSerializable
{
    /**
     * @var string
     */
    private $jobTitle;

    /**
     * @var string
     */
    private $payType;

    /**
     * @var Money|null
     */
    private $hourlyRate;

    /**
     * @var Money|null
     */
    private $annualRate;

    /**
     * @var array
     */
    private $weeklyHours = [];

    /**
     * @param string $jobTitle
     * @param string $payType
     */
    public function __construct(string $jobTitle, string $payType)
    {
        $this->jobTitle = $jobTitle;
        $this->payType = $payType;
    }

    /**
     * Returns Job Title.
     * The title of the job.
     */
    public function getJobTitle(): string
    {
        return $this->jobTitle;
    }

    /**
     * Sets Job Title.
     * The title of the job.
     *
     * @required
     * @maps job_title
     */
    public function setJobTitle(string $jobTitle): void
    {
        $this->jobTitle = $jobTitle;
    }

    /**
     * Returns Pay Type.
     * Enumerates the possible pay types that a job can be assigned.
     */
    public function getPayType(): string
    {
        return $this->payType;
    }

    /**
     * Sets Pay Type.
     * Enumerates the possible pay types that a job can be assigned.
     *
     * @required
     * @maps pay_type
     */
    public function setPayType(string $payType): void
    {
        $this->payType = $payType;
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
     * Returns Annual Rate.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAnnualRate(): ?Money
    {
        return $this->annualRate;
    }

    /**
     * Sets Annual Rate.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps annual_rate
     */
    public function setAnnualRate(?Money $annualRate): void
    {
        $this->annualRate = $annualRate;
    }

    /**
     * Returns Weekly Hours.
     * The planned hours per week for the job. Set if the job `PayType` is `SALARY`.
     */
    public function getWeeklyHours(): ?int
    {
        if (count($this->weeklyHours) == 0) {
            return null;
        }
        return $this->weeklyHours['value'];
    }

    /**
     * Sets Weekly Hours.
     * The planned hours per week for the job. Set if the job `PayType` is `SALARY`.
     *
     * @maps weekly_hours
     */
    public function setWeeklyHours(?int $weeklyHours): void
    {
        $this->weeklyHours['value'] = $weeklyHours;
    }

    /**
     * Unsets Weekly Hours.
     * The planned hours per week for the job. Set if the job `PayType` is `SALARY`.
     */
    public function unsetWeeklyHours(): void
    {
        $this->weeklyHours = [];
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
        $json['job_title']        = $this->jobTitle;
        $json['pay_type']         = $this->payType;
        if (isset($this->hourlyRate)) {
            $json['hourly_rate']  = $this->hourlyRate;
        }
        if (isset($this->annualRate)) {
            $json['annual_rate']  = $this->annualRate;
        }
        if (!empty($this->weeklyHours)) {
            $json['weekly_hours'] = $this->weeklyHours['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
