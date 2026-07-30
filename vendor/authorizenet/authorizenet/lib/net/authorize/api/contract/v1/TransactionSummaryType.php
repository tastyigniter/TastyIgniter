<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing TransactionSummaryType
 *
 * 
 * XSD Type: transactionSummaryType
 */
class TransactionSummaryType implements \JsonSerializable
{

    /**
     * @property string $transId
     */
    private $transId = null;

    /**
     * @property \DateTime $submitTimeUTC
     */
    private $submitTimeUTC = null;

    /**
     * @property \DateTime $submitTimeLocal
     */
    private $submitTimeLocal = null;

    /**
     * @property string $transactionStatus
     */
    private $transactionStatus = null;

    /**
     * @property string $invoiceNumber
     */
    private $invoiceNumber = null;

    /**
     * @property string $firstName
     */
    private $firstName = null;

    /**
     * @property string $lastName
     */
    private $lastName = null;

    /**
     * @property string $accountType
     */
    private $accountType = null;

    /**
     * @property string $accountNumber
     */
    private $accountNumber = null;

    /**
     * @property float $settleAmount
     */
    private $settleAmount = null;

    /**
     * @property string $marketType
     */
    private $marketType = null;

    /**
     * @property string $product
     */
    private $product = null;

    /**
     * @property string $mobileDeviceId
     */
    private $mobileDeviceId = null;

    /**
     * @property \net\authorize\api\contract\v1\SubscriptionPaymentType $subscription
     */
    private $subscription = null;

    /**
     * @property boolean $hasReturnedItems
     */
    private $hasReturnedItems = null;

    /**
     * @property \net\authorize\api\contract\v1\FraudInformationType $fraudInformation
     */
    private $fraudInformation = null;

    /**
     * @property \net\authorize\api\contract\v1\CustomerProfileIdType $profile
     */
    private $profile = null;

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
     * Gets as submitTimeLocal
     *
     * @return \DateTime
     */
    public function getSubmitTimeLocal()
    {
        return $this->submitTimeLocal;
    }

    /**
     * Sets a new submitTimeLocal
     *
     * @param \DateTime $submitTimeLocal
     * @return self
     */
    public function setSubmitTimeLocal(\DateTime $submitTimeLocal)
    {
        $this->submitTimeLocal = $submitTimeLocal;
        return $this;
    }

    /**
     * Gets as transactionStatus
     *
     * @return string
     */
    public function getTransactionStatus()
    {
        return $this->transactionStatus;
    }

    /**
     * Sets a new transactionStatus
     *
     * @param string $transactionStatus
     * @return self
     */
    public function setTransactionStatus($transactionStatus)
    {
        $this->transactionStatus = $transactionStatus;
        return $this;
    }

    /**
     * Gets as invoiceNumber
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Sets a new invoiceNumber
     *
     * @param string $invoiceNumber
     * @return self
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
        return $this;
    }

    /**
     * Gets as firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets a new firstName
     *
     * @param string $firstName
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * Gets as lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Sets a new lastName
     *
     * @param string $lastName
     * @return self
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

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
     * Gets as accountNumber
     *
     * @return string
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Sets a new accountNumber
     *
     * @param string $accountNumber
     * @return self
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * Gets as settleAmount
     *
     * @return float
     */
    public function getSettleAmount()
    {
        return $this->settleAmount;
    }

    /**
     * Sets a new settleAmount
     *
     * @param float $settleAmount
     * @return self
     */
    public function setSettleAmount($settleAmount)
    {
        $this->settleAmount = $settleAmount;
        return $this;
    }

    /**
     * Gets as marketType
     *
     * @return string
     */
    public function getMarketType()
    {
        return $this->marketType;
    }

    /**
     * Sets a new marketType
     *
     * @param string $marketType
     * @return self
     */
    public function setMarketType($marketType)
    {
        $this->marketType = $marketType;
        return $this;
    }

    /**
     * Gets as product
     *
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Sets a new product
     *
     * @param string $product
     * @return self
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * Gets as mobileDeviceId
     *
     * @return string
     */
    public function getMobileDeviceId()
    {
        return $this->mobileDeviceId;
    }

    /**
     * Sets a new mobileDeviceId
     *
     * @param string $mobileDeviceId
     * @return self
     */
    public function setMobileDeviceId($mobileDeviceId)
    {
        $this->mobileDeviceId = $mobileDeviceId;
        return $this;
    }

    /**
     * Gets as subscription
     *
     * @return \net\authorize\api\contract\v1\SubscriptionPaymentType
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * Sets a new subscription
     *
     * @param \net\authorize\api\contract\v1\SubscriptionPaymentType $subscription
     * @return self
     */
    public function setSubscription(\net\authorize\api\contract\v1\SubscriptionPaymentType $subscription)
    {
        $this->subscription = $subscription;
        return $this;
    }

    /**
     * Gets as hasReturnedItems
     *
     * @return boolean
     */
    public function getHasReturnedItems()
    {
        return $this->hasReturnedItems;
    }

    /**
     * Sets a new hasReturnedItems
     *
     * @param boolean $hasReturnedItems
     * @return self
     */
    public function setHasReturnedItems($hasReturnedItems)
    {
        $this->hasReturnedItems = $hasReturnedItems;
        return $this;
    }

    /**
     * Gets as fraudInformation
     *
     * @return \net\authorize\api\contract\v1\FraudInformationType
     */
    public function getFraudInformation()
    {
        return $this->fraudInformation;
    }

    /**
     * Sets a new fraudInformation
     *
     * @param \net\authorize\api\contract\v1\FraudInformationType $fraudInformation
     * @return self
     */
    public function setFraudInformation(\net\authorize\api\contract\v1\FraudInformationType $fraudInformation)
    {
        $this->fraudInformation = $fraudInformation;
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

