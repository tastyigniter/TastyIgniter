<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing GetTransactionListResponse
 */
class GetTransactionListResponse extends ANetApiResponseType
{

    /**
     * @property \net\authorize\api\contract\v1\TransactionSummaryType[] $transactions
     */
    private $transactions = null;

    /**
     * @property integer $totalNumInResultSet
     */
    private $totalNumInResultSet = null;

    /**
     * Adds as transaction
     *
     * @return self
     * @param \net\authorize\api\contract\v1\TransactionSummaryType $transaction
     */
    public function addToTransactions(\net\authorize\api\contract\v1\TransactionSummaryType $transaction)
    {
        $this->transactions[] = $transaction;
        return $this;
    }

    /**
     * isset transactions
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetTransactions($index)
    {
        return isset($this->transactions[$index]);
    }

    /**
     * unset transactions
     *
     * @param scalar $index
     * @return void
     */
    public function unsetTransactions($index)
    {
        unset($this->transactions[$index]);
    }

    /**
     * Gets as transactions
     *
     * @return \net\authorize\api\contract\v1\TransactionSummaryType[]
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * Sets a new transactions
     *
     * @param \net\authorize\api\contract\v1\TransactionSummaryType[] $transactions
     * @return self
     */
    public function setTransactions(array $transactions)
    {
        $this->transactions = $transactions;
        return $this;
    }

    /**
     * Gets as totalNumInResultSet
     *
     * @return integer
     */
    public function getTotalNumInResultSet()
    {
        return $this->totalNumInResultSet;
    }

    /**
     * Sets a new totalNumInResultSet
     *
     * @param integer $totalNumInResultSet
     * @return self
     */
    public function setTotalNumInResultSet($totalNumInResultSet)
    {
        $this->totalNumInResultSet = $totalNumInResultSet;
        return $this;
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

