<?php

namespace net\authorize\api\contract\v1\TransactionDetailsType;

/**
 * Class representing EmvDetailsAType
 */
class EmvDetailsAType implements \JsonSerializable
{

    /**
     * @property
     * \net\authorize\api\contract\v1\TransactionDetailsType\EmvDetailsAType\TagAType[]
     * $tag
     */
    private $tag = null;

    /**
     * Adds as tag
     *
     * @return self
     * @param
     * \net\authorize\api\contract\v1\TransactionDetailsType\EmvDetailsAType\TagAType
     * $tag
     */
    public function addToTag(\net\authorize\api\contract\v1\TransactionDetailsType\EmvDetailsAType\TagAType $tag)
    {
        $this->tag[] = $tag;
        return $this;
    }

    /**
     * isset tag
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetTag($index)
    {
        return isset($this->tag[$index]);
    }

    /**
     * unset tag
     *
     * @param scalar $index
     * @return void
     */
    public function unsetTag($index)
    {
        unset($this->tag[$index]);
    }

    /**
     * Gets as tag
     *
     * @return
     * \net\authorize\api\contract\v1\TransactionDetailsType\EmvDetailsAType\TagAType[]
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Sets a new tag
     *
     * @param
     * \net\authorize\api\contract\v1\TransactionDetailsType\EmvDetailsAType\TagAType[]
     * $tag
     * @return self
     */
    public function setTag(array $tag)
    {
        $this->tag = $tag;
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

