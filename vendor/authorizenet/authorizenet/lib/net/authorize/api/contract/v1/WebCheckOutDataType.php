<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing WebCheckOutDataType
 *
 * 
 * XSD Type: webCheckOutDataType
 */
class WebCheckOutDataType implements \JsonSerializable
{

    /**
     * @property string $type
     */
    private $type = null;

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \net\authorize\api\contract\v1\WebCheckOutDataTypeTokenType $token
     */
    private $token = null;

    /**
     * @property \net\authorize\api\contract\v1\BankAccountType $bankToken
     */
    private $bankToken = null;

    /**
     * Gets as type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets a new type
     *
     * @param string $type
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Gets as id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets a new id
     *
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Gets as token
     *
     * @return \net\authorize\api\contract\v1\WebCheckOutDataTypeTokenType
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Sets a new token
     *
     * @param \net\authorize\api\contract\v1\WebCheckOutDataTypeTokenType $token
     * @return self
     */
    public function setToken(\net\authorize\api\contract\v1\WebCheckOutDataTypeTokenType $token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Gets as bankToken
     *
     * @return \net\authorize\api\contract\v1\BankAccountType
     */
    public function getBankToken()
    {
        return $this->bankToken;
    }

    /**
     * Sets a new bankToken
     *
     * @param \net\authorize\api\contract\v1\BankAccountType $bankToken
     * @return self
     */
    public function setBankToken(\net\authorize\api\contract\v1\BankAccountType $bankToken)
    {
        $this->bankToken = $bankToken;
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

