<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing GetHostedProfilePageRequest
 */
class GetHostedProfilePageRequest extends ANetApiRequestType
{

    /**
     * @property string $customerProfileId
     */
    private $customerProfileId = null;

    /**
     * Allowed values for settingName are: hostedProfileReturnUrl,
     * hostedProfileReturnUrlText, hostedProfilePageBorderVisible,
     * hostedProfileIFrameCommunicatorUrl, hostedProfileHeadingBgColor,
     * hostedProfileBillingAddressRequired, hostedProfileCardCodeRequired,
     * hostedProfileBillingAddressOptions, hostedProfileManageOptions,
     * hostedProfilePaymentOptions, hostedProfileSaveButtonText.
     *
     * @property \net\authorize\api\contract\v1\SettingType[] $hostedProfileSettings
     */
    private $hostedProfileSettings = null;

    /**
     * Gets as customerProfileId
     *
     * @return string
     */
    public function getCustomerProfileId()
    {
        return $this->customerProfileId;
    }

    /**
     * Sets a new customerProfileId
     *
     * @param string $customerProfileId
     * @return self
     */
    public function setCustomerProfileId($customerProfileId)
    {
        $this->customerProfileId = $customerProfileId;
        return $this;
    }

    /**
     * Adds as setting
     *
     * Allowed values for settingName are: hostedProfileReturnUrl,
     * hostedProfileReturnUrlText, hostedProfilePageBorderVisible,
     * hostedProfileIFrameCommunicatorUrl, hostedProfileHeadingBgColor,
     * hostedProfileBillingAddressRequired, hostedProfileCardCodeRequired,
     * hostedProfileBillingAddressOptions, hostedProfileManageOptions,
     * hostedProfilePaymentOptions, hostedProfileSaveButtonText.
     *
     * @return self
     * @param \net\authorize\api\contract\v1\SettingType $setting
     */
    public function addToHostedProfileSettings(\net\authorize\api\contract\v1\SettingType $setting)
    {
        $this->hostedProfileSettings[] = $setting;
        return $this;
    }

    /**
     * isset hostedProfileSettings
     *
     * Allowed values for settingName are: hostedProfileReturnUrl,
     * hostedProfileReturnUrlText, hostedProfilePageBorderVisible,
     * hostedProfileIFrameCommunicatorUrl, hostedProfileHeadingBgColor,
     * hostedProfileBillingAddressRequired, hostedProfileCardCodeRequired,
     * hostedProfileBillingAddressOptions, hostedProfileManageOptions,
     * hostedProfilePaymentOptions, hostedProfileSaveButtonText.
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetHostedProfileSettings($index)
    {
        return isset($this->hostedProfileSettings[$index]);
    }

    /**
     * unset hostedProfileSettings
     *
     * Allowed values for settingName are: hostedProfileReturnUrl,
     * hostedProfileReturnUrlText, hostedProfilePageBorderVisible,
     * hostedProfileIFrameCommunicatorUrl, hostedProfileHeadingBgColor,
     * hostedProfileBillingAddressRequired, hostedProfileCardCodeRequired,
     * hostedProfileBillingAddressOptions, hostedProfileManageOptions,
     * hostedProfilePaymentOptions, hostedProfileSaveButtonText.
     *
     * @param scalar $index
     * @return void
     */
    public function unsetHostedProfileSettings($index)
    {
        unset($this->hostedProfileSettings[$index]);
    }

    /**
     * Gets as hostedProfileSettings
     *
     * Allowed values for settingName are: hostedProfileReturnUrl,
     * hostedProfileReturnUrlText, hostedProfilePageBorderVisible,
     * hostedProfileIFrameCommunicatorUrl, hostedProfileHeadingBgColor,
     * hostedProfileBillingAddressRequired, hostedProfileCardCodeRequired,
     * hostedProfileBillingAddressOptions, hostedProfileManageOptions,
     * hostedProfilePaymentOptions, hostedProfileSaveButtonText.
     *
     * @return \net\authorize\api\contract\v1\SettingType[]
     */
    public function getHostedProfileSettings()
    {
        return $this->hostedProfileSettings;
    }

    /**
     * Sets a new hostedProfileSettings
     *
     * Allowed values for settingName are: hostedProfileReturnUrl,
     * hostedProfileReturnUrlText, hostedProfilePageBorderVisible,
     * hostedProfileIFrameCommunicatorUrl, hostedProfileHeadingBgColor,
     * hostedProfileBillingAddressRequired, hostedProfileCardCodeRequired,
     * hostedProfileBillingAddressOptions, hostedProfileManageOptions,
     * hostedProfilePaymentOptions, hostedProfileSaveButtonText.
     *
     * @param \net\authorize\api\contract\v1\SettingType[] $hostedProfileSettings
     * @return self
     */
    public function setHostedProfileSettings(array $hostedProfileSettings)
    {
        $this->hostedProfileSettings = $hostedProfileSettings;
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

