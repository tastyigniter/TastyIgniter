<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing ANetApiRequestType
 *
 * 
 * XSD Type: ANetApiRequest
 */
class ANetApiRequestType implements \JsonSerializable
{

    /**
     * @property \net\authorize\api\contract\v1\MerchantAuthenticationType
     * $merchantAuthentication
     */
    private $merchantAuthentication = null;

    /**
     * @property string $clientId
     */
    private $clientId = null;

    /**
     * @property string $refId
     */
    private $refId = null;

    /**
     * Gets as merchantAuthentication
     *
     * @return \net\authorize\api\contract\v1\MerchantAuthenticationType
     */
    public function getMerchantAuthentication()
    {
        return $this->merchantAuthentication;
    }

    /**
     * Sets a new merchantAuthentication
     *
     * @param \net\authorize\api\contract\v1\MerchantAuthenticationType
     * $merchantAuthentication
     * @return self
     */
    public function setMerchantAuthentication(\net\authorize\api\contract\v1\MerchantAuthenticationType $merchantAuthentication)
    {
        $this->merchantAuthentication = $merchantAuthentication;
        return $this;
    }

    /**
     * Gets as clientId
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Sets a new clientId
     *
     * @param string $clientId
     * @return self
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * Gets as refId
     *
     * @return string
     */
    public function getRefId()
    {
        return $this->refId;
    }

    /**
     * Sets a new refId
     *
     * @param string $refId
     * @return self
     */
    public function setRefId($refId)
    {
        $this->refId = $refId;
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

