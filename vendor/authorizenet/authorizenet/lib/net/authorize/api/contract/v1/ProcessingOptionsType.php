<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing ProcessingOptionsType
 *
 * 
 * XSD Type: processingOptions
 */
class ProcessingOptionsType implements \JsonSerializable
{

    /**
     * @property boolean $isFirstRecurringPayment
     */
    private $isFirstRecurringPayment = null;

    /**
     * @property boolean $isFirstSubsequentAuth
     */
    private $isFirstSubsequentAuth = null;

    /**
     * @property boolean $isSubsequentAuth
     */
    private $isSubsequentAuth = null;

    /**
     * @property boolean $isStoredCredentials
     */
    private $isStoredCredentials = null;

    /**
     * Gets as isFirstRecurringPayment
     *
     * @return boolean
     */
    public function getIsFirstRecurringPayment()
    {
        return $this->isFirstRecurringPayment;
    }

    /**
     * Sets a new isFirstRecurringPayment
     *
     * @param boolean $isFirstRecurringPayment
     * @return self
     */
    public function setIsFirstRecurringPayment($isFirstRecurringPayment)
    {
        $this->isFirstRecurringPayment = $isFirstRecurringPayment;
        return $this;
    }

    /**
     * Gets as isFirstSubsequentAuth
     *
     * @return boolean
     */
    public function getIsFirstSubsequentAuth()
    {
        return $this->isFirstSubsequentAuth;
    }

    /**
     * Sets a new isFirstSubsequentAuth
     *
     * @param boolean $isFirstSubsequentAuth
     * @return self
     */
    public function setIsFirstSubsequentAuth($isFirstSubsequentAuth)
    {
        $this->isFirstSubsequentAuth = $isFirstSubsequentAuth;
        return $this;
    }

    /**
     * Gets as isSubsequentAuth
     *
     * @return boolean
     */
    public function getIsSubsequentAuth()
    {
        return $this->isSubsequentAuth;
    }

    /**
     * Sets a new isSubsequentAuth
     *
     * @param boolean $isSubsequentAuth
     * @return self
     */
    public function setIsSubsequentAuth($isSubsequentAuth)
    {
        $this->isSubsequentAuth = $isSubsequentAuth;
        return $this;
    }

    /**
     * Gets as isStoredCredentials
     *
     * @return boolean
     */
    public function getIsStoredCredentials()
    {
        return $this->isStoredCredentials;
    }

    /**
     * Sets a new isStoredCredentials
     *
     * @param boolean $isStoredCredentials
     * @return self
     */
    public function setIsStoredCredentials($isStoredCredentials)
    {
        $this->isStoredCredentials = $isStoredCredentials;
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

