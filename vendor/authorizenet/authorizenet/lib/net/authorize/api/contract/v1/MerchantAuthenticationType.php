<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing MerchantAuthenticationType
 *
 * 
 * XSD Type: merchantAuthenticationType
 */
class MerchantAuthenticationType implements \JsonSerializable
{

    /**
     * @property string $name
     */
    private $name = null;

    /**
     * @property string $transactionKey
     */
    private $transactionKey = null;

    /**
     * @property string $sessionToken
     */
    private $sessionToken = null;

    /**
     * @property string $password
     */
    private $password = null;

    /**
     * @property \net\authorize\api\contract\v1\ImpersonationAuthenticationType
     * $impersonationAuthentication
     */
    private $impersonationAuthentication = null;

    /**
     * @property \net\authorize\api\contract\v1\FingerPrintType $fingerPrint
     */
    private $fingerPrint = null;

    /**
     * @property string $clientKey
     */
    private $clientKey = null;

    /**
     * @property string $accessToken
     */
    private $accessToken = null;

    /**
     * @property string $mobileDeviceId
     */
    private $mobileDeviceId = null;

    /**
     * Gets as name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets a new name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets as transactionKey
     *
     * @return string
     */
    public function getTransactionKey()
    {
        return $this->transactionKey;
    }

    /**
     * Sets a new transactionKey
     *
     * @param string $transactionKey
     * @return self
     */
    public function setTransactionKey($transactionKey)
    {
        $this->transactionKey = $transactionKey;
        return $this;
    }

    /**
     * Gets as sessionToken
     *
     * @return string
     */
    public function getSessionToken()
    {
        return $this->sessionToken;
    }

    /**
     * Sets a new sessionToken
     *
     * @param string $sessionToken
     * @return self
     */
    public function setSessionToken($sessionToken)
    {
        $this->sessionToken = $sessionToken;
        return $this;
    }

    /**
     * Gets as password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets a new password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * Gets as impersonationAuthentication
     *
     * @return \net\authorize\api\contract\v1\ImpersonationAuthenticationType
     */
    public function getImpersonationAuthentication()
    {
        return $this->impersonationAuthentication;
    }

    /**
     * Sets a new impersonationAuthentication
     *
     * @param \net\authorize\api\contract\v1\ImpersonationAuthenticationType
     * $impersonationAuthentication
     * @return self
     */
    public function setImpersonationAuthentication(\net\authorize\api\contract\v1\ImpersonationAuthenticationType $impersonationAuthentication)
    {
        $this->impersonationAuthentication = $impersonationAuthentication;
        return $this;
    }

    /**
     * Gets as fingerPrint
     *
     * @return \net\authorize\api\contract\v1\FingerPrintType
     */
    public function getFingerPrint()
    {
        return $this->fingerPrint;
    }

    /**
     * Sets a new fingerPrint
     *
     * @param \net\authorize\api\contract\v1\FingerPrintType $fingerPrint
     * @return self
     */
    public function setFingerPrint(\net\authorize\api\contract\v1\FingerPrintType $fingerPrint)
    {
        $this->fingerPrint = $fingerPrint;
        return $this;
    }

    /**
     * Gets as clientKey
     *
     * @return string
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }

    /**
     * Sets a new clientKey
     *
     * @param string $clientKey
     * @return self
     */
    public function setClientKey($clientKey)
    {
        $this->clientKey = $clientKey;
        return $this;
    }

    /**
     * Gets as accessToken
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Sets a new accessToken
     *
     * @param string $accessToken
     * @return self
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

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

