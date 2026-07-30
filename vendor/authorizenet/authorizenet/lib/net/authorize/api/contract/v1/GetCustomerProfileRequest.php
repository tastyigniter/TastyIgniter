<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing GetCustomerProfileRequest
 */
class GetCustomerProfileRequest extends ANetApiRequestType
{

    /**
     * @property string $customerProfileId
     */
    private $customerProfileId = null;

    /**
     * @property string $merchantCustomerId
     */
    private $merchantCustomerId = null;

    /**
     * @property string $email
     */
    private $email = null;

    /**
     * @property boolean $unmaskExpirationDate
     */
    private $unmaskExpirationDate = null;

    /**
     * @property boolean $includeIssuerInfo
     */
    private $includeIssuerInfo = null;

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
     * Gets as merchantCustomerId
     *
     * @return string
     */
    public function getMerchantCustomerId()
    {
        return $this->merchantCustomerId;
    }

    /**
     * Sets a new merchantCustomerId
     *
     * @param string $merchantCustomerId
     * @return self
     */
    public function setMerchantCustomerId($merchantCustomerId)
    {
        $this->merchantCustomerId = $merchantCustomerId;
        return $this;
    }

    /**
     * Gets as email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets a new email
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Gets as unmaskExpirationDate
     *
     * @return boolean
     */
    public function getUnmaskExpirationDate()
    {
        return $this->unmaskExpirationDate;
    }

    /**
     * Sets a new unmaskExpirationDate
     *
     * @param boolean $unmaskExpirationDate
     * @return self
     */
    public function setUnmaskExpirationDate($unmaskExpirationDate)
    {
        $this->unmaskExpirationDate = $unmaskExpirationDate;
        return $this;
    }

    /**
     * Gets as includeIssuerInfo
     *
     * @return boolean
     */
    public function getIncludeIssuerInfo()
    {
        return $this->includeIssuerInfo;
    }

    /**
     * Sets a new includeIssuerInfo
     *
     * @param boolean $includeIssuerInfo
     * @return self
     */
    public function setIncludeIssuerInfo($includeIssuerInfo)
    {
        $this->includeIssuerInfo = $includeIssuerInfo;
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

