<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing UpdateCustomerProfileRequest
 */
class UpdateCustomerProfileRequest extends ANetApiRequestType
{

    /**
     * @property \net\authorize\api\contract\v1\CustomerProfileExType $profile
     */
    private $profile = null;

    /**
     * Gets as profile
     *
     * @return \net\authorize\api\contract\v1\CustomerProfileExType
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Sets a new profile
     *
     * @param \net\authorize\api\contract\v1\CustomerProfileExType $profile
     * @return self
     */
    public function setProfile(\net\authorize\api\contract\v1\CustomerProfileExType $profile)
    {
        $this->profile = $profile;
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

