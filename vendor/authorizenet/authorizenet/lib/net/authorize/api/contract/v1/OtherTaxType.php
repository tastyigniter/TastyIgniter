<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing OtherTaxType
 *
 * 
 * XSD Type: otherTaxType
 */
class OtherTaxType implements \JsonSerializable
{

    /**
     * @property float $nationalTaxAmount
     */
    private $nationalTaxAmount = null;

    /**
     * @property float $localTaxAmount
     */
    private $localTaxAmount = null;

    /**
     * @property float $alternateTaxAmount
     */
    private $alternateTaxAmount = null;

    /**
     * @property string $alternateTaxId
     */
    private $alternateTaxId = null;

    /**
     * @property float $vatTaxRate
     */
    private $vatTaxRate = null;

    /**
     * @property float $vatTaxAmount
     */
    private $vatTaxAmount = null;

    /**
     * Gets as nationalTaxAmount
     *
     * @return float
     */
    public function getNationalTaxAmount()
    {
        return $this->nationalTaxAmount;
    }

    /**
     * Sets a new nationalTaxAmount
     *
     * @param float $nationalTaxAmount
     * @return self
     */
    public function setNationalTaxAmount($nationalTaxAmount)
    {
        $this->nationalTaxAmount = $nationalTaxAmount;
        return $this;
    }

    /**
     * Gets as localTaxAmount
     *
     * @return float
     */
    public function getLocalTaxAmount()
    {
        return $this->localTaxAmount;
    }

    /**
     * Sets a new localTaxAmount
     *
     * @param float $localTaxAmount
     * @return self
     */
    public function setLocalTaxAmount($localTaxAmount)
    {
        $this->localTaxAmount = $localTaxAmount;
        return $this;
    }

    /**
     * Gets as alternateTaxAmount
     *
     * @return float
     */
    public function getAlternateTaxAmount()
    {
        return $this->alternateTaxAmount;
    }

    /**
     * Sets a new alternateTaxAmount
     *
     * @param float $alternateTaxAmount
     * @return self
     */
    public function setAlternateTaxAmount($alternateTaxAmount)
    {
        $this->alternateTaxAmount = $alternateTaxAmount;
        return $this;
    }

    /**
     * Gets as alternateTaxId
     *
     * @return string
     */
    public function getAlternateTaxId()
    {
        return $this->alternateTaxId;
    }

    /**
     * Sets a new alternateTaxId
     *
     * @param string $alternateTaxId
     * @return self
     */
    public function setAlternateTaxId($alternateTaxId)
    {
        $this->alternateTaxId = $alternateTaxId;
        return $this;
    }

    /**
     * Gets as vatTaxRate
     *
     * @return float
     */
    public function getVatTaxRate()
    {
        return $this->vatTaxRate;
    }

    /**
     * Sets a new vatTaxRate
     *
     * @param float $vatTaxRate
     * @return self
     */
    public function setVatTaxRate($vatTaxRate)
    {
        $this->vatTaxRate = $vatTaxRate;
        return $this;
    }

    /**
     * Gets as vatTaxAmount
     *
     * @return float
     */
    public function getVatTaxAmount()
    {
        return $this->vatTaxAmount;
    }

    /**
     * Sets a new vatTaxAmount
     *
     * @param float $vatTaxAmount
     * @return self
     */
    public function setVatTaxAmount($vatTaxAmount)
    {
        $this->vatTaxAmount = $vatTaxAmount;
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

