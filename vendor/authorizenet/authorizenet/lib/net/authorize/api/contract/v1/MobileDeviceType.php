<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing MobileDeviceType
 *
 * 
 * XSD Type: mobileDeviceType
 */
class MobileDeviceType implements \JsonSerializable
{

    /**
     * @property string $mobileDeviceId
     */
    private $mobileDeviceId = null;

    /**
     * @property string $description
     */
    private $description = null;

    /**
     * @property string $phoneNumber
     */
    private $phoneNumber = null;

    /**
     * @property string $devicePlatform
     */
    private $devicePlatform = null;

    /**
     * @property string $deviceActivation
     */
    private $deviceActivation = null;

    /**
     * Gets as mobileDeviceId
     *
     * @return string
     */
    public function getMobileDeviceId()
    {
        return $this->mobileDeviceId;
    }

    /**
     * Sets a new mobileDeviceId
     *
     * @param string $mobileDeviceId
     * @return self
     */
    public function setMobileDeviceId($mobileDeviceId)
    {
        $this->mobileDeviceId = $mobileDeviceId;
        return $this;
    }

    /**
     * Gets as description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets a new description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Gets as phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Sets a new phoneNumber
     *
     * @param string $phoneNumber
     * @return self
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * Gets as devicePlatform
     *
     * @return string
     */
    public function getDevicePlatform()
    {
        return $this->devicePlatform;
    }

    /**
     * Sets a new devicePlatform
     *
     * @param string $devicePlatform
     * @return self
     */
    public function setDevicePlatform($devicePlatform)
    {
        $this->devicePlatform = $devicePlatform;
        return $this;
    }

    /**
     * Gets as deviceActivation
     *
     * @return string
     */
    public function getDeviceActivation()
    {
        return $this->deviceActivation;
    }

    /**
     * Sets a new deviceActivation
     *
     * @param string $deviceActivation
     * @return self
     */
    public function setDeviceActivation($deviceActivation)
    {
        $this->deviceActivation = $deviceActivation;
        return $this;
    }


    // Json Serialize Code
    public function jsonSerialize(){
        $values = array_filter((array)get_object_vars($this),
        function ($val){
            return !is_null($val);
        });
        $mapper = \net\authorize\util\Mapper::Instance();
        foreach($values as $key => $value){
            $classDetails = $mapper->getClass(get_class() , $key);
            if (isset($value)){
                if ($classDetails->className === 'Date'){
                    $dateTime = $value->format('Y-m-d');
                    $values[$key] = $dateTime;
                }
                else if ($classDetails->className === 'DateTime'){
                    $dateTime = $value->format('Y-m-d\TH:i:s\Z');
                    $values[$key] = $dateTime;
                }
                if (is_array($value)){
                    if (!$classDetails->isInlineArray){
                        $subKey = $classDetails->arrayEntryname;
                        $subArray = [$subKey => $value];
                        $values[$key] = $subArray;
                    }
                }
            }
        }
        return $values;
    }
    
    // Json Set Code
    public function set($data)
    {
        if(is_array($data) || is_object($data)) {
			$mapper = \net\authorize\util\Mapper::Instance();
			foreach($data AS $key => $value) {
				$classDetails = $mapper->getClass(get_class() , $key);
	 
				if($classDetails !== NULL ) {
					if ($classDetails->isArray) {
						if ($classDetails->isCustomDefined) {
							foreach($value AS $keyChild => $valueChild) {
								$type = new $classDetails->className;
								$type->set($valueChild);
								$this->{'addTo' . $key}($type);
							}
						}
						else if ($classDetails->className === 'DateTime' || $classDetails->className === 'Date' ) {
							foreach($value AS $keyChild => $valueChild) {
								$type = new \DateTime($valueChild);
								$this->{'addTo' . $key}($type);
							}
						}
						else {
							foreach($value AS $keyChild => $valueChild) {
								$this->{'addTo' . $key}($valueChild);
							}
						}
					}
					else {
						if ($classDetails->isCustomDefined){
							$type = new $classDetails->className;
							$type->set($value);
							$this->{'set' . $key}($type);
						}
						else if ($classDetails->className === 'DateTime' || $classDetails->className === 'Date' ) {
							$type = new \DateTime($value);
							$this->{'set' . $key}($type);
						}
						else {
							$this->{'set' . $key}($value);
						}
					}
				}
			}
		}
    }
    
}

