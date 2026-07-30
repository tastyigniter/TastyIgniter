<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing PaymentMaskedType
 *
 * 
 * XSD Type: paymentMaskedType
 */
class PaymentMaskedType implements \JsonSerializable
{

    /**
     * @property \net\authorize\api\contract\v1\CreditCardMaskedType $creditCard
     */
    private $creditCard = null;

    /**
     * @property \net\authorize\api\contract\v1\BankAccountMaskedType $bankAccount
     */
    private $bankAccount = null;

    /**
     * @property \net\authorize\api\contract\v1\TokenMaskedType $tokenInformation
     */
    private $tokenInformation = null;

    /**
     * Gets as creditCard
     *
     * @return \net\authorize\api\contract\v1\CreditCardMaskedType
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }

    /**
     * Sets a new creditCard
     *
     * @param \net\authorize\api\contract\v1\CreditCardMaskedType $creditCard
     * @return self
     */
    public function setCreditCard(\net\authorize\api\contract\v1\CreditCardMaskedType $creditCard)
    {
        $this->creditCard = $creditCard;
        return $this;
    }

    /**
     * Gets as bankAccount
     *
     * @return \net\authorize\api\contract\v1\BankAccountMaskedType
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * Sets a new bankAccount
     *
     * @param \net\authorize\api\contract\v1\BankAccountMaskedType $bankAccount
     * @return self
     */
    public function setBankAccount(\net\authorize\api\contract\v1\BankAccountMaskedType $bankAccount)
    {
        $this->bankAccount = $bankAccount;
        return $this;
    }

    /**
     * Gets as tokenInformation
     *
     * @return \net\authorize\api\contract\v1\TokenMaskedType
     */
    public function getTokenInformation()
    {
        return $this->tokenInformation;
    }

    /**
     * Sets a new tokenInformation
     *
     * @param \net\authorize\api\contract\v1\TokenMaskedType $tokenInformation
     * @return self
     */
    public function setTokenInformation(\net\authorize\api\contract\v1\TokenMaskedType $tokenInformation)
    {
        $this->tokenInformation = $tokenInformation;
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

