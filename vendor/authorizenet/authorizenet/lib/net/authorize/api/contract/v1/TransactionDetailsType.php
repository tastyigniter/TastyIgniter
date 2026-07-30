<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing TransactionDetailsType
 *
 * 
 * XSD Type: transactionDetailsType
 */
class TransactionDetailsType implements \JsonSerializable
{

    /**
     * @property string $transId
     */
    private $transId = null;

    /**
     * @property string $refTransId
     */
    private $refTransId = null;

    /**
     * @property string $splitTenderId
     */
    private $splitTenderId = null;

    /**
     * @property \DateTime $submitTimeUTC
     */
    private $submitTimeUTC = null;

    /**
     * @property \DateTime $submitTimeLocal
     */
    private $submitTimeLocal = null;

    /**
     * @property string $transactionType
     */
    private $transactionType = null;

    /**
     * @property string $transactionStatus
     */
    private $transactionStatus = null;

    /**
     * @property integer $responseCode
     */
    private $responseCode = null;

    /**
     * @property integer $responseReasonCode
     */
    private $responseReasonCode = null;

    /**
     * @property \net\authorize\api\contract\v1\SubscriptionPaymentType $subscription
     */
    private $subscription = null;

    /**
     * @property string $responseReasonDescription
     */
    private $responseReasonDescription = null;

    /**
     * @property string $authCode
     */
    private $authCode = null;

    /**
     * @property string $aVSResponse
     */
    private $aVSResponse = null;

    /**
     * @property string $cardCodeResponse
     */
    private $cardCodeResponse = null;

    /**
     * @property string $cAVVResponse
     */
    private $cAVVResponse = null;

    /**
     * @property string $fDSFilterAction
     */
    private $fDSFilterAction = null;

    /**
     * @property \net\authorize\api\contract\v1\FDSFilterType[] $fDSFilters
     */
    private $fDSFilters = null;

    /**
     * @property \net\authorize\api\contract\v1\BatchDetailsType $batch
     */
    private $batch = null;

    /**
     * @property \net\authorize\api\contract\v1\OrderExType $order
     */
    private $order = null;

    /**
     * @property float $requestedAmount
     */
    private $requestedAmount = null;

    /**
     * @property float $authAmount
     */
    private $authAmount = null;

    /**
     * @property float $settleAmount
     */
    private $settleAmount = null;

    /**
     * @property \net\authorize\api\contract\v1\ExtendedAmountType $tax
     */
    private $tax = null;

    /**
     * @property \net\authorize\api\contract\v1\ExtendedAmountType $shipping
     */
    private $shipping = null;

    /**
     * @property \net\authorize\api\contract\v1\ExtendedAmountType $duty
     */
    private $duty = null;

    /**
     * @property \net\authorize\api\contract\v1\LineItemType[] $lineItems
     */
    private $lineItems = null;

    /**
     * @property float $prepaidBalanceRemaining
     */
    private $prepaidBalanceRemaining = null;

    /**
     * @property boolean $taxExempt
     */
    private $taxExempt = null;

    /**
     * @property \net\authorize\api\contract\v1\PaymentMaskedType $payment
     */
    private $payment = null;

    /**
     * @property \net\authorize\api\contract\v1\CustomerDataType $customer
     */
    private $customer = null;

    /**
     * @property \net\authorize\api\contract\v1\CustomerAddressType $billTo
     */
    private $billTo = null;

    /**
     * @property \net\authorize\api\contract\v1\NameAndAddressType $shipTo
     */
    private $shipTo = null;

    /**
     * @property boolean $recurringBilling
     */
    private $recurringBilling = null;

    /**
     * @property string $customerIP
     */
    private $customerIP = null;

    /**
     * @property string $product
     */
    private $product = null;

    /**
     * @property string $entryMode
     */
    private $entryMode = null;

    /**
     * @property string $marketType
     */
    private $marketType = null;

    /**
     * @property string $mobileDeviceId
     */
    private $mobileDeviceId = null;

    /**
     * @property string $customerSignature
     */
    private $customerSignature = null;

    /**
     * @property \net\authorize\api\contract\v1\ReturnedItemType[] $returnedItems
     */
    private $returnedItems = null;

    /**
     * @property \net\authorize\api\contract\v1\SolutionType $solution
     */
    private $solution = null;

    /**
     * @property
     * \net\authorize\api\contract\v1\TransactionDetailsType\EmvDetailsAType\TagAType[]
     * $emvDetails
     */
    private $emvDetails = null;

    /**
     * @property \net\authorize\api\contract\v1\CustomerProfileIdType $profile
     */
    private $profile = null;

    /**
     * @property \net\authorize\api\contract\v1\ExtendedAmountType $surcharge
     */
    private $surcharge = null;

    /**
     * @property string $employeeId
     */
    private $employeeId = null;

    /**
     * @property \net\authorize\api\contract\v1\ExtendedAmountType $tip
     */
    private $tip = null;

    /**
     * @property \net\authorize\api\contract\v1\OtherTaxType $otherTax
     */
    private $otherTax = null;

    /**
     * @property \net\authorize\api\contract\v1\NameAndAddressType $shipFrom
     */
    private $shipFrom = null;

    /**
     * @property string $networkTransId
     */
    private $networkTransId = null;

    /**
     * @property string $originalNetworkTransId
     */
    private $originalNetworkTransId = null;

    /**
     * @property float $originalAuthAmount
     */
    private $originalAuthAmount = null;

    /**
     * @property string $authorizationIndicator
     */
    private $authorizationIndicator = null;

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
     * Gets as refTransId
     *
     * @return string
     */
    public function getRefTransId()
    {
        return $this->refTransId;
    }

    /**
     * Sets a new refTransId
     *
     * @param string $refTransId
     * @return self
     */
    public function setRefTransId($refTransId)
    {
        $this->refTransId = $refTransId;
        return $this;
    }

    /**
     * Gets as splitTenderId
     *
     * @return string
     */
    public function getSplitTenderId()
    {
        return $this->splitTenderId;
    }

    /**
     * Sets a new splitTenderId
     *
     * @param string $splitTenderId
     * @return self
     */
    public function setSplitTenderId($splitTenderId)
    {
        $this->splitTenderId = $splitTenderId;
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
     * Gets as transactionType
     *
     * @return string
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }

    /**
     * Sets a new transactionType
     *
     * @param string $transactionType
     * @return self
     */
    public function setTransactionType($transactionType)
    {
        $this->transactionType = $transactionType;
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
     * Gets as responseCode
     *
     * @return integer
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Sets a new responseCode
     *
     * @param integer $responseCode
     * @return self
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
        return $this;
    }

    /**
     * Gets as responseReasonCode
     *
     * @return integer
     */
    public function getResponseReasonCode()
    {
        return $this->responseReasonCode;
    }

    /**
     * Sets a new responseReasonCode
     *
     * @param integer $responseReasonCode
     * @return self
     */
    public function setResponseReasonCode($responseReasonCode)
    {
        $this->responseReasonCode = $responseReasonCode;
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
     * Gets as responseReasonDescription
     *
     * @return string
     */
    public function getResponseReasonDescription()
    {
        return $this->responseReasonDescription;
    }

    /**
     * Sets a new responseReasonDescription
     *
     * @param string $responseReasonDescription
     * @return self
     */
    public function setResponseReasonDescription($responseReasonDescription)
    {
        $this->responseReasonDescription = $responseReasonDescription;
        return $this;
    }

    /**
     * Gets as authCode
     *
     * @return string
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * Sets a new authCode
     *
     * @param string $authCode
     * @return self
     */
    public function setAuthCode($authCode)
    {
        $this->authCode = $authCode;
        return $this;
    }

    /**
     * Gets as aVSResponse
     *
     * @return string
     */
    public function getAVSResponse()
    {
        return $this->aVSResponse;
    }

    /**
     * Sets a new aVSResponse
     *
     * @param string $aVSResponse
     * @return self
     */
    public function setAVSResponse($aVSResponse)
    {
        $this->aVSResponse = $aVSResponse;
        return $this;
    }

    /**
     * Gets as cardCodeResponse
     *
     * @return string
     */
    public function getCardCodeResponse()
    {
        return $this->cardCodeResponse;
    }

    /**
     * Sets a new cardCodeResponse
     *
     * @param string $cardCodeResponse
     * @return self
     */
    public function setCardCodeResponse($cardCodeResponse)
    {
        $this->cardCodeResponse = $cardCodeResponse;
        return $this;
    }

    /**
     * Gets as cAVVResponse
     *
     * @return string
     */
    public function getCAVVResponse()
    {
        return $this->cAVVResponse;
    }

    /**
     * Sets a new cAVVResponse
     *
     * @param string $cAVVResponse
     * @return self
     */
    public function setCAVVResponse($cAVVResponse)
    {
        $this->cAVVResponse = $cAVVResponse;
        return $this;
    }

    /**
     * Gets as fDSFilterAction
     *
     * @return string
     */
    public function getFDSFilterAction()
    {
        return $this->fDSFilterAction;
    }

    /**
     * Sets a new fDSFilterAction
     *
     * @param string $fDSFilterAction
     * @return self
     */
    public function setFDSFilterAction($fDSFilterAction)
    {
        $this->fDSFilterAction = $fDSFilterAction;
        return $this;
    }

    /**
     * Adds as fDSFilter
     *
     * @return self
     * @param \net\authorize\api\contract\v1\FDSFilterType $fDSFilter
     */
    public function addToFDSFilters(\net\authorize\api\contract\v1\FDSFilterType $fDSFilter)
    {
        $this->fDSFilters[] = $fDSFilter;
        return $this;
    }

    /**
     * isset fDSFilters
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetFDSFilters($index)
    {
        return isset($this->fDSFilters[$index]);
    }

    /**
     * unset fDSFilters
     *
     * @param scalar $index
     * @return void
     */
    public function unsetFDSFilters($index)
    {
        unset($this->fDSFilters[$index]);
    }

    /**
     * Gets as fDSFilters
     *
     * @return \net\authorize\api\contract\v1\FDSFilterType[]
     */
    public function getFDSFilters()
    {
        return $this->fDSFilters;
    }

    /**
     * Sets a new fDSFilters
     *
     * @param \net\authorize\api\contract\v1\FDSFilterType[] $fDSFilters
     * @return self
     */
    public function setFDSFilters(array $fDSFilters)
    {
        $this->fDSFilters = $fDSFilters;
        return $this;
    }

    /**
     * Gets as batch
     *
     * @return \net\authorize\api\contract\v1\BatchDetailsType
     */
    public function getBatch()
    {
        return $this->batch;
    }

    /**
     * Sets a new batch
     *
     * @param \net\authorize\api\contract\v1\BatchDetailsType $batch
     * @return self
     */
    public function setBatch(\net\authorize\api\contract\v1\BatchDetailsType $batch)
    {
        $this->batch = $batch;
        return $this;
    }

    /**
     * Gets as order
     *
     * @return \net\authorize\api\contract\v1\OrderExType
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Sets a new order
     *
     * @param \net\authorize\api\contract\v1\OrderExType $order
     * @return self
     */
    public function setOrder(\net\authorize\api\contract\v1\OrderExType $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * Gets as requestedAmount
     *
     * @return float
     */
    public function getRequestedAmount()
    {
        return $this->requestedAmount;
    }

    /**
     * Sets a new requestedAmount
     *
     * @param float $requestedAmount
     * @return self
     */
    public function setRequestedAmount($requestedAmount)
    {
        $this->requestedAmount = $requestedAmount;
        return $this;
    }

    /**
     * Gets as authAmount
     *
     * @return float
     */
    public function getAuthAmount()
    {
        return $this->authAmount;
    }

    /**
     * Sets a new authAmount
     *
     * @param float $authAmount
     * @return self
     */
    public function setAuthAmount($authAmount)
    {
        $this->authAmount = $authAmount;
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
     * Gets as tax
     *
     * @return \net\authorize\api\contract\v1\ExtendedAmountType
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Sets a new tax
     *
     * @param \net\authorize\api\contract\v1\ExtendedAmountType $tax
     * @return self
     */
    public function setTax(\net\authorize\api\contract\v1\ExtendedAmountType $tax)
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * Gets as shipping
     *
     * @return \net\authorize\api\contract\v1\ExtendedAmountType
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * Sets a new shipping
     *
     * @param \net\authorize\api\contract\v1\ExtendedAmountType $shipping
     * @return self
     */
    public function setShipping(\net\authorize\api\contract\v1\ExtendedAmountType $shipping)
    {
        $this->shipping = $shipping;
        return $this;
    }

    /**
     * Gets as duty
     *
     * @return \net\authorize\api\contract\v1\ExtendedAmountType
     */
    public function getDuty()
    {
        return $this->duty;
    }

    /**
     * Sets a new duty
     *
     * @param \net\authorize\api\contract\v1\ExtendedAmountType $duty
     * @return self
     */
    public function setDuty(\net\authorize\api\contract\v1\ExtendedAmountType $duty)
    {
        $this->duty = $duty;
        return $this;
    }

    /**
     * Adds as lineItem
     *
     * @return self
     * @param \net\authorize\api\contract\v1\LineItemType $lineItem
     */
    public function addToLineItems(\net\authorize\api\contract\v1\LineItemType $lineItem)
    {
        $this->lineItems[] = $lineItem;
        return $this;
    }

    /**
     * isset lineItems
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetLineItems($index)
    {
        return isset($this->lineItems[$index]);
    }

    /**
     * unset lineItems
     *
     * @param scalar $index
     * @return void
     */
    public function unsetLineItems($index)
    {
        unset($this->lineItems[$index]);
    }

    /**
     * Gets as lineItems
     *
     * @return \net\authorize\api\contract\v1\LineItemType[]
     */
    public function getLineItems()
    {
        return $this->lineItems;
    }

    /**
     * Sets a new lineItems
     *
     * @param \net\authorize\api\contract\v1\LineItemType[] $lineItems
     * @return self
     */
    public function setLineItems(array $lineItems)
    {
        $this->lineItems = $lineItems;
        return $this;
    }

    /**
     * Gets as prepaidBalanceRemaining
     *
     * @return float
     */
    public function getPrepaidBalanceRemaining()
    {
        return $this->prepaidBalanceRemaining;
    }

    /**
     * Sets a new prepaidBalanceRemaining
     *
     * @param float $prepaidBalanceRemaining
     * @return self
     */
    public function setPrepaidBalanceRemaining($prepaidBalanceRemaining)
    {
        $this->prepaidBalanceRemaining = $prepaidBalanceRemaining;
        return $this;
    }

    /**
     * Gets as taxExempt
     *
     * @return boolean
     */
    public function getTaxExempt()
    {
        return $this->taxExempt;
    }

    /**
     * Sets a new taxExempt
     *
     * @param boolean $taxExempt
     * @return self
     */
    public function setTaxExempt($taxExempt)
    {
        $this->taxExempt = $taxExempt;
        return $this;
    }

    /**
     * Gets as payment
     *
     * @return \net\authorize\api\contract\v1\PaymentMaskedType
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Sets a new payment
     *
     * @param \net\authorize\api\contract\v1\PaymentMaskedType $payment
     * @return self
     */
    public function setPayment(\net\authorize\api\contract\v1\PaymentMaskedType $payment)
    {
        $this->payment = $payment;
        return $this;
    }

    /**
     * Gets as customer
     *
     * @return \net\authorize\api\contract\v1\CustomerDataType
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Sets a new customer
     *
     * @param \net\authorize\api\contract\v1\CustomerDataType $customer
     * @return self
     */
    public function setCustomer(\net\authorize\api\contract\v1\CustomerDataType $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * Gets as billTo
     *
     * @return \net\authorize\api\contract\v1\CustomerAddressType
     */
    public function getBillTo()
    {
        return $this->billTo;
    }

    /**
     * Sets a new billTo
     *
     * @param \net\authorize\api\contract\v1\CustomerAddressType $billTo
     * @return self
     */
    public function setBillTo(\net\authorize\api\contract\v1\CustomerAddressType $billTo)
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
     * Gets as recurringBilling
     *
     * @return boolean
     */
    public function getRecurringBilling()
    {
        return $this->recurringBilling;
    }

    /**
     * Sets a new recurringBilling
     *
     * @param boolean $recurringBilling
     * @return self
     */
    public function setRecurringBilling($recurringBilling)
    {
        $this->recurringBilling = $recurringBilling;
        return $this;
    }

    /**
     * Gets as customerIP
     *
     * @return string
     */
    public function getCustomerIP()
    {
        return $this->customerIP;
    }

    /**
     * Sets a new customerIP
     *
     * @param string $customerIP
     * @return self
     */
    public function setCustomerIP($customerIP)
    {
        $this->customerIP = $customerIP;
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
     * Gets as entryMode
     *
     * @return string
     */
    public function getEntryMode()
    {
        return $this->entryMode;
    }

    /**
     * Sets a new entryMode
     *
     * @param string $entryMode
     * @return self
     */
    public function setEntryMode($entryMode)
    {
        $this->entryMode = $entryMode;
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
     * Gets as customerSignature
     *
     * @return string
     */
    public function getCustomerSignature()
    {
        return $this->customerSignature;
    }

    /**
     * Sets a new customerSignature
     *
     * @param string $customerSignature
     * @return self
     */
    public function setCustomerSignature($customerSignature)
    {
        $this->customerSignature = $customerSignature;
        return $this;
    }

    /**
     * Adds as returnedItem
     *
     * @return self
     * @param \net\authorize\api\contract\v1\ReturnedItemType $returnedItem
     */
    public function addToReturnedItems(\net\authorize\api\contract\v1\ReturnedItemType $returnedItem)
    {
        $this->returnedItems[] = $returnedItem;
        return $this;
    }

    /**
     * isset returnedItems
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetReturnedItems($index)
    {
        return isset($this->returnedItems[$index]);
    }

    /**
     * unset returnedItems
     *
     * @param scalar $index
     * @return void
     */
    public function unsetReturnedItems($index)
    {
        unset($this->returnedItems[$index]);
    }

    /**
     * Gets as returnedItems
     *
     * @return \net\authorize\api\contract\v1\ReturnedItemType[]
     */
    public function getReturnedItems()
    {
        return $this->returnedItems;
    }

    /**
     * Sets a new returnedItems
     *
     * @param \net\authorize\api\contract\v1\ReturnedItemType[] $returnedItems
     * @return self
     */
    public function setReturnedItems(array $returnedItems)
    {
        $this->returnedItems = $returnedItems;
        return $this;
    }

    /**
     * Gets as solution
     *
     * @return \net\authorize\api\contract\v1\SolutionType
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * Sets a new solution
     *
     * @param \net\authorize\api\contract\v1\SolutionType $solution
     * @return self
     */
    public function setSolution(\net\authorize\api\contract\v1\SolutionType $solution)
    {
        $this->solution = $solution;
        return $this;
    }

    /**
     * Adds as tag
     *
     * @return self
     * @param
     * \net\authorize\api\contract\v1\TransactionDetailsType\EmvDetailsAType\TagAType
     * $tag
     */
    public function addToEmvDetails(\net\authorize\api\contract\v1\TransactionDetailsType\EmvDetailsAType\TagAType $tag)
    {
        $this->emvDetails[] = $tag;
        return $this;
    }

    /**
     * isset emvDetails
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetEmvDetails($index)
    {
        return isset($this->emvDetails[$index]);
    }

    /**
     * unset emvDetails
     *
     * @param scalar $index
     * @return void
     */
    public function unsetEmvDetails($index)
    {
        unset($this->emvDetails[$index]);
    }

    /**
     * Gets as emvDetails
     *
     * @return
     * \net\authorize\api\contract\v1\TransactionDetailsType\EmvDetailsAType\TagAType[]
     */
    public function getEmvDetails()
    {
        return $this->emvDetails;
    }

    /**
     * Sets a new emvDetails
     *
     * @param
     * \net\authorize\api\contract\v1\TransactionDetailsType\EmvDetailsAType\TagAType[]
     * $emvDetails
     * @return self
     */
    public function setEmvDetails(array $emvDetails)
    {
        $this->emvDetails = $emvDetails;
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

    /**
     * Gets as surcharge
     *
     * @return \net\authorize\api\contract\v1\ExtendedAmountType
     */
    public function getSurcharge()
    {
        return $this->surcharge;
    }

    /**
     * Sets a new surcharge
     *
     * @param \net\authorize\api\contract\v1\ExtendedAmountType $surcharge
     * @return self
     */
    public function setSurcharge(\net\authorize\api\contract\v1\ExtendedAmountType $surcharge)
    {
        $this->surcharge = $surcharge;
        return $this;
    }

    /**
     * Gets as employeeId
     *
     * @return string
     */
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * Sets a new employeeId
     *
     * @param string $employeeId
     * @return self
     */
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;
        return $this;
    }

    /**
     * Gets as tip
     *
     * @return \net\authorize\api\contract\v1\ExtendedAmountType
     */
    public function getTip()
    {
        return $this->tip;
    }

    /**
     * Sets a new tip
     *
     * @param \net\authorize\api\contract\v1\ExtendedAmountType $tip
     * @return self
     */
    public function setTip(\net\authorize\api\contract\v1\ExtendedAmountType $tip)
    {
        $this->tip = $tip;
        return $this;
    }

    /**
     * Gets as otherTax
     *
     * @return \net\authorize\api\contract\v1\OtherTaxType
     */
    public function getOtherTax()
    {
        return $this->otherTax;
    }

    /**
     * Sets a new otherTax
     *
     * @param \net\authorize\api\contract\v1\OtherTaxType $otherTax
     * @return self
     */
    public function setOtherTax(\net\authorize\api\contract\v1\OtherTaxType $otherTax)
    {
        $this->otherTax = $otherTax;
        return $this;
    }

    /**
     * Gets as shipFrom
     *
     * @return \net\authorize\api\contract\v1\NameAndAddressType
     */
    public function getShipFrom()
    {
        return $this->shipFrom;
    }

    /**
     * Sets a new shipFrom
     *
     * @param \net\authorize\api\contract\v1\NameAndAddressType $shipFrom
     * @return self
     */
    public function setShipFrom(\net\authorize\api\contract\v1\NameAndAddressType $shipFrom)
    {
        $this->shipFrom = $shipFrom;
        return $this;
    }

    /**
     * Gets as networkTransId
     *
     * @return string
     */
    public function getNetworkTransId()
    {
        return $this->networkTransId;
    }

    /**
     * Sets a new networkTransId
     *
     * @param string $networkTransId
     * @return self
     */
    public function setNetworkTransId($networkTransId)
    {
        $this->networkTransId = $networkTransId;
        return $this;
    }

    /**
     * Gets as originalNetworkTransId
     *
     * @return string
     */
    public function getOriginalNetworkTransId()
    {
        return $this->originalNetworkTransId;
    }

    /**
     * Sets a new originalNetworkTransId
     *
     * @param string $originalNetworkTransId
     * @return self
     */
    public function setOriginalNetworkTransId($originalNetworkTransId)
    {
        $this->originalNetworkTransId = $originalNetworkTransId;
        return $this;
    }

    /**
     * Gets as originalAuthAmount
     *
     * @return float
     */
    public function getOriginalAuthAmount()
    {
        return $this->originalAuthAmount;
    }

    /**
     * Sets a new originalAuthAmount
     *
     * @param float $originalAuthAmount
     * @return self
     */
    public function setOriginalAuthAmount($originalAuthAmount)
    {
        $this->originalAuthAmount = $originalAuthAmount;
        return $this;
    }

    /**
     * Gets as authorizationIndicator
     *
     * @return string
     */
    public function getAuthorizationIndicator()
    {
        return $this->authorizationIndicator;
    }

    /**
     * Sets a new authorizationIndicator
     *
     * @param string $authorizationIndicator
     * @return self
     */
    public function setAuthorizationIndicator($authorizationIndicator)
    {
        $this->authorizationIndicator = $authorizationIndicator;
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

