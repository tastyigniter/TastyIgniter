<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing GetCustomerShippingAddressResponse
 */
class GetCustomerShippingAddressResponse extends ANetApiResponseType
{

    /**
     * @property boolean $defaultShippingAddress
     */
    private $defaultShippingAddress = null;

    /**
     * @property \net\authorize\api\contract\v1\CustomerAddressExType $address
     */
    private $address = null;

    /**
     * @property string[] $subscriptionIds
     */
    private $subscriptionIds = null;

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
     * Gets as address
     *
     * @return \net\authorize\api\contract\v1\CustomerAddressExType
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Sets a new address
     *
     * @param \net\authorize\api\contract\v1\CustomerAddressExType $address
     * @return self
     */
    public function setAddress(\net\authorize\api\contract\v1\CustomerAddressExType $address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Adds as subscriptionId
     *
     * @return self
     * @param string $subscriptionId
     */
    public function addToSubscriptionIds($subscriptionId)
    {
        $this->subscriptionIds[] = $subscriptionId;
        return $this;
    }

    /**
     * isset subscriptionIds
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSubscriptionIds($index)
    {
        return isset($this->subscriptionIds[$index]);
    }

    /**
     * unset subscriptionIds
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSubscriptionIds($index)
    {
        unset($this->subscriptionIds[$index]);
    }

    /**
     * Gets as subscriptionIds
     *
     * @return string[]
     */
    public function getSubscriptionIds()
    {
        return $this->subscriptionIds;
    }

    /**
     * Sets a new subscriptionIds
     *
     * @param string $subscriptionIds
     * @return self
     */
    public function setSubscriptionIds(array $subscriptionIds)
    {
        $this->subscriptionIds = $subscriptionIds;
        return $this;
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

