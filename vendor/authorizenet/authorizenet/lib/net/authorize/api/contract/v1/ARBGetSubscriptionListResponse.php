<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing ARBGetSubscriptionListResponse
 */
class ARBGetSubscriptionListResponse extends ANetApiResponseType
{

    /**
     * @property integer $totalNumInResultSet
     */
    private $totalNumInResultSet = null;

    /**
     * @property \net\authorize\api\contract\v1\SubscriptionDetailType[]
     * $subscriptionDetails
     */
    private $subscriptionDetails = null;

    /**
     * Gets as totalNumInResultSet
     *
     * @return integer
     */
    public function getTotalNumInResultSet()
    {
        return $this->totalNumInResultSet;
    }

    /**
     * Sets a new totalNumInResultSet
     *
     * @param integer $totalNumInResultSet
     * @return self
     */
    public function setTotalNumInResultSet($totalNumInResultSet)
    {
        $this->totalNumInResultSet = $totalNumInResultSet;
        return $this;
    }

    /**
     * Adds as subscriptionDetail
     *
     * @return self
     * @param \net\authorize\api\contract\v1\SubscriptionDetailType $subscriptionDetail
     */
    public function addToSubscriptionDetails(\net\authorize\api\contract\v1\SubscriptionDetailType $subscriptionDetail)
    {
        $this->subscriptionDetails[] = $subscriptionDetail;
        return $this;
    }

    /**
     * isset subscriptionDetails
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSubscriptionDetails($index)
    {
        return isset($this->subscriptionDetails[$index]);
    }

    /**
     * unset subscriptionDetails
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSubscriptionDetails($index)
    {
        unset($this->subscriptionDetails[$index]);
    }

    /**
     * Gets as subscriptionDetails
     *
     * @return \net\authorize\api\contract\v1\SubscriptionDetailType[]
     */
    public function getSubscriptionDetails()
    {
        return $this->subscriptionDetails;
    }

    /**
     * Sets a new subscriptionDetails
     *
     * @param \net\authorize\api\contract\v1\SubscriptionDetailType[]
     * $subscriptionDetails
     * @return self
     */
    public function setSubscriptionDetails(array $subscriptionDetails)
    {
        $this->subscriptionDetails = $subscriptionDetails;
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

