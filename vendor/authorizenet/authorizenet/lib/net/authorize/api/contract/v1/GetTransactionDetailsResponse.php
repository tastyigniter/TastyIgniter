<?php

namespace net\authorize\api\contract\v1;

/**
 * Class representing GetTransactionDetailsResponse
 */
class GetTransactionDetailsResponse extends ANetApiResponseType
{

    /**
     * @property \net\authorize\api\contract\v1\TransactionDetailsType $transaction
     */
    private $transaction = null;

    /**
     * @property string $clientId
     */
    private $clientId = null;

    /**
     * @property string $transrefId
     */
    private $transrefId = null;

    /**
     * Gets as transaction
     *
     * @return \net\authorize\api\contract\v1\TransactionDetailsType
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Sets a new transaction
     *
     * @param \net\authorize\api\contract\v1\TransactionDetailsType $transaction
     * @return self
     */
    public function setTransaction(\net\authorize\api\contract\v1\TransactionDetailsType $transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * Gets as clientId
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * Sets a new clientId
     *
     * @param string $clientId
     * @return self
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * Gets as transrefId
     *
     * @return string
     */
    public function getTransrefId()
    {
        return $this->transrefId;
    }

    /**
     * Sets a new transrefId
     *
     * @param string $transrefId
     * @return self
     */
    public function setTransrefId($transrefId)
    {
        $this->transrefId = $transrefId;
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

