<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing EnumCollection
 */
class EnumCollection
{

    /**
     * @property \net\authorize\api\contract\v1\CustomerProfileSummaryType
     * $customerProfileSummaryType
     */
    private $customerProfileSummaryType = null;

    /**
     * @property \net\authorize\api\contract\v1\PaymentSimpleType $paymentSimpleType
     */
    private $paymentSimpleType = null;

    /**
     * @property string $accountTypeEnum
     */
    private $accountTypeEnum = null;

    /**
     * @property string $cardTypeEnum
     */
    private $cardTypeEnum = null;

    /**
     * @property string $fDSFilterActionEnum
     */
    private $fDSFilterActionEnum = null;

    /**
     * @property string $permissionsEnum
     */
    private $permissionsEnum = null;

    /**
     * @property string $settingNameEnum
     */
    private $settingNameEnum = null;

    /**
     * @property string $settlementStateEnum
     */
    private $settlementStateEnum = null;

    /**
     * @property string $transactionStatusEnum
     */
    private $transactionStatusEnum = null;

    /**
     * @property string $transactionTypeEnum
     */
    private $transactionTypeEnum = null;

    /**
     * Gets as customerProfileSummaryType
     *
     * @return \net\authorize\api\contract\v1\CustomerProfileSummaryType
     */
    public function getCustomerProfileSummaryType()
    {
        return $this->customerProfileSummaryType;
    }

    /**
     * Sets a new customerProfileSummaryType
     *
     * @param \net\authorize\api\contract\v1\CustomerProfileSummaryType
     * $customerProfileSummaryType
     * @return self
     */
    public function setCustomerProfileSummaryType(\net\authorize\api\contract\v1\CustomerProfileSummaryType $customerProfileSummaryType)
    {
        $this->customerProfileSummaryType = $customerProfileSummaryType;
        return $this;
    }

    /**
     * Gets as paymentSimpleType
     *
     * @return \net\authorize\api\contract\v1\PaymentSimpleType
     */
    public function getPaymentSimpleType()
    {
        return $this->paymentSimpleType;
    }

    /**
     * Sets a new paymentSimpleType
     *
     * @param \net\authorize\api\contract\v1\PaymentSimpleType $paymentSimpleType
     * @return self
     */
    public function setPaymentSimpleType(\net\authorize\api\contract\v1\PaymentSimpleType $paymentSimpleType)
    {
        $this->paymentSimpleType = $paymentSimpleType;
        return $this;
    }

    /**
     * Gets as accountTypeEnum
     *
     * @return string
     */
    public function getAccountTypeEnum()
    {
        return $this->accountTypeEnum;
    }

    /**
     * Sets a new accountTypeEnum
     *
     * @param string $accountTypeEnum
     * @return self
     */
    public function setAccountTypeEnum($accountTypeEnum)
    {
        $this->accountTypeEnum = $accountTypeEnum;
        return $this;
    }

    /**
     * Gets as cardTypeEnum
     *
     * @return string
     */
    public function getCardTypeEnum()
    {
        return $this->cardTypeEnum;
    }

    /**
     * Sets a new cardTypeEnum
     *
     * @param string $cardTypeEnum
     * @return self
     */
    public function setCardTypeEnum($cardTypeEnum)
    {
        $this->cardTypeEnum = $cardTypeEnum;
        return $this;
    }

    /**
     * Gets as fDSFilterActionEnum
     *
     * @return string
     */
    public function getFDSFilterActionEnum()
    {
        return $this->fDSFilterActionEnum;
    }

    /**
     * Sets a new fDSFilterActionEnum
     *
     * @param string $fDSFilterActionEnum
     * @return self
     */
    public function setFDSFilterActionEnum($fDSFilterActionEnum)
    {
        $this->fDSFilterActionEnum = $fDSFilterActionEnum;
        return $this;
    }

    /**
     * Gets as permissionsEnum
     *
     * @return string
     */
    public function getPermissionsEnum()
    {
        return $this->permissionsEnum;
    }

    /**
     * Sets a new permissionsEnum
     *
     * @param string $permissionsEnum
     * @return self
     */
    public function setPermissionsEnum($permissionsEnum)
    {
        $this->permissionsEnum = $permissionsEnum;
        return $this;
    }

    /**
     * Gets as settingNameEnum
     *
     * @return string
     */
    public function getSettingNameEnum()
    {
        return $this->settingNameEnum;
    }

    /**
     * Sets a new settingNameEnum
     *
     * @param string $settingNameEnum
     * @return self
     */
    public function setSettingNameEnum($settingNameEnum)
    {
        $this->settingNameEnum = $settingNameEnum;
        return $this;
    }

    /**
     * Gets as settlementStateEnum
     *
     * @return string
     */
    public function getSettlementStateEnum()
    {
        return $this->settlementStateEnum;
    }

    /**
     * Sets a new settlementStateEnum
     *
     * @param string $settlementStateEnum
     * @return self
     */
    public function setSettlementStateEnum($settlementStateEnum)
    {
        $this->settlementStateEnum = $settlementStateEnum;
        return $this;
    }

    /**
     * Gets as transactionStatusEnum
     *
     * @return string
     */
    public function getTransactionStatusEnum()
    {
        return $this->transactionStatusEnum;
    }

    /**
     * Sets a new transactionStatusEnum
     *
     * @param string $transactionStatusEnum
     * @return self
     */
    public function setTransactionStatusEnum($transactionStatusEnum)
    {
        $this->transactionStatusEnum = $transactionStatusEnum;
        return $this;
    }

    /**
     * Gets as transactionTypeEnum
     *
     * @return string
     */
    public function getTransactionTypeEnum()
    {
        return $this->transactionTypeEnum;
    }

    /**
     * Sets a new transactionTypeEnum
     *
     * @param string $transactionTypeEnum
     * @return self
     */
    public function setTransactionTypeEnum($transactionTypeEnum)
    {
        $this->transactionTypeEnum = $transactionTypeEnum;
        return $this;
    }


}

