<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing FraudInformationType
 *
 * 
 * XSD Type: fraudInformationType
 */
class FraudInformationType implements \JsonSerializable
{

    /**
     * @property string[] $fraudFilterList
     */
    private $fraudFilterList = null;

    /**
     * @property string $fraudAction
     */
    private $fraudAction = null;

    /**
     * Adds as fraudFilter
     *
     * @return self
     * @param string $fraudFilter
     */
    public function addToFraudFilterList($fraudFilter)
    {
        $this->fraudFilterList[] = $fraudFilter;
        return $this;
    }

    /**
     * isset fraudFilterList
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetFraudFilterList($index)
    {
        return isset($this->fraudFilterList[$index]);
    }

    /**
     * unset fraudFilterList
     *
     * @param scalar $index
     * @return void
     */
    public function unsetFraudFilterList($index)
    {
        unset($this->fraudFilterList[$index]);
    }

    /**
     * Gets as fraudFilterList
     *
     * @return string[]
     */
    public function getFraudFilterList()
    {
        return $this->fraudFilterList;
    }

    /**
     * Sets a new fraudFilterList
     *
     * @param string[] $fraudFilterList
     * @return self
     */
    public function setFraudFilterList(array $fraudFilterList)
    {
        $this->fraudFilterList = $fraudFilterList;
        return $this;
    }

    /**
     * Gets as fraudAction
     *
     * @return string
     */
    public function getFraudAction()
    {
        return $this->fraudAction;
    }

    /**
     * Sets a new fraudAction
     *
     * @param string $fraudAction
     * @return self
     */
    public function setFraudAction($fraudAction)
    {
        $this->fraudAction = $fraudAction;
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

