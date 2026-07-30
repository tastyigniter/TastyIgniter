<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing TransRetailInfoType
 *
 * 
 * XSD Type: transRetailInfoType
 */
class TransRetailInfoType implements \JsonSerializable
{

    /**
     * @property string $marketType
     */
    private $marketType = null;

    /**
     * @property string $deviceType
     */
    private $deviceType = null;

    /**
     * @property string $customerSignature
     */
    private $customerSignature = null;

    /**
     * @property string $terminalNumber
     */
    private $terminalNumber = null;

    /**
     * Gets as marketType
     *
     * @return string
     */
    public function getMarketType()
    {
        return $this->marketType;
    }

    /**
     * Sets a new marketType
     *
     * @param string $marketType
     * @return self
     */
    public function setMarketType($marketType)
    {
        $this->marketType = $marketType;
        return $this;
    }

    /**
     * Gets as deviceType
     *
     * @return string
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * Sets a new deviceType
     *
     * @param string $deviceType
     * @return self
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;
        return $this;
    }

    /**
     * Gets as customerSignature
     *
     * @return string
     */
    public function getCustomerSignature()
    {
        return $this->customerSignature;
    }

    /**
     * Sets a new customerSignature
     *
     * @param string $customerSignature
     * @return self
     */
    public function setCustomerSignature($customerSignature)
    {
        $this->customerSignature = $customerSignature;
        return $this;
    }

    /**
     * Gets as terminalNumber
     *
     * @return string
     */
    public function getTerminalNumber()
    {
        return $this->terminalNumber;
    }

    /**
     * Sets a new terminalNumber
     *
     * @param string $terminalNumber
     * @return self
     */
    public function setTerminalNumber($terminalNumber)
    {
        $this->terminalNumber = $terminalNumber;
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

