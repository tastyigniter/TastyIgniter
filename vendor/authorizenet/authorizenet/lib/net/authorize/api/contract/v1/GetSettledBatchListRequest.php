<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing GetSettledBatchListRequest
 */
class GetSettledBatchListRequest extends ANetApiRequestType
{

    /**
     * @property boolean $includeStatistics
     */
    private $includeStatistics = null;

    /**
     * @property \DateTime $firstSettlementDate
     */
    private $firstSettlementDate = null;

    /**
     * @property \DateTime $lastSettlementDate
     */
    private $lastSettlementDate = null;

    /**
     * Gets as includeStatistics
     *
     * @return boolean
     */
    public function getIncludeStatistics()
    {
        return $this->includeStatistics;
    }

    /**
     * Sets a new includeStatistics
     *
     * @param boolean $includeStatistics
     * @return self
     */
    public function setIncludeStatistics($includeStatistics)
    {
        $this->includeStatistics = $includeStatistics;
        return $this;
    }

    /**
     * Gets as firstSettlementDate
     *
     * @return \DateTime
     */
    public function getFirstSettlementDate()
    {
        return $this->firstSettlementDate;
    }

    /**
     * Sets a new firstSettlementDate
     *
     * @param \DateTime $firstSettlementDate
     * @return self
     */
    public function setFirstSettlementDate(\DateTime $firstSettlementDate)
    {
        $this->firstSettlementDate = $firstSettlementDate;
        return $this;
    }

    /**
     * Gets as lastSettlementDate
     *
     * @return \DateTime
     */
    public function getLastSettlementDate()
    {
        return $this->lastSettlementDate;
    }

    /**
     * Sets a new lastSettlementDate
     *
     * @param \DateTime $lastSettlementDate
     * @return self
     */
    public function setLastSettlementDate(\DateTime $lastSettlementDate)
    {
        $this->lastSettlementDate = $lastSettlementDate;
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

