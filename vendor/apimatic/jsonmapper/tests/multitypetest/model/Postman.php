<?php

namespace multitypetest\model;

use stdClass;

/**
 * @discriminator personType
 * @discriminatorType Post
 */
class Postman extends Person implements \JsonSerializable
{
    /**
     * @var string
     */
    private $department;

    /**
     * @var Person[]
     */
    private $dependents;

    /**
     * @var \DateTime
     */
    private $hiredAt;

    /**
     * @var string
     */
    private $joiningDay;

    /**
     * @var int
     */
    private $salary;

    /**
     * @var string[]
     */
    private $workingDays;

    /**
     * @param string $address
     * @param int $age
     * @param string $name
     * @param string $uid
     */
    public function __construct($address, $age, $name, $uid)
    {
        parent::__construct($address, $age, $name, $uid);
    }

    /**
     * Returns Department.
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Sets Department.
     *
     * @required
     * @maps department
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    }

    /**
     * Returns Dependents.
     *
     * @return Person[]
     */
    public function getDependents()
    {
        return $this->dependents;
    }

    /**
     * Sets Dependents.
     *
     * @required
     * @maps dependents
     *
     * @param Person[] $dependents
     */
    public function setDependents($dependents)
    {
        $this->dependents = $dependents;
    }

    /**
     * Returns Hired At.
     */
    public function getHiredAt()
    {
        return $this->hiredAt;
    }

    /**
     * Sets Hired At.
     *
     * @required
     * @maps hiredAt
     * @factory multitypetest\model\DateTimeHelper::fromRfc1123DateTime
     */
    public function setHiredAt($hiredAt)
    {
        $this->hiredAt = $hiredAt;
    }

    /**
     * Returns Joining Day.
     */
    public function getJoiningDay()
    {
        return $this->joiningDay;
    }

    /**
     * Sets Joining Day.
     *
     * @required
     * @maps joiningDay
     */
    public function setJoiningDay($joiningDay)
    {
        $this->joiningDay = $joiningDay;
    }

    /**
     * Returns Salary.
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Sets Salary.
     *
     * @required
     * @maps salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * Returns Working Days.
     *
     * @return string[]
     */
    public function getWorkingDays()
    {
        return $this->workingDays;
    }

    /**
     * Sets Working Days.
     *
     * @required
     * @maps workingDays
     *
     * @param string[] $workingDays
     */
    public function setWorkingDays($workingDays)
    {
        $this->workingDays = $workingDays;
    }

    private $additionalProperties = [];

    /**
     * Add an additional property to this model.
     *
     * @param string $name Name of property
     * @param mixed $value Value of property
     */
    public function addAdditionalProperty($name, $value)
    {
        $this->additionalProperties[$name] = $value;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize($asArrayWhenEmpty = false)
    {
        $json = [];
        $json['department']  = $this->department;
        $json['dependents']  = $this->dependents;
        $json['hiredAt']     = DateTimeHelper::toRfc1123DateTime($this->hiredAt);
        $json['joiningDay']  = $this->joiningDay;
        $json['salary']      = $this->salary;
        $json['workingDays'] = $this->workingDays;
        $json = array_merge($json, parent::jsonSerialize(true), $this->additionalProperties);

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
