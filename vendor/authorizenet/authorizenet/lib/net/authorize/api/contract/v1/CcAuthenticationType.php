<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing CcAuthenticationType
 *
 * 
 * XSD Type: ccAuthenticationType
 */
class CcAuthenticationType implements \JsonSerializable
{

    /**
     * @property string $authenticationIndicator
     */
    private $authenticationIndicator = null;

    /**
     * @property string $cardholderAuthenticationValue
     */
    private $cardholderAuthenticationValue = null;

    /**
     * Gets as authenticationIndicator
     *
     * @return string
     */
    public function getAuthenticationIndicator()
    {
        return $this->authenticationIndicator;
    }

    /**
     * Sets a new authenticationIndicator
     *
     * @param string $authenticationIndicator
     * @return self
     */
    public function setAuthenticationIndicator($authenticationIndicator)
    {
        $this->authenticationIndicator = $authenticationIndicator;
        return $this;
    }

    /**
     * Gets as cardholderAuthenticationValue
     *
     * @return string
     */
    public function getCardholderAuthenticationValue()
    {
        return $this->cardholderAuthenticationValue;
    }

    /**
     * Sets a new cardholderAuthenticationValue
     *
     * @param string $cardholderAuthenticationValue
     * @return self
     */
    public function setCardholderAuthenticationValue($cardholderAuthenticationValue)
    {
        $this->cardholderAuthenticationValue = $cardholderAuthenticationValue;
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

