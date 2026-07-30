<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing ARBGetSubscriptionResponse
 */
class ARBGetSubscriptionResponse extends ANetApiResponseType
{

    /**
     * @property \net\authorize\api\contract\v1\ARBSubscriptionMaskedType $subscription
     */
    private $subscription = null;

    /**
     * Gets as subscription
     *
     * @return \net\authorize\api\contract\v1\ARBSubscriptionMaskedType
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Sets a new subscription
     *
     * @param \net\authorize\api\contract\v1\ARBSubscriptionMaskedType $subscription
     * @return self
     */
    public function setSubscription(\net\authorize\api\contract\v1\ARBSubscriptionMaskedType $subscription)
    {
        $this->subscription = $subscription;
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

