<?php

namespace multitypetest\model;

use stdClass;

/**
 * @discriminator personType
 * @discriminatorType Per
 */
class Person implements \JsonSerializable
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var int
     */
    private $age;

    /**
     * @var \DateTime
     */
    private $birthday;

    /**
     * @var \DateTime
     */
    private $birthtime;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $uid;

    /**
     * @var string|null
     */
    private $personType;

    /**
     * @param string $address
     * @param int $age
     * @param string $name
     * @param string $uid
     */
    public function __construct($address, $age, $name, $uid)
    {
        $this->address = $address;
        $this->age = $age;
        $this->name = $name;
        $this->uid = $uid;
    }

    /**
     * Returns Address.
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets Address.
     *
     * @required
     * @maps address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * Returns Age.
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Sets Age.
     *
     * @required
     * @maps age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * Returns Birthday.
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Sets Birthday.
     *
     * @required
     * @maps birthday
     * @factory multitypetest\model\DateTimeHelper::fromSimpleDate
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * Returns Birthtime.
     */
    public function getBirthtime()
    {
        return $this->birthtime;
    }

    /**
     * Sets Birthtime.
     *
     * @required
     * @maps birthtime
     * @factory multitypetest\model\DateTimeHelper::fromRfc3339DateTime
     */
    public function setBirthtime($birthtime)
    {
        $this->birthtime = $birthtime;
    }

    /**
     * Returns Name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets Name.
     *
     * @required
     * @maps name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns Uid.
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * Sets Uid.
     *
     * @required
     * @maps uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * Returns Person Type.
     */
    public function getPersonType()
    {
        return $this->personType;
    }

    /**
     * Sets Person Type.
     *
     * @maps personType
     */
    public function setPersonType($personType)
    {
        $this->personType = $personType;
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
        $json['address']    = $this->address;
        $json['age']        = $this->age;
        $json['birthday']   = DateTimeHelper::toSimpleDate($this->birthday);
        $json['birthtime']  = DateTimeHelper::toRfc3339DateTime($this->birthtime);
        $json['name']       = $this->name;
        $json['uid']        = $this->uid;
        $json['personType'] = $this->personType;
        $json = array_merge($json, $this->additionalProperties);

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
