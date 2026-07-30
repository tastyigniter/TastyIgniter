<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing BankAccountType
 *
 * 
 * XSD Type: bankAccountType
 */
class BankAccountType implements \JsonSerializable
{

    /**
     * @property string $accountType
     */
    private $accountType = null;

    /**
     * @property string $routingNumber
     */
    private $routingNumber = null;

    /**
     * @property string $accountNumber
     */
    private $accountNumber = null;

    /**
     * @property string $nameOnAccount
     */
    private $nameOnAccount = null;

    /**
     * @property string $echeckType
     */
    private $echeckType = null;

    /**
     * @property string $bankName
     */
    private $bankName = null;

    /**
     * @property string $checkNumber
     */
    private $checkNumber = null;

    /**
     * Gets as accountType
     *
     * @return string
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * Sets a new accountType
     *
     * @param string $accountType
     * @return self
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
        return $this;
    }

    /**
     * Gets as routingNumber
     *
     * @return string
     */
    public function getRoutingNumber()
    {
        return $this->routingNumber;
    }

    /**
     * Sets a new routingNumber
     *
     * @param string $routingNumber
     * @return self
     */
    public function setRoutingNumber($routingNumber)
    {
        $this->routingNumber = $routingNumber;
        return $this;
    }

    /**
     * Gets as accountNumber
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Sets a new accountNumber
     *
     * @param string $accountNumber
     * @return self
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * Gets as nameOnAccount
     *
     * @return string
     */
    public function getNameOnAccount()
    {
        return $this->nameOnAccount;
    }

    /**
     * Sets a new nameOnAccount
     *
     * @param string $nameOnAccount
     * @return self
     */
    public function setNameOnAccount($nameOnAccount)
    {
        $this->nameOnAccount = $nameOnAccount;
        return $this;
    }

    /**
     * Gets as echeckType
     *
     * @return string
     */
    public function getEcheckType()
    {
        return $this->echeckType;
    }

    /**
     * Sets a new echeckType
     *
     * @param string $echeckType
     * @return self
     */
    public function setEcheckType($echeckType)
    {
        $this->echeckType = $echeckType;
        return $this;
    }

    /**
     * Gets as bankName
     *
     * @return string
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * Sets a new bankName
     *
     * @param string $bankName
     * @return self
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
        return $this;
    }

    /**
     * Gets as checkNumber
     *
     * @return string
     */
    public function getCheckNumber()
    {
        return $this->checkNumber;
    }

    /**
     * Sets a new checkNumber
     *
     * @param string $checkNumber
     * @return self
     */
    public function setCheckNumber($checkNumber)
    {
        $this->checkNumber = $checkNumber;
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

