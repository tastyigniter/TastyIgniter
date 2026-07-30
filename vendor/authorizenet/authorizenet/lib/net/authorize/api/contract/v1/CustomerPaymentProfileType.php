<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing CustomerPaymentProfileType
 *
 * 
 * XSD Type: customerPaymentProfileType
 */
class CustomerPaymentProfileType extends CustomerPaymentProfileBaseType implements \JsonSerializable
{

    /**
     * @property \net\authorize\api\contract\v1\PaymentType $payment
     */
    private $payment = null;

    /**
     * @property \net\authorize\api\contract\v1\DriversLicenseType $driversLicense
     */
    private $driversLicense = null;

    /**
     * @property string $taxId
     */
    private $taxId = null;

    /**
     * @property boolean $defaultPaymentProfile
     */
    private $defaultPaymentProfile = null;

    /**
     * @property \net\authorize\api\contract\v1\SubsequentAuthInformationType
     * $subsequentAuthInformation
     */
    private $subsequentAuthInformation = null;

    /**
     * Gets as payment
     *
     * @return \net\authorize\api\contract\v1\PaymentType
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Sets a new payment
     *
     * @param \net\authorize\api\contract\v1\PaymentType $payment
     * @return self
     */
    public function setPayment(\net\authorize\api\contract\v1\PaymentType $payment)
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * Gets as driversLicense
     *
     * @return \net\authorize\api\contract\v1\DriversLicenseType
     */
    public function getDriversLicense()
    {
        return $this->driversLicense;
    }

    /**
     * Sets a new driversLicense
     *
     * @param \net\authorize\api\contract\v1\DriversLicenseType $driversLicense
     * @return self
     */
    public function setDriversLicense(\net\authorize\api\contract\v1\DriversLicenseType $driversLicense)
    {
        $this->driversLicense = $driversLicense;
        return $this;
    }

    /**
     * Gets as taxId
     *
     * @return string
     */
    public function getTaxId()
    {
        return $this->taxId;
    }

    /**
     * Sets a new taxId
     *
     * @param string $taxId
     * @return self
     */
    public function setTaxId($taxId)
    {
        $this->taxId = $taxId;
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
     * Gets as subsequentAuthInformation
     *
     * @return \net\authorize\api\contract\v1\SubsequentAuthInformationType
     */
    public function getSubsequentAuthInformation()
    {
        return $this->subsequentAuthInformation;
    }

    /**
     * Sets a new subsequentAuthInformation
     *
     * @param \net\authorize\api\contract\v1\SubsequentAuthInformationType
     * $subsequentAuthInformation
     * @return self
     */
    public function setSubsequentAuthInformation(\net\authorize\api\contract\v1\SubsequentAuthInformationType $subsequentAuthInformation)
    {
        $this->subsequentAuthInformation = $subsequentAuthInformation;
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

