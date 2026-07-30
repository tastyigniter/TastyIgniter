<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing CustomerPaymentProfileListItemType
 *
 * 
 * XSD Type: customerPaymentProfileListItemType
 */
class CustomerPaymentProfileListItemType implements \JsonSerializable
{

    /**
     * @property boolean $defaultPaymentProfile
     */
    private $defaultPaymentProfile = null;

    /**
     * @property integer $customerPaymentProfileId
     */
    private $customerPaymentProfileId = null;

    /**
     * @property integer $customerProfileId
     */
    private $customerProfileId = null;

    /**
     * @property \net\authorize\api\contract\v1\CustomerAddressType $billTo
     */
    private $billTo = null;

    /**
     * @property \net\authorize\api\contract\v1\PaymentMaskedType $payment
     */
    private $payment = null;

    /**
     * @property string $originalNetworkTransId
     */
    private $originalNetworkTransId = null;

    /**
     * @property float $originalAuthAmount
     */
    private $originalAuthAmount = null;

    /**
     * Gets as defaultPaymentProfile
     *
     * @return boolean
     */
    public function getDefaultPaymentProfile()
    {
        return $this->defaultPaymentProfile;
    }

    /**
     * Sets a new defaultPaymentProfile
     *
     * @param boolean $defaultPaymentProfile
     * @return self
     */
    public function setDefaultPaymentProfile($defaultPaymentProfile)
    {
        $this->defaultPaymentProfile = $defaultPaymentProfile;
        return $this;
    }

    /**
     * Gets as customerPaymentProfileId
     *
     * @return integer
     */
    public function getCustomerPaymentProfileId()
    {
        return $this->customerPaymentProfileId;
    }

    /**
     * Sets a new customerPaymentProfileId
     *
     * @param integer $customerPaymentProfileId
     * @return self
     */
    public function setCustomerPaymentProfileId($customerPaymentProfileId)
    {
        $this->customerPaymentProfileId = $customerPaymentProfileId;
        return $this;
    }

    /**
     * Gets as customerProfileId
     *
     * @return integer
     */
    public function getCustomerProfileId()
    {
        return $this->customerProfileId;
    }

    /**
     * Sets a new customerProfileId
     *
     * @param integer $customerProfileId
     * @return self
     */
    public function setCustomerProfileId($customerProfileId)
    {
        $this->customerProfileId = $customerProfileId;
        return $this;
    }

    /**
     * Gets as billTo
     *
     * @return \net\authorize\api\contract\v1\CustomerAddressType
     */
    public function getBillTo()
    {
        return $this->billTo;
    }

    /**
     * Sets a new billTo
     *
     * @param \net\authorize\api\contract\v1\CustomerAddressType $billTo
     * @return self
     */
    public function setBillTo(\net\authorize\api\contract\v1\CustomerAddressType $billTo)
    {
        $this->billTo = $billTo;
        return $this;
    }

    /**
     * Gets as payment
     *
     * @return \net\authorize\api\contract\v1\PaymentMaskedType
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Sets a new payment
     *
     * @param \net\authorize\api\contract\v1\PaymentMaskedType $payment
     * @return self
     */
    public function setPayment(\net\authorize\api\contract\v1\PaymentMaskedType $payment)
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * Gets as originalNetworkTransId
     *
     * @return string
     */
    public function getOriginalNetworkTransId()
    {
        return $this->originalNetworkTransId;
    }

    /**
     * Sets a new originalNetworkTransId
     *
     * @param string $originalNetworkTransId
     * @return self
     */
    public function setOriginalNetworkTransId($originalNetworkTransId)
    {
        $this->originalNetworkTransId = $originalNetworkTransId;
        return $this;
    }

    /**
     * Gets as originalAuthAmount
     *
     * @return float
     */
    public function getOriginalAuthAmount()
    {
        return $this->originalAuthAmount;
    }

    /**
     * Sets a new originalAuthAmount
     *
     * @param float $originalAuthAmount
     * @return self
     */
    public function setOriginalAuthAmount($originalAuthAmount)
    {
        $this->originalAuthAmount = $originalAuthAmount;
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

