<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing AuUpdateType
 *
 * 
 * XSD Type: auUpdateType
 */
class AuUpdateType extends AuDetailsType implements \JsonSerializable
{

    /**
     * @property \net\authorize\api\contract\v1\CreditCardMaskedType $newCreditCard
     */
    private $newCreditCard = null;

    /**
     * @property \net\authorize\api\contract\v1\CreditCardMaskedType $oldCreditCard
     */
    private $oldCreditCard = null;

    /**
     * Gets as newCreditCard
     *
     * @return \net\authorize\api\contract\v1\CreditCardMaskedType
     */
    public function getNewCreditCard()
    {
        return $this->newCreditCard;
    }

    /**
     * Sets a new newCreditCard
     *
     * @param \net\authorize\api\contract\v1\CreditCardMaskedType $newCreditCard
     * @return self
     */
    public function setNewCreditCard(\net\authorize\api\contract\v1\CreditCardMaskedType $newCreditCard)
    {
        $this->newCreditCard = $newCreditCard;
        return $this;
    }

    /**
     * Gets as oldCreditCard
     *
     * @return \net\authorize\api\contract\v1\CreditCardMaskedType
     */
    public function getOldCreditCard()
    {
        return $this->oldCreditCard;
    }

    /**
     * Sets a new oldCreditCard
     *
     * @param \net\authorize\api\contract\v1\CreditCardMaskedType $oldCreditCard
     * @return self
     */
    public function setOldCreditCard(\net\authorize\api\contract\v1\CreditCardMaskedType $oldCreditCard)
    {
        $this->oldCreditCard = $oldCreditCard;
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

