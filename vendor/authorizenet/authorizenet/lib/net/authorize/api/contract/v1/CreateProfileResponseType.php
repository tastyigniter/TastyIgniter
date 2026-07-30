<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing CreateProfileResponseType
 *
 * 
 * XSD Type: createProfileResponse
 */
class CreateProfileResponseType implements \JsonSerializable
{

    /**
     * @property \net\authorize\api\contract\v1\MessagesType $messages
     */
    private $messages = null;

    /**
     * @property string $customerProfileId
     */
    private $customerProfileId = null;

    /**
     * @property string[] $customerPaymentProfileIdList
     */
    private $customerPaymentProfileIdList = null;

    /**
     * @property string[] $customerShippingAddressIdList
     */
    private $customerShippingAddressIdList = null;

    /**
     * Gets as messages
     *
     * @return \net\authorize\api\contract\v1\MessagesType
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Sets a new messages
     *
     * @param \net\authorize\api\contract\v1\MessagesType $messages
     * @return self
     */
    public function setMessages(\net\authorize\api\contract\v1\MessagesType $messages)
    {
        $this->messages = $messages;
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
     * Adds as numericString
     *
     * @return self
     * @param string $numericString
     */
    public function addToCustomerPaymentProfileIdList($numericString)
    {
        $this->customerPaymentProfileIdList[] = $numericString;
        return $this;
    }

    /**
     * isset customerPaymentProfileIdList
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetCustomerPaymentProfileIdList($index)
    {
        return isset($this->customerPaymentProfileIdList[$index]);
    }

    /**
     * unset customerPaymentProfileIdList
     *
     * @param scalar $index
     * @return void
     */
    public function unsetCustomerPaymentProfileIdList($index)
    {
        unset($this->customerPaymentProfileIdList[$index]);
    }

    /**
     * Gets as customerPaymentProfileIdList
     *
     * @return string[]
     */
    public function getCustomerPaymentProfileIdList()
    {
        return $this->customerPaymentProfileIdList;
    }

    /**
     * Sets a new customerPaymentProfileIdList
     *
     * @param string $customerPaymentProfileIdList
     * @return self
     */
    public function setCustomerPaymentProfileIdList(array $customerPaymentProfileIdList)
    {
        $this->customerPaymentProfileIdList = $customerPaymentProfileIdList;
        return $this;
    }

    /**
     * Adds as numericString
     *
     * @return self
     * @param string $numericString
     */
    public function addToCustomerShippingAddressIdList($numericString)
    {
        $this->customerShippingAddressIdList[] = $numericString;
        return $this;
    }

    /**
     * isset customerShippingAddressIdList
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetCustomerShippingAddressIdList($index)
    {
        return isset($this->customerShippingAddressIdList[$index]);
    }

    /**
     * unset customerShippingAddressIdList
     *
     * @param scalar $index
     * @return void
     */
    public function unsetCustomerShippingAddressIdList($index)
    {
        unset($this->customerShippingAddressIdList[$index]);
    }

    /**
     * Gets as customerShippingAddressIdList
     *
     * @return string[]
     */
    public function getCustomerShippingAddressIdList()
    {
        return $this->customerShippingAddressIdList;
    }

    /**
     * Sets a new customerShippingAddressIdList
     *
     * @param string $customerShippingAddressIdList
     * @return self
     */
    public function setCustomerShippingAddressIdList(array $customerShippingAddressIdList)
    {
        $this->customerShippingAddressIdList = $customerShippingAddressIdList;
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

