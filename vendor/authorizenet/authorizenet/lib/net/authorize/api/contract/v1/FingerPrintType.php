<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing FingerPrintType
 *
 * 
 * XSD Type: fingerPrintType
 */
class FingerPrintType implements \JsonSerializable
{

    /**
     * @property string $hashValue
     */
    private $hashValue = null;

    /**
     * @property string $sequence
     */
    private $sequence = null;

    /**
     * @property string $timestamp
     */
    private $timestamp = null;

    /**
     * @property string $currencyCode
     */
    private $currencyCode = null;

    /**
     * @property string $amount
     */
    private $amount = null;

    /**
     * Gets as hashValue
     *
     * @return string
     */
    public function getHashValue()
    {
        return $this->hashValue;
    }

    /**
     * Sets a new hashValue
     *
     * @param string $hashValue
     * @return self
     */
    public function setHashValue($hashValue)
    {
        $this->hashValue = $hashValue;
        return $this;
    }

    /**
     * Gets as sequence
     *
     * @return string
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * Sets a new sequence
     *
     * @param string $sequence
     * @return self
     */
    public function setSequence($sequence)
    {
        $this->sequence = $sequence;
        return $this;
    }

    /**
     * Gets as timestamp
     *
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Sets a new timestamp
     *
     * @param string $timestamp
     * @return self
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Gets as currencyCode
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Sets a new currencyCode
     *
     * @param string $currencyCode
     * @return self
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

    /**
     * Gets as amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets a new amount
     *
     * @param string $amount
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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

