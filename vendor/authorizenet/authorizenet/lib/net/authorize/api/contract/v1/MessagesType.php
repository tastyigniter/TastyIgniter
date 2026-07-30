<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing MessagesType
 *
 * 
 * XSD Type: messagesType
 */
class MessagesType implements \JsonSerializable
{

    /**
     * @property string $resultCode
     */
    private $resultCode = null;

    /**
     * @property \net\authorize\api\contract\v1\MessagesType\MessageAType[] $message
     */
    private $message = null;

    /**
     * Gets as resultCode
     *
     * @return string
     */
    public function getResultCode()
    {
        return $this->resultCode;
    }

    /**
     * Sets a new resultCode
     *
     * @param string $resultCode
     * @return self
     */
    public function setResultCode($resultCode)
    {
        $this->resultCode = $resultCode;
        return $this;
    }

    /**
     * Adds as message
     *
     * @return self
     * @param \net\authorize\api\contract\v1\MessagesType\MessageAType $message
     */
    public function addToMessage(\net\authorize\api\contract\v1\MessagesType\MessageAType $message)
    {
        $this->message[] = $message;
        return $this;
    }

    /**
     * isset message
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetMessage($index)
    {
        return isset($this->message[$index]);
    }

    /**
     * unset message
     *
     * @param scalar $index
     * @return void
     */
    public function unsetMessage($index)
    {
        unset($this->message[$index]);
    }

    /**
     * Gets as message
     *
     * @return \net\authorize\api\contract\v1\MessagesType\MessageAType[]
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets a new message
     *
     * @param \net\authorize\api\contract\v1\MessagesType\MessageAType[] $message
     * @return self
     */
    public function setMessage(array $message)
    {
        $this->message = $message;
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

