<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing CardArtType
 *
 * 
 * XSD Type: cardArt
 */
class CardArtType implements \JsonSerializable
{

    /**
     * @property string $cardBrand
     */
    private $cardBrand = null;

    /**
     * @property string $cardImageHeight
     */
    private $cardImageHeight = null;

    /**
     * @property string $cardImageUrl
     */
    private $cardImageUrl = null;

    /**
     * @property string $cardImageWidth
     */
    private $cardImageWidth = null;

    /**
     * @property string $cardType
     */
    private $cardType = null;

    /**
     * Gets as cardBrand
     *
     * @return string
     */
    public function getCardBrand()
    {
        return $this->cardBrand;
    }

    /**
     * Sets a new cardBrand
     *
     * @param string $cardBrand
     * @return self
     */
    public function setCardBrand($cardBrand)
    {
        $this->cardBrand = $cardBrand;
        return $this;
    }

    /**
     * Gets as cardImageHeight
     *
     * @return string
     */
    public function getCardImageHeight()
    {
        return $this->cardImageHeight;
    }

    /**
     * Sets a new cardImageHeight
     *
     * @param string $cardImageHeight
     * @return self
     */
    public function setCardImageHeight($cardImageHeight)
    {
        $this->cardImageHeight = $cardImageHeight;
        return $this;
    }

    /**
     * Gets as cardImageUrl
     *
     * @return string
     */
    public function getCardImageUrl()
    {
        return $this->cardImageUrl;
    }

    /**
     * Sets a new cardImageUrl
     *
     * @param string $cardImageUrl
     * @return self
     */
    public function setCardImageUrl($cardImageUrl)
    {
        $this->cardImageUrl = $cardImageUrl;
        return $this;
    }

    /**
     * Gets as cardImageWidth
     *
     * @return string
     */
    public function getCardImageWidth()
    {
        return $this->cardImageWidth;
    }

    /**
     * Sets a new cardImageWidth
     *
     * @param string $cardImageWidth
     * @return self
     */
    public function setCardImageWidth($cardImageWidth)
    {
        $this->cardImageWidth = $cardImageWidth;
        return $this;
    }

    /**
     * Gets as cardType
     *
     * @return string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * Sets a new cardType
     *
     * @param string $cardType
     * @return self
     */
    public function setCardType($cardType)
    {
        $this->cardType = $cardType;
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

