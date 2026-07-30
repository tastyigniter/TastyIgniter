<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing ProfileTransactionType
 *
 * 
 * XSD Type: profileTransactionType
 */
class ProfileTransactionType implements \JsonSerializable
{

    /**
     * @property \net\authorize\api\contract\v1\ProfileTransAuthCaptureType
     * $profileTransAuthCapture
     */
    private $profileTransAuthCapture = null;

    /**
     * @property \net\authorize\api\contract\v1\ProfileTransAuthOnlyType
     * $profileTransAuthOnly
     */
    private $profileTransAuthOnly = null;

    /**
     * @property \net\authorize\api\contract\v1\ProfileTransPriorAuthCaptureType
     * $profileTransPriorAuthCapture
     */
    private $profileTransPriorAuthCapture = null;

    /**
     * @property \net\authorize\api\contract\v1\ProfileTransCaptureOnlyType
     * $profileTransCaptureOnly
     */
    private $profileTransCaptureOnly = null;

    /**
     * @property \net\authorize\api\contract\v1\ProfileTransRefundType
     * $profileTransRefund
     */
    private $profileTransRefund = null;

    /**
     * @property \net\authorize\api\contract\v1\ProfileTransVoidType $profileTransVoid
     */
    private $profileTransVoid = null;

    /**
     * Gets as profileTransAuthCapture
     *
     * @return \net\authorize\api\contract\v1\ProfileTransAuthCaptureType
     */
    public function getProfileTransAuthCapture()
    {
        return $this->profileTransAuthCapture;
    }

    /**
     * Sets a new profileTransAuthCapture
     *
     * @param \net\authorize\api\contract\v1\ProfileTransAuthCaptureType
     * $profileTransAuthCapture
     * @return self
     */
    public function setProfileTransAuthCapture(\net\authorize\api\contract\v1\ProfileTransAuthCaptureType $profileTransAuthCapture)
    {
        $this->profileTransAuthCapture = $profileTransAuthCapture;
        return $this;
    }

    /**
     * Gets as profileTransAuthOnly
     *
     * @return \net\authorize\api\contract\v1\ProfileTransAuthOnlyType
     */
    public function getProfileTransAuthOnly()
    {
        return $this->profileTransAuthOnly;
    }

    /**
     * Sets a new profileTransAuthOnly
     *
     * @param \net\authorize\api\contract\v1\ProfileTransAuthOnlyType
     * $profileTransAuthOnly
     * @return self
     */
    public function setProfileTransAuthOnly(\net\authorize\api\contract\v1\ProfileTransAuthOnlyType $profileTransAuthOnly)
    {
        $this->profileTransAuthOnly = $profileTransAuthOnly;
        return $this;
    }

    /**
     * Gets as profileTransPriorAuthCapture
     *
     * @return \net\authorize\api\contract\v1\ProfileTransPriorAuthCaptureType
     */
    public function getProfileTransPriorAuthCapture()
    {
        return $this->profileTransPriorAuthCapture;
    }

    /**
     * Sets a new profileTransPriorAuthCapture
     *
     * @param \net\authorize\api\contract\v1\ProfileTransPriorAuthCaptureType
     * $profileTransPriorAuthCapture
     * @return self
     */
    public function setProfileTransPriorAuthCapture(\net\authorize\api\contract\v1\ProfileTransPriorAuthCaptureType $profileTransPriorAuthCapture)
    {
        $this->profileTransPriorAuthCapture = $profileTransPriorAuthCapture;
        return $this;
    }

    /**
     * Gets as profileTransCaptureOnly
     *
     * @return \net\authorize\api\contract\v1\ProfileTransCaptureOnlyType
     */
    public function getProfileTransCaptureOnly()
    {
        return $this->profileTransCaptureOnly;
    }

    /**
     * Sets a new profileTransCaptureOnly
     *
     * @param \net\authorize\api\contract\v1\ProfileTransCaptureOnlyType
     * $profileTransCaptureOnly
     * @return self
     */
    public function setProfileTransCaptureOnly(\net\authorize\api\contract\v1\ProfileTransCaptureOnlyType $profileTransCaptureOnly)
    {
        $this->profileTransCaptureOnly = $profileTransCaptureOnly;
        return $this;
    }

    /**
     * Gets as profileTransRefund
     *
     * @return \net\authorize\api\contract\v1\ProfileTransRefundType
     */
    public function getProfileTransRefund()
    {
        return $this->profileTransRefund;
    }

    /**
     * Sets a new profileTransRefund
     *
     * @param \net\authorize\api\contract\v1\ProfileTransRefundType $profileTransRefund
     * @return self
     */
    public function setProfileTransRefund(\net\authorize\api\contract\v1\ProfileTransRefundType $profileTransRefund)
    {
        $this->profileTransRefund = $profileTransRefund;
        return $this;
    }

    /**
     * Gets as profileTransVoid
     *
     * @return \net\authorize\api\contract\v1\ProfileTransVoidType
     */
    public function getProfileTransVoid()
    {
        return $this->profileTransVoid;
    }

    /**
     * Sets a new profileTransVoid
     *
     * @param \net\authorize\api\contract\v1\ProfileTransVoidType $profileTransVoid
     * @return self
     */
    public function setProfileTransVoid(\net\authorize\api\contract\v1\ProfileTransVoidType $profileTransVoid)
    {
        $this->profileTransVoid = $profileTransVoid;
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

