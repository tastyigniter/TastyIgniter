<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing GetAUJobSummaryResponse
 */
class GetAUJobSummaryResponse extends ANetApiResponseType
{

    /**
     * @property \net\authorize\api\contract\v1\AuResponseType[] $auSummary
     */
    private $auSummary = null;

    /**
     * Adds as auResponse
     *
     * @return self
     * @param \net\authorize\api\contract\v1\AuResponseType $auResponse
     */
    public function addToAuSummary(\net\authorize\api\contract\v1\AuResponseType $auResponse)
    {
        $this->auSummary[] = $auResponse;
        return $this;
    }

    /**
     * isset auSummary
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetAuSummary($index)
    {
        return isset($this->auSummary[$index]);
    }

    /**
     * unset auSummary
     *
     * @param scalar $index
     * @return void
     */
    public function unsetAuSummary($index)
    {
        unset($this->auSummary[$index]);
    }

    /**
     * Gets as auSummary
     *
     * @return \net\authorize\api\contract\v1\AuResponseType[]
     */
    public function getAuSummary()
    {
        return $this->auSummary;
    }

    /**
     * Sets a new auSummary
     *
     * @param \net\authorize\api\contract\v1\AuResponseType[] $auSummary
     * @return self
     */
    public function setAuSummary(array $auSummary)
    {
        $this->auSummary = $auSummary;
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

