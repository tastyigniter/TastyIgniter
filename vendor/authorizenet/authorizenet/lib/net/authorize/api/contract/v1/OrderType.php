<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing OrderType
 *
 * 
 * XSD Type: orderType
 */
class OrderType implements \JsonSerializable
{

    /**
     * @property string $invoiceNumber
     */
    private $invoiceNumber = null;

    /**
     * @property string $description
     */
    private $description = null;

    /**
     * @property float $discountAmount
     */
    private $discountAmount = null;

    /**
     * @property boolean $taxIsAfterDiscount
     */
    private $taxIsAfterDiscount = null;

    /**
     * @property string $totalTaxTypeCode
     */
    private $totalTaxTypeCode = null;

    /**
     * @property string $purchaserVATRegistrationNumber
     */
    private $purchaserVATRegistrationNumber = null;

    /**
     * @property string $merchantVATRegistrationNumber
     */
    private $merchantVATRegistrationNumber = null;

    /**
     * @property string $vatInvoiceReferenceNumber
     */
    private $vatInvoiceReferenceNumber = null;

    /**
     * @property string $purchaserCode
     */
    private $purchaserCode = null;

    /**
     * @property string $summaryCommodityCode
     */
    private $summaryCommodityCode = null;

    /**
     * @property \DateTime $purchaseOrderDateUTC
     */
    private $purchaseOrderDateUTC = null;

    /**
     * @property string $supplierOrderReference
     */
    private $supplierOrderReference = null;

    /**
     * @property string $authorizedContactName
     */
    private $authorizedContactName = null;

    /**
     * @property string $cardAcceptorRefNumber
     */
    private $cardAcceptorRefNumber = null;

    /**
     * @property string $amexDataTAA1
     */
    private $amexDataTAA1 = null;

    /**
     * @property string $amexDataTAA2
     */
    private $amexDataTAA2 = null;

    /**
     * @property string $amexDataTAA3
     */
    private $amexDataTAA3 = null;

    /**
     * @property string $amexDataTAA4
     */
    private $amexDataTAA4 = null;

    /**
     * Gets as invoiceNumber
     *
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }

    /**
     * Sets a new invoiceNumber
     *
     * @param string $invoiceNumber
     * @return self
     */
    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;
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

    /**
     * Gets as totalTaxTypeCode
     *
     * @return string
     */
    public function getTotalTaxTypeCode()
    {
        return $this->totalTaxTypeCode;
    }

    /**
     * Sets a new totalTaxTypeCode
     *
     * @param string $totalTaxTypeCode
     * @return self
     */
    public function setTotalTaxTypeCode($totalTaxTypeCode)
    {
        $this->totalTaxTypeCode = $totalTaxTypeCode;
        return $this;
    }

    /**
     * Gets as purchaserVATRegistrationNumber
     *
     * @return string
     */
    public function getPurchaserVATRegistrationNumber()
    {
        return $this->purchaserVATRegistrationNumber;
    }

    /**
     * Sets a new purchaserVATRegistrationNumber
     *
     * @param string $purchaserVATRegistrationNumber
     * @return self
     */
    public function setPurchaserVATRegistrationNumber($purchaserVATRegistrationNumber)
    {
        $this->purchaserVATRegistrationNumber = $purchaserVATRegistrationNumber;
        return $this;
    }

    /**
     * Gets as merchantVATRegistrationNumber
     *
     * @return string
     */
    public function getMerchantVATRegistrationNumber()
    {
        return $this->merchantVATRegistrationNumber;
    }

    /**
     * Sets a new merchantVATRegistrationNumber
     *
     * @param string $merchantVATRegistrationNumber
     * @return self
     */
    public function setMerchantVATRegistrationNumber($merchantVATRegistrationNumber)
    {
        $this->merchantVATRegistrationNumber = $merchantVATRegistrationNumber;
        return $this;
    }

    /**
     * Gets as vatInvoiceReferenceNumber
     *
     * @return string
     */
    public function getVatInvoiceReferenceNumber()
    {
        return $this->vatInvoiceReferenceNumber;
    }

    /**
     * Sets a new vatInvoiceReferenceNumber
     *
     * @param string $vatInvoiceReferenceNumber
     * @return self
     */
    public function setVatInvoiceReferenceNumber($vatInvoiceReferenceNumber)
    {
        $this->vatInvoiceReferenceNumber = $vatInvoiceReferenceNumber;
        return $this;
    }

    /**
     * Gets as purchaserCode
     *
     * @return string
     */
    public function getPurchaserCode()
    {
        return $this->purchaserCode;
    }

    /**
     * Sets a new purchaserCode
     *
     * @param string $purchaserCode
     * @return self
     */
    public function setPurchaserCode($purchaserCode)
    {
        $this->purchaserCode = $purchaserCode;
        return $this;
    }

    /**
     * Gets as summaryCommodityCode
     *
     * @return string
     */
    public function getSummaryCommodityCode()
    {
        return $this->summaryCommodityCode;
    }

    /**
     * Sets a new summaryCommodityCode
     *
     * @param string $summaryCommodityCode
     * @return self
     */
    public function setSummaryCommodityCode($summaryCommodityCode)
    {
        $this->summaryCommodityCode = $summaryCommodityCode;
        return $this;
    }

    /**
     * Gets as purchaseOrderDateUTC
     *
     * @return \DateTime
     */
    public function getPurchaseOrderDateUTC()
    {
        return $this->purchaseOrderDateUTC;
    }

    /**
     * Sets a new purchaseOrderDateUTC
     *
     * @param \DateTime $purchaseOrderDateUTC
     * @return self
     */
    public function setPurchaseOrderDateUTC(\DateTime $purchaseOrderDateUTC)
    {
        $this->purchaseOrderDateUTC = $purchaseOrderDateUTC;
        return $this;
    }

    /**
     * Gets as supplierOrderReference
     *
     * @return string
     */
    public function getSupplierOrderReference()
    {
        return $this->supplierOrderReference;
    }

    /**
     * Sets a new supplierOrderReference
     *
     * @param string $supplierOrderReference
     * @return self
     */
    public function setSupplierOrderReference($supplierOrderReference)
    {
        $this->supplierOrderReference = $supplierOrderReference;
        return $this;
    }

    /**
     * Gets as authorizedContactName
     *
     * @return string
     */
    public function getAuthorizedContactName()
    {
        return $this->authorizedContactName;
    }

    /**
     * Sets a new authorizedContactName
     *
     * @param string $authorizedContactName
     * @return self
     */
    public function setAuthorizedContactName($authorizedContactName)
    {
        $this->authorizedContactName = $authorizedContactName;
        return $this;
    }

    /**
     * Gets as cardAcceptorRefNumber
     *
     * @return string
     */
    public function getCardAcceptorRefNumber()
    {
        return $this->cardAcceptorRefNumber;
    }

    /**
     * Sets a new cardAcceptorRefNumber
     *
     * @param string $cardAcceptorRefNumber
     * @return self
     */
    public function setCardAcceptorRefNumber($cardAcceptorRefNumber)
    {
        $this->cardAcceptorRefNumber = $cardAcceptorRefNumber;
        return $this;
    }

    /**
     * Gets as amexDataTAA1
     *
     * @return string
     */
    public function getAmexDataTAA1()
    {
        return $this->amexDataTAA1;
    }

    /**
     * Sets a new amexDataTAA1
     *
     * @param string $amexDataTAA1
     * @return self
     */
    public function setAmexDataTAA1($amexDataTAA1)
    {
        $this->amexDataTAA1 = $amexDataTAA1;
        return $this;
    }

    /**
     * Gets as amexDataTAA2
     *
     * @return string
     */
    public function getAmexDataTAA2()
    {
        return $this->amexDataTAA2;
    }

    /**
     * Sets a new amexDataTAA2
     *
     * @param string $amexDataTAA2
     * @return self
     */
    public function setAmexDataTAA2($amexDataTAA2)
    {
        $this->amexDataTAA2 = $amexDataTAA2;
        return $this;
    }

    /**
     * Gets as amexDataTAA3
     *
     * @return string
     */
    public function getAmexDataTAA3()
    {
        return $this->amexDataTAA3;
    }

    /**
     * Sets a new amexDataTAA3
     *
     * @param string $amexDataTAA3
     * @return self
     */
    public function setAmexDataTAA3($amexDataTAA3)
    {
        $this->amexDataTAA3 = $amexDataTAA3;
        return $this;
    }

    /**
     * Gets as amexDataTAA4
     *
     * @return string
     */
    public function getAmexDataTAA4()
    {
        return $this->amexDataTAA4;
    }

    /**
     * Sets a new amexDataTAA4
     *
     * @param string $amexDataTAA4
     * @return self
     */
    public function setAmexDataTAA4($amexDataTAA4)
    {
        $this->amexDataTAA4 = $amexDataTAA4;
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

