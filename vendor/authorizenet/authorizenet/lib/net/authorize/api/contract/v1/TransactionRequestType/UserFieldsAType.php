<?php

namespace net\authorize\api\contract\v1\TransactionRequestType;

/**
 * Class representing UserFieldsAType
 */
class UserFieldsAType implements \JsonSerializable
{

    /**
     * @property \net\authorize\api\contract\v1\UserFieldType[] $userField
     */
    private $userField = null;

    /**
     * Adds as userField
     *
     * @return self
     * @param \net\authorize\api\contract\v1\UserFieldType $userField
     */
    public function addToUserField(\net\authorize\api\contract\v1\UserFieldType $userField)
    {
        $this->userField[] = $userField;
        return $this;
    }

    /**
     * isset userField
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetUserField($index)
    {
        return isset($this->userField[$index]);
    }

    /**
     * unset userField
     *
     * @param scalar $index
     * @return void
     */
    public function unsetUserField($index)
    {
        unset($this->userField[$index]);
    }

    /**
     * Gets as userField
     *
     * @return \net\authorize\api\contract\v1\UserFieldType[]
     */
    public function getUserField()
    {
        return $this->userField;
    }

    /**
     * Sets a new userField
     *
     * @param \net\authorize\api\contract\v1\UserFieldType[] $userField
     * @return self
     */
    public function setUserField(array $userField)
    {
        $this->userField = $userField;
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

