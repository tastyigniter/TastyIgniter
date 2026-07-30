<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing ArbTransactionType
 *
 * 
 * XSD Type: arbTransaction
 */
class ArbTransactionType implements \JsonSerializable
{

    /**
     * @property string $transId
     */
    private $transId = null;

    /**
     * @property string $response
     */
    private $response = null;

    /**
     * @property \DateTime $submitTimeUTC
     */
    private $submitTimeUTC = null;

    /**
     * @property integer $payNum
     */
    private $payNum = null;

    /**
     * @property integer $attemptNum
     */
    private $attemptNum = null;

    /**
     * Gets as transId
     *
     * @return string
     */
    public function getTransId()
    {
        return $this->transId;
    }

    /**
     * Sets a new transId
     *
     * @param string $transId
     * @return self
     */
    public function setTransId($transId)
    {
        $this->transId = $transId;
        return $this;
    }

    /**
     * Gets as response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sets a new response
     *
     * @param string $response
     * @return self
     */
    public function setResponse($response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Gets as submitTimeUTC
     *
     * @return \DateTime
     */
    public function getSubmitTimeUTC()
    {
        return $this->submitTimeUTC;
    }

    /**
     * Sets a new submitTimeUTC
     *
     * @param \DateTime $submitTimeUTC
     * @return self
     */
    public function setSubmitTimeUTC(\DateTime $submitTimeUTC)
    {
        $this->submitTimeUTC = $submitTimeUTC;
        return $this;
    }

    /**
     * Gets as payNum
     *
     * @return integer
     */
    public function getPayNum()
    {
        return $this->payNum;
    }

    /**
     * Sets a new payNum
     *
     * @param integer $payNum
     * @return self
     */
    public function setPayNum($payNum)
    {
        $this->payNum = $payNum;
        return $this;
    }

    /**
     * Gets as attemptNum
     *
     * @return integer
     */
    public function getAttemptNum()
    {
        return $this->attemptNum;
    }

    /**
     * Sets a new attemptNum
     *
     * @param integer $attemptNum
     * @return self
     */
    public function setAttemptNum($attemptNum)
    {
        $this->attemptNum = $attemptNum;
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

