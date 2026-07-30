<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing CreateCustomerProfileFromTransactionRequest
 */
class CreateCustomerProfileFromTransactionRequest extends ANetApiRequestType
{

    /**
     * @property string $transId
     */
    private $transId = null;

    /**
     * @property \net\authorize\api\contract\v1\CustomerProfileBaseType $customer
     */
    private $customer = null;

    /**
     * @property string $customerProfileId
     */
    private $customerProfileId = null;

    /**
     * @property boolean $defaultPaymentProfile
     */
    private $defaultPaymentProfile = null;

    /**
     * @property boolean $defaultShippingAddress
     */
    private $defaultShippingAddress = null;

    /**
     * @property string $profileType
     */
    private $profileType = null;

    /**
     * Gets as transId
     *
     * @return string
     */
    public function getTransId()
    {
        return $this->transId;
    }

    /**
     * Sets a new transId
     *
     * @param string $transId
     * @return self
     */
    public function setTransId($transId)
    {
        $this->transId = $transId;
        return $this;
    }

    /**
     * Gets as customer
     *
     * @return \net\authorize\api\contract\v1\CustomerProfileBaseType
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Sets a new customer
     *
     * @param \net\authorize\api\contract\v1\CustomerProfileBaseType $customer
     * @return self
     */
    public function setCustomer(\net\authorize\api\contract\v1\CustomerProfileBaseType $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * Gets as customerProfileId
     *
     * @return string
     */
    public function getCustomerProfileId()
    {
        return $this->customerProfileId;
    }

    /**
     * Sets a new customerProfileId
     *
     * @param string $customerProfileId
     * @return self
     */
    public function setCustomerProfileId($customerProfileId)
    {
        $this->customerProfileId = $customerProfileId;
        return $this;
    }

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
     * Gets as defaultShippingAddress
     *
     * @return boolean
     */
    public function getDefaultShippingAddress()
    {
        return $this->defaultShippingAddress;
    }

    /**
     * Sets a new defaultShippingAddress
     *
     * @param boolean $defaultShippingAddress
     * @return self
     */
    public function setDefaultShippingAddress($defaultShippingAddress)
    {
        $this->defaultShippingAddress = $defaultShippingAddress;
        return $this;
    }

    /**
     * Gets as profileType
     *
     * @return string
     */
    public function getProfileType()
    {
        return $this->profileType;
    }

    /**
     * Sets a new profileType
     *
     * @param string $profileType
     * @return self
     */
    public function setProfileType($profileType)
    {
        $this->profileType = $profileType;
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
        return array_merge(parent::jsonSerialize(), $values);
    }

}

