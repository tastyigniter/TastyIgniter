<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing GetSettledBatchListResponse
 */
class GetSettledBatchListResponse extends ANetApiResponseType
{

    /**
     * @property \net\authorize\api\contract\v1\BatchDetailsType[] $batchList
     */
    private $batchList = null;

    /**
     * Adds as batch
     *
     * @return self
     * @param \net\authorize\api\contract\v1\BatchDetailsType $batch
     */
    public function addToBatchList(\net\authorize\api\contract\v1\BatchDetailsType $batch)
    {
        $this->batchList[] = $batch;
        return $this;
    }

    /**
     * isset batchList
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetBatchList($index)
    {
        return isset($this->batchList[$index]);
    }

    /**
     * unset batchList
     *
     * @param scalar $index
     * @return void
     */
    public function unsetBatchList($index)
    {
        unset($this->batchList[$index]);
    }

    /**
     * Gets as batchList
     *
     * @return \net\authorize\api\contract\v1\BatchDetailsType[]
     */
    public function getBatchList()
    {
        return $this->batchList;
    }

    /**
     * Sets a new batchList
     *
     * @param \net\authorize\api\contract\v1\BatchDetailsType[] $batchList
     * @return self
     */
    public function setBatchList(array $batchList)
    {
        $this->batchList = $batchList;
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

