<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing ARBGetSubscriptionRequest
 */
class ARBGetSubscriptionRequest extends ANetApiRequestType
{

    /**
     * @property string $subscriptionId
     */
    private $subscriptionId = null;

    /**
     * @property boolean $includeTransactions
     */
    private $includeTransactions = null;

    /**
     * Gets as subscriptionId
     *
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

    /**
     * Sets a new subscriptionId
     *
     * @param string $subscriptionId
     * @return self
     */
    public function setSubscriptionId($subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
        return $this;
    }

    /**
     * Gets as includeTransactions
     *
     * @return boolean
     */
    public function getIncludeTransactions()
    {
        return $this->includeTransactions;
    }

    /**
     * Sets a new includeTransactions
     *
     * @param boolean $includeTransactions
     * @return self
     */
    public function setIncludeTransactions($includeTransactions)
    {
        $this->includeTransactions = $includeTransactions;
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

