<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing GetHostedPaymentPageRequest
 */
class GetHostedPaymentPageRequest extends ANetApiRequestType
{

    /**
     * @property \net\authorize\api\contract\v1\TransactionRequestType
     * $transactionRequest
     */
    private $transactionRequest = null;

    /**
     * Allowed values for settingName are: hostedPaymentIFrameCommunicatorUrl,
     * hostedPaymentButtonOptions, hostedPaymentReturnOptions,
     * hostedPaymentOrderOptions, hostedPaymentPaymentOptions,
     * hostedPaymentBillingAddressOptions, hostedPaymentShippingAddressOptions,
     * hostedPaymentSecurityOptions, hostedPaymentCustomerOptions,
     * hostedPaymentStyleOptions
     *
     * @property \net\authorize\api\contract\v1\SettingType[] $hostedPaymentSettings
     */
    private $hostedPaymentSettings = null;

    /**
     * Gets as transactionRequest
     *
     * @return \net\authorize\api\contract\v1\TransactionRequestType
     */
    public function getTransactionRequest()
    {
        return $this->transactionRequest;
    }

    /**
     * Sets a new transactionRequest
     *
     * @param \net\authorize\api\contract\v1\TransactionRequestType $transactionRequest
     * @return self
     */
    public function setTransactionRequest(\net\authorize\api\contract\v1\TransactionRequestType $transactionRequest)
    {
        $this->transactionRequest = $transactionRequest;
        return $this;
    }

    /**
     * Adds as setting
     *
     * Allowed values for settingName are: hostedPaymentIFrameCommunicatorUrl,
     * hostedPaymentButtonOptions, hostedPaymentReturnOptions,
     * hostedPaymentOrderOptions, hostedPaymentPaymentOptions,
     * hostedPaymentBillingAddressOptions, hostedPaymentShippingAddressOptions,
     * hostedPaymentSecurityOptions, hostedPaymentCustomerOptions,
     * hostedPaymentStyleOptions
     *
     * @return self
     * @param \net\authorize\api\contract\v1\SettingType $setting
     */
    public function addToHostedPaymentSettings(\net\authorize\api\contract\v1\SettingType $setting)
    {
        $this->hostedPaymentSettings[] = $setting;
        return $this;
    }

    /**
     * isset hostedPaymentSettings
     *
     * Allowed values for settingName are: hostedPaymentIFrameCommunicatorUrl,
     * hostedPaymentButtonOptions, hostedPaymentReturnOptions,
     * hostedPaymentOrderOptions, hostedPaymentPaymentOptions,
     * hostedPaymentBillingAddressOptions, hostedPaymentShippingAddressOptions,
     * hostedPaymentSecurityOptions, hostedPaymentCustomerOptions,
     * hostedPaymentStyleOptions
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetHostedPaymentSettings($index)
    {
        return isset($this->hostedPaymentSettings[$index]);
    }

    /**
     * unset hostedPaymentSettings
     *
     * Allowed values for settingName are: hostedPaymentIFrameCommunicatorUrl,
     * hostedPaymentButtonOptions, hostedPaymentReturnOptions,
     * hostedPaymentOrderOptions, hostedPaymentPaymentOptions,
     * hostedPaymentBillingAddressOptions, hostedPaymentShippingAddressOptions,
     * hostedPaymentSecurityOptions, hostedPaymentCustomerOptions,
     * hostedPaymentStyleOptions
     *
     * @param scalar $index
     * @return void
     */
    public function unsetHostedPaymentSettings($index)
    {
        unset($this->hostedPaymentSettings[$index]);
    }

    /**
     * Gets as hostedPaymentSettings
     *
     * Allowed values for settingName are: hostedPaymentIFrameCommunicatorUrl,
     * hostedPaymentButtonOptions, hostedPaymentReturnOptions,
     * hostedPaymentOrderOptions, hostedPaymentPaymentOptions,
     * hostedPaymentBillingAddressOptions, hostedPaymentShippingAddressOptions,
     * hostedPaymentSecurityOptions, hostedPaymentCustomerOptions,
     * hostedPaymentStyleOptions
     *
     * @return \net\authorize\api\contract\v1\SettingType[]
     */
    public function getHostedPaymentSettings()
    {
        return $this->hostedPaymentSettings;
    }

    /**
     * Sets a new hostedPaymentSettings
     *
     * Allowed values for settingName are: hostedPaymentIFrameCommunicatorUrl,
     * hostedPaymentButtonOptions, hostedPaymentReturnOptions,
     * hostedPaymentOrderOptions, hostedPaymentPaymentOptions,
     * hostedPaymentBillingAddressOptions, hostedPaymentShippingAddressOptions,
     * hostedPaymentSecurityOptions, hostedPaymentCustomerOptions,
     * hostedPaymentStyleOptions
     *
     * @param \net\authorize\api\contract\v1\SettingType[] $hostedPaymentSettings
     * @return self
     */
    public function setHostedPaymentSettings(array $hostedPaymentSettings)
    {
        $this->hostedPaymentSettings = $hostedPaymentSettings;
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
        return array_merge(parent::jsonSerialize(), $values);
    }

}

