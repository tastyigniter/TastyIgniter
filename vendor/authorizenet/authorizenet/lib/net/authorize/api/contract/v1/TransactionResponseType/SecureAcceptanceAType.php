<?php

namespace net\authorize\api\contract\v1\TransactionResponseType;

/**
 * Class representing SecureAcceptanceAType
 */
class SecureAcceptanceAType implements \JsonSerializable
{

    /**
     * @property string $secureAcceptanceUrl
     */
    private $secureAcceptanceUrl = null;

    /**
     * @property string $payerID
     */
    private $payerID = null;

    /**
     * @property string $payerEmail
     */
    private $payerEmail = null;

    /**
     * Gets as secureAcceptanceUrl
     *
     * @return string
     */
    public function getSecureAcceptanceUrl()
    {
        return $this->secureAcceptanceUrl;
    }

    /**
     * Sets a new secureAcceptanceUrl
     *
     * @param string $secureAcceptanceUrl
     * @return self
     */
    public function setSecureAcceptanceUrl($secureAcceptanceUrl)
    {
        $this->secureAcceptanceUrl = $secureAcceptanceUrl;
        return $this;
    }

    /**
     * Gets as payerID
     *
     * @return string
     */
    public function getPayerID()
    {
        return $this->payerID;
    }

    /**
     * Sets a new payerID
     *
     * @param string $payerID
     * @return self
     */
    public function setPayerID($payerID)
    {
        $this->payerID = $payerID;
        return $this;
    }

    /**
     * Gets as payerEmail
     *
     * @return string
     */
    public function getPayerEmail()
    {
        return $this->payerEmail;
    }

    /**
     * Sets a new payerEmail
     *
     * @param string $payerEmail
     * @return self
     */
    public function setPayerEmail($payerEmail)
    {
        $this->payerEmail = $payerEmail;
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

