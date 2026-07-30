<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing LineItemType
 *
 * 
 * XSD Type: lineItemType
 */
class LineItemType implements \JsonSerializable
{

    /**
     * @property string $itemId
     */
    private $itemId = null;

    /**
     * @property string $name
     */
    private $name = null;

    /**
     * @property string $description
     */
    private $description = null;

    /**
     * @property float $quantity
     */
    private $quantity = null;

    /**
     * @property float $unitPrice
     */
    private $unitPrice = null;

    /**
     * @property boolean $taxable
     */
    private $taxable = null;

    /**
     * @property string $unitOfMeasure
     */
    private $unitOfMeasure = null;

    /**
     * @property string $typeOfSupply
     */
    private $typeOfSupply = null;

    /**
     * @property float $taxRate
     */
    private $taxRate = null;

    /**
     * @property float $taxAmount
     */
    private $taxAmount = null;

    /**
     * @property float $nationalTax
     */
    private $nationalTax = null;

    /**
     * @property float $localTax
     */
    private $localTax = null;

    /**
     * @property float $vatRate
     */
    private $vatRate = null;

    /**
     * @property string $alternateTaxId
     */
    private $alternateTaxId = null;

    /**
     * @property string $alternateTaxType
     */
    private $alternateTaxType = null;

    /**
     * @property string $alternateTaxTypeApplied
     */
    private $alternateTaxTypeApplied = null;

    /**
     * @property float $alternateTaxRate
     */
    private $alternateTaxRate = null;

    /**
     * @property float $alternateTaxAmount
     */
    private $alternateTaxAmount = null;

    /**
     * @property float $totalAmount
     */
    private $totalAmount = null;

    /**
     * @property string $commodityCode
     */
    private $commodityCode = null;

    /**
     * @property string $productCode
     */
    private $productCode = null;

    /**
     * @property string $productSKU
     */
    private $productSKU = null;

    /**
     * @property float $discountRate
     */
    private $discountRate = null;

    /**
     * @property float $discountAmount
     */
    private $discountAmount = null;

    /**
     * @property boolean $taxIncludedInTotal
     */
    private $taxIncludedInTotal = null;

    /**
     * @property boolean $taxIsAfterDiscount
     */
    private $taxIsAfterDiscount = null;

    /**
     * Gets as itemId
     *
     * @return string
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Sets a new itemId
     *
     * @param string $itemId
     * @return self
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
        return $this;
    }

    /**
     * Gets as name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets a new name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gets as description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets a new description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Gets as quantity
     *
     * @return float
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Sets a new quantity
     *
     * @param float $quantity
     * @return self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * Gets as unitPrice
     *
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Sets a new unitPrice
     *
     * @param float $unitPrice
     * @return self
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    /**
     * Gets as taxable
     *
     * @return boolean
     */
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * Sets a new taxable
     *
     * @param boolean $taxable
     * @return self
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
        return $this;
    }

    /**
     * Gets as unitOfMeasure
     *
     * @return string
     */
    public function getUnitOfMeasure()
    {
        return $this->unitOfMeasure;
    }

    /**
     * Sets a new unitOfMeasure
     *
     * @param string $unitOfMeasure
     * @return self
     */
    public function setUnitOfMeasure($unitOfMeasure)
    {
        $this->unitOfMeasure = $unitOfMeasure;
        return $this;
    }

    /**
     * Gets as typeOfSupply
     *
     * @return string
     */
    public function getTypeOfSupply()
    {
        return $this->typeOfSupply;
    }

    /**
     * Sets a new typeOfSupply
     *
     * @param string $typeOfSupply
     * @return self
     */
    public function setTypeOfSupply($typeOfSupply)
    {
        $this->typeOfSupply = $typeOfSupply;
        return $this;
    }

    /**
     * Gets as taxRate
     *
     * @return float
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * Sets a new taxRate
     *
     * @param float $taxRate
     * @return self
     */
    public function setTaxRate($taxRate)
    {
        $this->taxRate = $taxRate;
        return $this;
    }

    /**
     * Gets as taxAmount
     *
     * @return float
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * Sets a new taxAmount
     *
     * @param float $taxAmount
     * @return self
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;
        return $this;
    }

    /**
     * Gets as nationalTax
     *
     * @return float
     */
    public function getNationalTax()
    {
        return $this->nationalTax;
    }

    /**
     * Sets a new nationalTax
     *
     * @param float $nationalTax
     * @return self
     */
    public function setNationalTax($nationalTax)
    {
        $this->nationalTax = $nationalTax;
        return $this;
    }

    /**
     * Gets as localTax
     *
     * @return float
     */
    public function getLocalTax()
    {
        return $this->localTax;
    }

    /**
     * Sets a new localTax
     *
     * @param float $localTax
     * @return self
     */
    public function setLocalTax($localTax)
    {
        $this->localTax = $localTax;
        return $this;
    }

    /**
     * Gets as vatRate
     *
     * @return float
     */
    public function getVatRate()
    {
        return $this->vatRate;
    }

    /**
     * Sets a new vatRate
     *
     * @param float $vatRate
     * @return self
     */
    public function setVatRate($vatRate)
    {
        $this->vatRate = $vatRate;
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
     * Gets as alternateTaxType
     *
     * @return string
     */
    public function getAlternateTaxType()
    {
        return $this->alternateTaxType;
    }

    /**
     * Sets a new alternateTaxType
     *
     * @param string $alternateTaxType
     * @return self
     */
    public function setAlternateTaxType($alternateTaxType)
    {
        $this->alternateTaxType = $alternateTaxType;
        return $this;
    }

    /**
     * Gets as alternateTaxTypeApplied
     *
     * @return string
     */
    public function getAlternateTaxTypeApplied()
    {
        return $this->alternateTaxTypeApplied;
    }

    /**
     * Sets a new alternateTaxTypeApplied
     *
     * @param string $alternateTaxTypeApplied
     * @return self
     */
    public function setAlternateTaxTypeApplied($alternateTaxTypeApplied)
    {
        $this->alternateTaxTypeApplied = $alternateTaxTypeApplied;
        return $this;
    }

    /**
     * Gets as alternateTaxRate
     *
     * @return float
     */
    public function getAlternateTaxRate()
    {
        return $this->alternateTaxRate;
    }

    /**
     * Sets a new alternateTaxRate
     *
     * @param float $alternateTaxRate
     * @return self
     */
    public function setAlternateTaxRate($alternateTaxRate)
    {
        $this->alternateTaxRate = $alternateTaxRate;
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
     * Gets as totalAmount
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * Sets a new totalAmount
     *
     * @param float $totalAmount
     * @return self
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
        return $this;
    }

    /**
     * Gets as commodityCode
     *
     * @return string
     */
    public function getCommodityCode()
    {
        return $this->commodityCode;
    }

    /**
     * Sets a new commodityCode
     *
     * @param string $commodityCode
     * @return self
     */
    public function setCommodityCode($commodityCode)
    {
        $this->commodityCode = $commodityCode;
        return $this;
    }

    /**
     * Gets as productCode
     *
     * @return string
     */
    public function getProductCode()
    {
        return $this->productCode;
    }

    /**
     * Sets a new productCode
     *
     * @param string $productCode
     * @return self
     */
    public function setProductCode($productCode)
    {
        $this->productCode = $productCode;
        return $this;
    }

    /**
     * Gets as productSKU
     *
     * @return string
     */
    public function getProductSKU()
    {
        return $this->productSKU;
    }

    /**
     * Sets a new productSKU
     *
     * @param string $productSKU
     * @return self
     */
    public function setProductSKU($productSKU)
    {
        $this->productSKU = $productSKU;
        return $this;
    }

    /**
     * Gets as discountRate
     *
     * @return float
     */
    public function getDiscountRate()
    {
        return $this->discountRate;
    }

    /**
     * Sets a new discountRate
     *
     * @param float $discountRate
     * @return self
     */
    public function setDiscountRate($discountRate)
    {
        $this->discountRate = $discountRate;
        return $this;
    }

    /**
     * Gets as discountAmount
     *
     * @return float
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * Sets a new discountAmount
     *
     * @param float $discountAmount
     * @return self
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
        return $this;
    }

    /**
     * Gets as taxIncludedInTotal
     *
     * @return boolean
     */
    public function getTaxIncludedInTotal()
    {
        return $this->taxIncludedInTotal;
    }

    /**
     * Sets a new taxIncludedInTotal
     *
     * @param boolean $taxIncludedInTotal
     * @return self
     */
    public function setTaxIncludedInTotal($taxIncludedInTotal)
    {
        $this->taxIncludedInTotal = $taxIncludedInTotal;
        return $this;
    }

    /**
     * Gets as taxIsAfterDiscount
     *
     * @return boolean
     */
    public function getTaxIsAfterDiscount()
    {
        return $this->taxIsAfterDiscount;
    }

    /**
     * Sets a new taxIsAfterDiscount
     *
     * @param boolean $taxIsAfterDiscount
     * @return self
     */
    public function setTaxIsAfterDiscount($taxIsAfterDiscount)
    {
        $this->taxIsAfterDiscount = $taxIsAfterDiscount;
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

