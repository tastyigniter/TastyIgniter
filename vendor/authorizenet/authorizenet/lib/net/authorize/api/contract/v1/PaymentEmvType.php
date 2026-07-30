<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing PaymentEmvType
 *
 * 
 * XSD Type: paymentEmvType
 */
class PaymentEmvType implements \JsonSerializable
{

    /**
     * @property mixed $emvData
     */
    private $emvData = null;

    /**
     * @property mixed $emvDescriptor
     */
    private $emvDescriptor = null;

    /**
     * @property mixed $emvVersion
     */
    private $emvVersion = null;

    /**
     * Gets as emvData
     *
     * @return mixed
     */
    public function getEmvData()
    {
        return $this->emvData;
    }

    /**
     * Sets a new emvData
     *
     * @param mixed $emvData
     * @return self
     */
    public function setEmvData($emvData)
    {
        $this->emvData = $emvData;
        return $this;
    }

    /**
     * Gets as emvDescriptor
     *
     * @return mixed
     */
    public function getEmvDescriptor()
    {
        return $this->emvDescriptor;
    }

    /**
     * Sets a new emvDescriptor
     *
     * @param mixed $emvDescriptor
     * @return self
     */
    public function setEmvDescriptor($emvDescriptor)
    {
        $this->emvDescriptor = $emvDescriptor;
        return $this;
    }

    /**
     * Gets as emvVersion
     *
     * @return mixed
     */
    public function getEmvVersion()
    {
        return $this->emvVersion;
    }

    /**
     * Sets a new emvVersion
     *
     * @param mixed $emvVersion
     * @return self
     */
    public function setEmvVersion($emvVersion)
    {
        $this->emvVersion = $emvVersion;
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

