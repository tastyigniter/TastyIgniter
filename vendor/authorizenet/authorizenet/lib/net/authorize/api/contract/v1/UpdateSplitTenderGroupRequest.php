<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing UpdateSplitTenderGroupRequest
 */
class UpdateSplitTenderGroupRequest extends ANetApiRequestType
{

    /**
     * @property string $splitTenderId
     */
    private $splitTenderId = null;

    /**
     * @property string $splitTenderStatus
     */
    private $splitTenderStatus = null;

    /**
     * Gets as splitTenderId
     *
     * @return string
     */
    public function getSplitTenderId()
    {
        return $this->splitTenderId;
    }

    /**
     * Sets a new splitTenderId
     *
     * @param string $splitTenderId
     * @return self
     */
    public function setSplitTenderId($splitTenderId)
    {
        $this->splitTenderId = $splitTenderId;
        return $this;
    }

    /**
     * Gets as splitTenderStatus
     *
     * @return string
     */
    public function getSplitTenderStatus()
    {
        return $this->splitTenderStatus;
    }

    /**
     * Sets a new splitTenderStatus
     *
     * @param string $splitTenderStatus
     * @return self
     */
    public function setSplitTenderStatus($splitTenderStatus)
    {
        $this->splitTenderStatus = $splitTenderStatus;
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

