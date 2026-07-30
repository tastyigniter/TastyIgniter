<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing SecurePaymentContainerRequest
 */
class SecurePaymentContainerRequest extends ANetApiRequestType
{

    /**
     * @property \net\authorize\api\contract\v1\WebCheckOutDataType $data
     */
    private $data = null;

    /**
     * Gets as data
     *
     * @return \net\authorize\api\contract\v1\WebCheckOutDataType
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets a new data
     *
     * @param \net\authorize\api\contract\v1\WebCheckOutDataType $data
     * @return self
     */
    public function setData(\net\authorize\api\contract\v1\WebCheckOutDataType $data)
    {
        $this->data = $data;
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

