<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing KeyValueType
 *
 * 
 * XSD Type: KeyValue
 */
class KeyValueType implements \JsonSerializable
{

    /**
     * @property string $encoding
     */
    private $encoding = null;

    /**
     * @property string $encryptionAlgorithm
     */
    private $encryptionAlgorithm = null;

    /**
     * @property \net\authorize\api\contract\v1\KeyManagementSchemeType $scheme
     */
    private $scheme = null;

    /**
     * Gets as encoding
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Sets a new encoding
     *
     * @param string $encoding
     * @return self
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }

    /**
     * Gets as encryptionAlgorithm
     *
     * @return string
     */
    public function getEncryptionAlgorithm()
    {
        return $this->encryptionAlgorithm;
    }

    /**
     * Sets a new encryptionAlgorithm
     *
     * @param string $encryptionAlgorithm
     * @return self
     */
    public function setEncryptionAlgorithm($encryptionAlgorithm)
    {
        $this->encryptionAlgorithm = $encryptionAlgorithm;
        return $this;
    }

    /**
     * Gets as scheme
     *
     * @return \net\authorize\api\contract\v1\KeyManagementSchemeType
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Sets a new scheme
     *
     * @param \net\authorize\api\contract\v1\KeyManagementSchemeType $scheme
     * @return self
     */
    public function setScheme(\net\authorize\api\contract\v1\KeyManagementSchemeType $scheme)
    {
        $this->scheme = $scheme;
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

