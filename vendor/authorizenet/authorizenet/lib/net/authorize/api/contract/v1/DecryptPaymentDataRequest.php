<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing DecryptPaymentDataRequest
 */
class DecryptPaymentDataRequest extends ANetApiRequestType
{

    /**
     * @property \net\authorize\api\contract\v1\OpaqueDataType $opaqueData
     */
    private $opaqueData = null;

    /**
     * @property string $callId
     */
    private $callId = null;

    /**
     * Gets as opaqueData
     *
     * @return \net\authorize\api\contract\v1\OpaqueDataType
     */
    public function getOpaqueData()
    {
        return $this->opaqueData;
    }

    /**
     * Sets a new opaqueData
     *
     * @param \net\authorize\api\contract\v1\OpaqueDataType $opaqueData
     * @return self
     */
    public function setOpaqueData(\net\authorize\api\contract\v1\OpaqueDataType $opaqueData)
    {
        $this->opaqueData = $opaqueData;
        return $this;
    }

    /**
     * Gets as callId
     *
     * @return string
     */
    public function getCallId()
    {
        return $this->callId;
    }

    /**
     * Sets a new callId
     *
     * @param string $callId
     * @return self
     */
    public function setCallId($callId)
    {
        $this->callId = $callId;
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

