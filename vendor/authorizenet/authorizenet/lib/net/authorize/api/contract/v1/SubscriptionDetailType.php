<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing SubscriptionDetailType
 *
 * 
 * XSD Type: SubscriptionDetail
 */
class SubscriptionDetailType implements \JsonSerializable
{

    /**
     * @property integer $id
     */
    private $id = null;

    /**
     * @property string $name
     */
    private $name = null;

    /**
     * @property string $status
     */
    private $status = null;

    /**
     * @property \DateTime $createTimeStampUTC
     */
    private $createTimeStampUTC = null;

    /**
     * @property string $firstName
     */
    private $firstName = null;

    /**
     * @property string $lastName
     */
    private $lastName = null;

    /**
     * @property integer $totalOccurrences
     */
    private $totalOccurrences = null;

    /**
     * @property integer $pastOccurrences
     */
    private $pastOccurrences = null;

    /**
     * @property string $paymentMethod
     */
    private $paymentMethod = null;

    /**
     * @property string $accountNumber
     */
    private $accountNumber = null;

    /**
     * @property string $invoice
     */
    private $invoice = null;

    /**
     * @property float $amount
     */
    private $amount = null;

    /**
     * @property string $currencyCode
     */
    private $currencyCode = null;

    /**
     * @property integer $customerProfileId
     */
    private $customerProfileId = null;

    /**
     * @property integer $customerPaymentProfileId
     */
    private $customerPaymentProfileId = null;

    /**
     * @property integer $customerShippingProfileId
     */
    private $customerShippingProfileId = null;

    /**
     * Gets as id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets a new id
     *
     * @param integer $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

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
     * Gets as status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets a new status
     *
     * @param string $status
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Gets as createTimeStampUTC
     *
     * @return \DateTime
     */
    public function getCreateTimeStampUTC()
    {
        return $this->createTimeStampUTC;
    }

    /**
     * Sets a new createTimeStampUTC
     *
     * @param \DateTime $createTimeStampUTC
     * @return self
     */
    public function setCreateTimeStampUTC(\DateTime $createTimeStampUTC)
    {
        $this->createTimeStampUTC = $createTimeStampUTC;
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
     * Gets as totalOccurrences
     *
     * @return integer
     */
    public function getTotalOccurrences()
    {
        return $this->totalOccurrences;
    }

    /**
     * Sets a new totalOccurrences
     *
     * @param integer $totalOccurrences
     * @return self
     */
    public function setTotalOccurrences($totalOccurrences)
    {
        $this->totalOccurrences = $totalOccurrences;
        return $this;
    }

    /**
     * Gets as pastOccurrences
     *
     * @return integer
     */
    public function getPastOccurrences()
    {
        return $this->pastOccurrences;
    }

    /**
     * Sets a new pastOccurrences
     *
     * @param integer $pastOccurrences
     * @return self
     */
    public function setPastOccurrences($pastOccurrences)
    {
        $this->pastOccurrences = $pastOccurrences;
        return $this;
    }

    /**
     * Gets as paymentMethod
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * Sets a new paymentMethod
     *
     * @param string $paymentMethod
     * @return self
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
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
     * Gets as invoice
     *
     * @return string
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Sets a new invoice
     *
     * @param string $invoice
     * @return self
     */
    public function setInvoice($invoice)
    {
        $this->invoice = $invoice;
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
     * Gets as currencyCode
     *
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * Sets a new currencyCode
     *
     * @param string $currencyCode
     * @return self
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

    /**
     * Gets as customerProfileId
     *
     * @return integer
     */
    public function getCustomerProfileId()
    {
        return $this->customerProfileId;
    }

    /**
     * Sets a new customerProfileId
     *
     * @param integer $customerProfileId
     * @return self
     */
    public function setCustomerProfileId($customerProfileId)
    {
        $this->customerProfileId = $customerProfileId;
        return $this;
    }

    /**
     * Gets as customerPaymentProfileId
     *
     * @return integer
     */
    public function getCustomerPaymentProfileId()
    {
        return $this->customerPaymentProfileId;
    }

    /**
     * Sets a new customerPaymentProfileId
     *
     * @param integer $customerPaymentProfileId
     * @return self
     */
    public function setCustomerPaymentProfileId($customerPaymentProfileId)
    {
        $this->customerPaymentProfileId = $customerPaymentProfileId;
        return $this;
    }

    /**
     * Gets as customerShippingProfileId
     *
     * @return integer
     */
    public function getCustomerShippingProfileId()
    {
        return $this->customerShippingProfileId;
    }

    /**
     * Sets a new customerShippingProfileId
     *
     * @param integer $customerShippingProfileId
     * @return self
     */
    public function setCustomerShippingProfileId($customerShippingProfileId)
    {
        $this->customerShippingProfileId = $customerShippingProfileId;
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

