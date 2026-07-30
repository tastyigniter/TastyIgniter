<?php

namespace net\authorize\api\contract\v1\TransactionResponseType;

/**
 * Class representing SplitTenderPaymentsAType
 */
class SplitTenderPaymentsAType implements \JsonSerializable
{

    /**
     * @property
     * \net\authorize\api\contract\v1\TransactionResponseType\SplitTenderPaymentsAType\SplitTenderPaymentAType[]
     * $splitTenderPayment
     */
    private $splitTenderPayment = null;

    /**
     * Adds as splitTenderPayment
     *
     * @return self
     * @param
     * \net\authorize\api\contract\v1\TransactionResponseType\SplitTenderPaymentsAType\SplitTenderPaymentAType
     * $splitTenderPayment
     */
    public function addToSplitTenderPayment(\net\authorize\api\contract\v1\TransactionResponseType\SplitTenderPaymentsAType\SplitTenderPaymentAType $splitTenderPayment)
    {
        $this->splitTenderPayment[] = $splitTenderPayment;
        return $this;
    }

    /**
     * isset splitTenderPayment
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetSplitTenderPayment($index)
    {
        return isset($this->splitTenderPayment[$index]);
    }

    /**
     * unset splitTenderPayment
     *
     * @param scalar $index
     * @return void
     */
    public function unsetSplitTenderPayment($index)
    {
        unset($this->splitTenderPayment[$index]);
    }

    /**
     * Gets as splitTenderPayment
     *
     * @return
     * \net\authorize\api\contract\v1\TransactionResponseType\SplitTenderPaymentsAType\SplitTenderPaymentAType[]
     */
    public function getSplitTenderPayment()
    {
        return $this->splitTenderPayment;
    }

    /**
     * Sets a new splitTenderPayment
     *
     * @param
     * \net\authorize\api\contract\v1\TransactionResponseType\SplitTenderPaymentsAType\SplitTenderPaymentAType[]
     * $splitTenderPayment
     * @return self
     */
    public function setSplitTenderPayment(array $splitTenderPayment)
    {
        $this->splitTenderPayment = $splitTenderPayment;
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

