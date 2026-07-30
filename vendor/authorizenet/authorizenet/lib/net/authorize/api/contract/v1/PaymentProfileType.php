<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing PaymentProfileType
 *
 * 
 * XSD Type: paymentProfile
 */
class PaymentProfileType implements \JsonSerializable
{

    /**
     * @property string $paymentProfileId
     */
    private $paymentProfileId = null;

    /**
     * @property string $cardCode
     */
    private $cardCode = null;

    /**
     * Gets as paymentProfileId
     *
     * @return string
     */
    public function getPaymentProfileId()
    {
        return $this->paymentProfileId;
    }

    /**
     * Sets a new paymentProfileId
     *
     * @param string $paymentProfileId
     * @return self
     */
    public function setPaymentProfileId($paymentProfileId)
    {
        $this->paymentProfileId = $paymentProfileId;
        return $this;
    }

    /**
     * Gets as cardCode
     *
     * @return string
     */
    public function getCardCode()
    {
        return $this->cardCode;
    }

    /**
     * Sets a new cardCode
     *
     * @param string $cardCode
     * @return self
     */
    public function setCardCode($cardCode)
    {
        $this->cardCode = $cardCode;
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

