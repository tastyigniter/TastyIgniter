<?php

namespace net\authorize\api\contract\v1\TransactionResponseType;

/**
 * Class representing EmvResponseAType
 */
class EmvResponseAType implements \JsonSerializable
{

    /**
     * @property string $tlvData
     */
    private $tlvData = null;

    /**
     * @property \net\authorize\api\contract\v1\EmvTagType[] $tags
     */
    private $tags = null;

    /**
     * Gets as tlvData
     *
     * @return string
     */
    public function getTlvData()
    {
        return $this->tlvData;
    }

    /**
     * Sets a new tlvData
     *
     * @param string $tlvData
     * @return self
     */
    public function setTlvData($tlvData)
    {
        $this->tlvData = $tlvData;
        return $this;
    }

    /**
     * Adds as tag
     *
     * @return self
     * @param \net\authorize\api\contract\v1\EmvTagType $tag
     */
    public function addToTags(\net\authorize\api\contract\v1\EmvTagType $tag)
    {
        $this->tags[] = $tag;
        return $this;
    }

    /**
     * isset tags
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetTags($index)
    {
        return isset($this->tags[$index]);
    }

    /**
     * unset tags
     *
     * @param scalar $index
     * @return void
     */
    public function unsetTags($index)
    {
        unset($this->tags[$index]);
    }

    /**
     * Gets as tags
     *
     * @return \net\authorize\api\contract\v1\EmvTagType[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Sets a new tags
     *
     * @param \net\authorize\api\contract\v1\EmvTagType[] $tags
     * @return self
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
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

