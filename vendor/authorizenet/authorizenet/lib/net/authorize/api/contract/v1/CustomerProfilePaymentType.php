<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing CustomerProfilePaymentType
 *
 * 
 * XSD Type: customerProfilePaymentType
 */
class CustomerProfilePaymentType implements \JsonSerializable
{

    /**
     * @property boolean $createProfile
     */
    private $createProfile = null;

    /**
     * @property string $customerProfileId
     */
    private $customerProfileId = null;

    /**
     * @property \net\authorize\api\contract\v1\PaymentProfileType $paymentProfile
     */
    private $paymentProfile = null;

    /**
     * @property string $shippingProfileId
     */
    private $shippingProfileId = null;

    /**
     * Gets as createProfile
     *
     * @return boolean
     */
    public function getCreateProfile()
    {
        return $this->createProfile;
    }

    /**
     * Sets a new createProfile
     *
     * @param boolean $createProfile
     * @return self
     */
    public function setCreateProfile($createProfile)
    {
        $this->createProfile = $createProfile;
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
     * Gets as paymentProfile
     *
     * @return \net\authorize\api\contract\v1\PaymentProfileType
     */
    public function getPaymentProfile()
    {
        return $this->paymentProfile;
    }

    /**
     * Sets a new paymentProfile
     *
     * @param \net\authorize\api\contract\v1\PaymentProfileType $paymentProfile
     * @return self
     */
    public function setPaymentProfile(\net\authorize\api\contract\v1\PaymentProfileType $paymentProfile)
    {
        $this->paymentProfile = $paymentProfile;
        return $this;
    }

    /**
     * Gets as shippingProfileId
     *
     * @return string
     */
    public function getShippingProfileId()
    {
        return $this->shippingProfileId;
    }

    /**
     * Sets a new shippingProfileId
     *
     * @param string $shippingProfileId
     * @return self
     */
    public function setShippingProfileId($shippingProfileId)
    {
        $this->shippingProfileId = $shippingProfileId;
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

