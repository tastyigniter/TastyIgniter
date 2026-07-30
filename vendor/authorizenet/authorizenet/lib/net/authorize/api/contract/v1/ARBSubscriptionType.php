<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing ARBSubscriptionType
 *
 * 
 * XSD Type: ARBSubscriptionType
 */
class ARBSubscriptionType implements \JsonSerializable
{

    /**
     * @property string $name
     */
    private $name = null;

    /**
     * @property \net\authorize\api\contract\v1\PaymentScheduleType $paymentSchedule
     */
    private $paymentSchedule = null;

    /**
     * @property float $amount
     */
    private $amount = null;

    /**
     * @property float $trialAmount
     */
    private $trialAmount = null;

    /**
     * @property \net\authorize\api\contract\v1\PaymentType $payment
     */
    private $payment = null;

    /**
     * @property \net\authorize\api\contract\v1\OrderType $order
     */
    private $order = null;

    /**
     * @property \net\authorize\api\contract\v1\CustomerType $customer
     */
    private $customer = null;

    /**
     * @property \net\authorize\api\contract\v1\NameAndAddressType $billTo
     */
    private $billTo = null;

    /**
     * @property \net\authorize\api\contract\v1\NameAndAddressType $shipTo
     */
    private $shipTo = null;

    /**
     * @property \net\authorize\api\contract\v1\CustomerProfileIdType $profile
     */
    private $profile = null;

    /**
     * Gets as name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets a new name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets as paymentSchedule
     *
     * @return \net\authorize\api\contract\v1\PaymentScheduleType
     */
    public function getPaymentSchedule()
    {
        return $this->paymentSchedule;
    }

    /**
     * Sets a new paymentSchedule
     *
     * @param \net\authorize\api\contract\v1\PaymentScheduleType $paymentSchedule
     * @return self
     */
    public function setPaymentSchedule(\net\authorize\api\contract\v1\PaymentScheduleType $paymentSchedule)
    {
        $this->paymentSchedule = $paymentSchedule;
        return $this;
    }

    /**
     * Gets as amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Sets a new amount
     *
     * @param float $amount
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * Gets as trialAmount
     *
     * @return float
     */
    public function getTrialAmount()
    {
        return $this->trialAmount;
    }

    /**
     * Sets a new trialAmount
     *
     * @param float $trialAmount
     * @return self
     */
    public function setTrialAmount($trialAmount)
    {
        $this->trialAmount = $trialAmount;
        return $this;
    }

    /**
     * Gets as payment
     *
     * @return \net\authorize\api\contract\v1\PaymentType
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Sets a new payment
     *
     * @param \net\authorize\api\contract\v1\PaymentType $payment
     * @return self
     */
    public function setPayment(\net\authorize\api\contract\v1\PaymentType $payment)
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * Gets as order
     *
     * @return \net\authorize\api\contract\v1\OrderType
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Sets a new order
     *
     * @param \net\authorize\api\contract\v1\OrderType $order
     * @return self
     */
    public function setOrder(\net\authorize\api\contract\v1\OrderType $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Gets as customer
     *
     * @return \net\authorize\api\contract\v1\CustomerType
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Sets a new customer
     *
     * @param \net\authorize\api\contract\v1\CustomerType $customer
     * @return self
     */
    public function setCustomer(\net\authorize\api\contract\v1\CustomerType $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * Gets as billTo
     *
     * @return \net\authorize\api\contract\v1\NameAndAddressType
     */
    public function getBillTo()
    {
        return $this->billTo;
    }

    /**
     * Sets a new billTo
     *
     * @param \net\authorize\api\contract\v1\NameAndAddressType $billTo
     * @return self
     */
    public function setBillTo(\net\authorize\api\contract\v1\NameAndAddressType $billTo)
    {
        $this->billTo = $billTo;
        return $this;
    }

    /**
     * Gets as shipTo
     *
     * @return \net\authorize\api\contract\v1\NameAndAddressType
     */
    public function getShipTo()
    {
        return $this->shipTo;
    }

    /**
     * Sets a new shipTo
     *
     * @param \net\authorize\api\contract\v1\NameAndAddressType $shipTo
     * @return self
     */
    public function setShipTo(\net\authorize\api\contract\v1\NameAndAddressType $shipTo)
    {
        $this->shipTo = $shipTo;
        return $this;
    }

    /**
     * Gets as profile
     *
     * @return \net\authorize\api\contract\v1\CustomerProfileIdType
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Sets a new profile
     *
     * @param \net\authorize\api\contract\v1\CustomerProfileIdType $profile
     * @return self
     */
    public function setProfile(\net\authorize\api\contract\v1\CustomerProfileIdType $profile)
    {
        $this->profile = $profile;
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

