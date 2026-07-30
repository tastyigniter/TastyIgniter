<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing BatchStatisticType
 *
 * 
 * XSD Type: batchStatisticType
 */
class BatchStatisticType implements \JsonSerializable
{

    /**
     * @property string $accountType
     */
    private $accountType = null;

    /**
     * @property float $chargeAmount
     */
    private $chargeAmount = null;

    /**
     * @property integer $chargeCount
     */
    private $chargeCount = null;

    /**
     * @property float $refundAmount
     */
    private $refundAmount = null;

    /**
     * @property integer $refundCount
     */
    private $refundCount = null;

    /**
     * @property integer $voidCount
     */
    private $voidCount = null;

    /**
     * @property integer $declineCount
     */
    private $declineCount = null;

    /**
     * @property integer $errorCount
     */
    private $errorCount = null;

    /**
     * @property float $returnedItemAmount
     */
    private $returnedItemAmount = null;

    /**
     * @property integer $returnedItemCount
     */
    private $returnedItemCount = null;

    /**
     * @property float $chargebackAmount
     */
    private $chargebackAmount = null;

    /**
     * @property integer $chargebackCount
     */
    private $chargebackCount = null;

    /**
     * @property integer $correctionNoticeCount
     */
    private $correctionNoticeCount = null;

    /**
     * @property float $chargeChargeBackAmount
     */
    private $chargeChargeBackAmount = null;

    /**
     * @property integer $chargeChargeBackCount
     */
    private $chargeChargeBackCount = null;

    /**
     * @property float $refundChargeBackAmount
     */
    private $refundChargeBackAmount = null;

    /**
     * @property integer $refundChargeBackCount
     */
    private $refundChargeBackCount = null;

    /**
     * @property float $chargeReturnedItemsAmount
     */
    private $chargeReturnedItemsAmount = null;

    /**
     * @property integer $chargeReturnedItemsCount
     */
    private $chargeReturnedItemsCount = null;

    /**
     * @property float $refundReturnedItemsAmount
     */
    private $refundReturnedItemsAmount = null;

    /**
     * @property integer $refundReturnedItemsCount
     */
    private $refundReturnedItemsCount = null;

    /**
     * Gets as accountType
     *
     * @return string
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * Sets a new accountType
     *
     * @param string $accountType
     * @return self
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
        return $this;
    }

    /**
     * Gets as chargeAmount
     *
     * @return float
     */
    public function getChargeAmount()
    {
        return $this->chargeAmount;
    }

    /**
     * Sets a new chargeAmount
     *
     * @param float $chargeAmount
     * @return self
     */
    public function setChargeAmount($chargeAmount)
    {
        $this->chargeAmount = $chargeAmount;
        return $this;
    }

    /**
     * Gets as chargeCount
     *
     * @return integer
     */
    public function getChargeCount()
    {
        return $this->chargeCount;
    }

    /**
     * Sets a new chargeCount
     *
     * @param integer $chargeCount
     * @return self
     */
    public function setChargeCount($chargeCount)
    {
        $this->chargeCount = $chargeCount;
        return $this;
    }

    /**
     * Gets as refundAmount
     *
     * @return float
     */
    public function getRefundAmount()
    {
        return $this->refundAmount;
    }

    /**
     * Sets a new refundAmount
     *
     * @param float $refundAmount
     * @return self
     */
    public function setRefundAmount($refundAmount)
    {
        $this->refundAmount = $refundAmount;
        return $this;
    }

    /**
     * Gets as refundCount
     *
     * @return integer
     */
    public function getRefundCount()
    {
        return $this->refundCount;
    }

    /**
     * Sets a new refundCount
     *
     * @param integer $refundCount
     * @return self
     */
    public function setRefundCount($refundCount)
    {
        $this->refundCount = $refundCount;
        return $this;
    }

    /**
     * Gets as voidCount
     *
     * @return integer
     */
    public function getVoidCount()
    {
        return $this->voidCount;
    }

    /**
     * Sets a new voidCount
     *
     * @param integer $voidCount
     * @return self
     */
    public function setVoidCount($voidCount)
    {
        $this->voidCount = $voidCount;
        return $this;
    }

    /**
     * Gets as declineCount
     *
     * @return integer
     */
    public function getDeclineCount()
    {
        return $this->declineCount;
    }

    /**
     * Sets a new declineCount
     *
     * @param integer $declineCount
     * @return self
     */
    public function setDeclineCount($declineCount)
    {
        $this->declineCount = $declineCount;
        return $this;
    }

    /**
     * Gets as errorCount
     *
     * @return integer
     */
    public function getErrorCount()
    {
        return $this->errorCount;
    }

    /**
     * Sets a new errorCount
     *
     * @param integer $errorCount
     * @return self
     */
    public function setErrorCount($errorCount)
    {
        $this->errorCount = $errorCount;
        return $this;
    }

    /**
     * Gets as returnedItemAmount
     *
     * @return float
     */
    public function getReturnedItemAmount()
    {
        return $this->returnedItemAmount;
    }

    /**
     * Sets a new returnedItemAmount
     *
     * @param float $returnedItemAmount
     * @return self
     */
    public function setReturnedItemAmount($returnedItemAmount)
    {
        $this->returnedItemAmount = $returnedItemAmount;
        return $this;
    }

    /**
     * Gets as returnedItemCount
     *
     * @return integer
     */
    public function getReturnedItemCount()
    {
        return $this->returnedItemCount;
    }

    /**
     * Sets a new returnedItemCount
     *
     * @param integer $returnedItemCount
     * @return self
     */
    public function setReturnedItemCount($returnedItemCount)
    {
        $this->returnedItemCount = $returnedItemCount;
        return $this;
    }

    /**
     * Gets as chargebackAmount
     *
     * @return float
     */
    public function getChargebackAmount()
    {
        return $this->chargebackAmount;
    }

    /**
     * Sets a new chargebackAmount
     *
     * @param float $chargebackAmount
     * @return self
     */
    public function setChargebackAmount($chargebackAmount)
    {
        $this->chargebackAmount = $chargebackAmount;
        return $this;
    }

    /**
     * Gets as chargebackCount
     *
     * @return integer
     */
    public function getChargebackCount()
    {
        return $this->chargebackCount;
    }

    /**
     * Sets a new chargebackCount
     *
     * @param integer $chargebackCount
     * @return self
     */
    public function setChargebackCount($chargebackCount)
    {
        $this->chargebackCount = $chargebackCount;
        return $this;
    }

    /**
     * Gets as correctionNoticeCount
     *
     * @return integer
     */
    public function getCorrectionNoticeCount()
    {
        return $this->correctionNoticeCount;
    }

    /**
     * Sets a new correctionNoticeCount
     *
     * @param integer $correctionNoticeCount
     * @return self
     */
    public function setCorrectionNoticeCount($correctionNoticeCount)
    {
        $this->correctionNoticeCount = $correctionNoticeCount;
        return $this;
    }

    /**
     * Gets as chargeChargeBackAmount
     *
     * @return float
     */
    public function getChargeChargeBackAmount()
    {
        return $this->chargeChargeBackAmount;
    }

    /**
     * Sets a new chargeChargeBackAmount
     *
     * @param float $chargeChargeBackAmount
     * @return self
     */
    public function setChargeChargeBackAmount($chargeChargeBackAmount)
    {
        $this->chargeChargeBackAmount = $chargeChargeBackAmount;
        return $this;
    }

    /**
     * Gets as chargeChargeBackCount
     *
     * @return integer
     */
    public function getChargeChargeBackCount()
    {
        return $this->chargeChargeBackCount;
    }

    /**
     * Sets a new chargeChargeBackCount
     *
     * @param integer $chargeChargeBackCount
     * @return self
     */
    public function setChargeChargeBackCount($chargeChargeBackCount)
    {
        $this->chargeChargeBackCount = $chargeChargeBackCount;
        return $this;
    }

    /**
     * Gets as refundChargeBackAmount
     *
     * @return float
     */
    public function getRefundChargeBackAmount()
    {
        return $this->refundChargeBackAmount;
    }

    /**
     * Sets a new refundChargeBackAmount
     *
     * @param float $refundChargeBackAmount
     * @return self
     */
    public function setRefundChargeBackAmount($refundChargeBackAmount)
    {
        $this->refundChargeBackAmount = $refundChargeBackAmount;
        return $this;
    }

    /**
     * Gets as refundChargeBackCount
     *
     * @return integer
     */
    public function getRefundChargeBackCount()
    {
        return $this->refundChargeBackCount;
    }

    /**
     * Sets a new refundChargeBackCount
     *
     * @param integer $refundChargeBackCount
     * @return self
     */
    public function setRefundChargeBackCount($refundChargeBackCount)
    {
        $this->refundChargeBackCount = $refundChargeBackCount;
        return $this;
    }

    /**
     * Gets as chargeReturnedItemsAmount
     *
     * @return float
     */
    public function getChargeReturnedItemsAmount()
    {
        return $this->chargeReturnedItemsAmount;
    }

    /**
     * Sets a new chargeReturnedItemsAmount
     *
     * @param float $chargeReturnedItemsAmount
     * @return self
     */
    public function setChargeReturnedItemsAmount($chargeReturnedItemsAmount)
    {
        $this->chargeReturnedItemsAmount = $chargeReturnedItemsAmount;
        return $this;
    }

    /**
     * Gets as chargeReturnedItemsCount
     *
     * @return integer
     */
    public function getChargeReturnedItemsCount()
    {
        return $this->chargeReturnedItemsCount;
    }

    /**
     * Sets a new chargeReturnedItemsCount
     *
     * @param integer $chargeReturnedItemsCount
     * @return self
     */
    public function setChargeReturnedItemsCount($chargeReturnedItemsCount)
    {
        $this->chargeReturnedItemsCount = $chargeReturnedItemsCount;
        return $this;
    }

    /**
     * Gets as refundReturnedItemsAmount
     *
     * @return float
     */
    public function getRefundReturnedItemsAmount()
    {
        return $this->refundReturnedItemsAmount;
    }

    /**
     * Sets a new refundReturnedItemsAmount
     *
     * @param float $refundReturnedItemsAmount
     * @return self
     */
    public function setRefundReturnedItemsAmount($refundReturnedItemsAmount)
    {
        $this->refundReturnedItemsAmount = $refundReturnedItemsAmount;
        return $this;
    }

    /**
     * Gets as refundReturnedItemsCount
     *
     * @return integer
     */
    public function getRefundReturnedItemsCount()
    {
        return $this->refundReturnedItemsCount;
    }

    /**
     * Sets a new refundReturnedItemsCount
     *
     * @param integer $refundReturnedItemsCount
     * @return self
     */
    public function setRefundReturnedItemsCount($refundReturnedItemsCount)
    {
        $this->refundReturnedItemsCount = $refundReturnedItemsCount;
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

