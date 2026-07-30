<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing ARBUpdateSubscriptionResponse
 */
class ARBUpdateSubscriptionResponse extends ANetApiResponseType
{

    /**
     * @property \net\authorize\api\contract\v1\CustomerProfileIdType $profile
     */
    private $profile = null;

    /**
     * Gets as profile
     *
     * @return \net\authorize\api\contract\v1\CustomerProfileIdType
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Sets a new profile
     *
     * @param \net\authorize\api\contract\v1\CustomerProfileIdType $profile
     * @return self
     */
    public function setProfile(\net\authorize\api\contract\v1\CustomerProfileIdType $profile)
    {
        $this->profile = $profile;
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

