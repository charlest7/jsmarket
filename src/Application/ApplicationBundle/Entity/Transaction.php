<?php

namespace Application\ApplicationBundle\Entity;

/**
 * Transaction
 */
class Transaction
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $transactionId;


    /**
     * @var string
     */
    private $transactionCustomerId;

    /**
     * @var \DateTime
     */
    private $transactionDate;

    /**
     * @var int
     */
    private $transactionTotalItem;

    /**
     * @var string
     */
    private $transactionStoreId;

    /**
     * @var string
     */
    private $transactionPaymentType;
    
    /**
     * @var string
     */
    private $transactionTotalTransaction;
    
    /**
     * @var string
     */
    private $transactionTotalPayment;
    
    /**
     * @var string
     */
    private $transactionTotalChangeDue;
    

    


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set transactionId
     *
     * @param string $transactionId
     *
     * @return Transaction
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    /**
     * Get transactionId
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set transactionCustomerId
     *
     * @param string $transactionCustomerId
     *
     * @return Transaction
     */
    public function setTransactionCustomerId($transactionCustomerId)
    {
        $this->transactionCustomerId = $transactionCustomerId;

        return $this;
    }

    /**
     * Get transactionCustomerId
     *
     * @return string
     */
    public function getTransactionCustomerId()
    {
        return $this->transactionCustomderId;
    }

    /**
     * Set transactionDate
     *
     * @param \DateTime $transactionDate
     *
     * @return Transaction
     */
    public function setTransactionDate($transactionDate)
    {
        $this->transactionDate = $transactionDate;

        return $this;
    }

    /**
     * Get transactionDate
     *
     * @return \DateTime
     */
    public function getTransactionDate()
    {
        return $this->transactionDate;
    }

    /**
     * Set transactionTotalItem
     *
     * @param integer $transactionTotalItem
     *
     * @return Transaction
     */
    public function setTransactionTotalItem($transactionTotalItem)
    {
        $this->transactionTotalItem = $transactionTotalItem;

        return $this;
    }

    /**
     * Get transactionTotalItem
     *
     * @return int
     */
    public function getTransactionTotalItem()
    {
        return $this->transactionTotalItem;
    }

    /**
     * Set transactionStoreId
     *
     * @param string $transactionStoreId
     *
     * @return Transaction
     */
    public function setTransactionStoreId($transactionStoreId)
    {
        $this->transactionStoreId = $transactionStoreId;

        return $this;
    }

    /**
     * Get transactionStoreId
     *
     * @return string
     */
    public function getTransactionStoreId()
    {
        return $this->transactionStoreId;
    }

    /**
     * Set transactionPaymentType
     *
     * @param string $transactionPaymentType
     *
     * @return Transaction
     */
    public function setTransactionPaymentType($transactionPaymentType)
    {
        $this->transactionPaymentType = $transactionPaymentType;

        return $this;
    }

    /**
     * Get transactionPaymentType
     *
     * @return string
     */
    public function getTransactionPaymentType()
    {
        return $this->transactionPaymentType;
    }
    
    /**
     * Set transactionTotalTransaction
     *
     * @param string $transactionTotalTransaction
     *
     * @return Transaction
     */
    public function setTransactionTotalTransaction($transactionTotalTransaction)
    {
    	$this->transactionTotalTransaction= $transactionTotalTransaction;
    	
    	return $this;
    }
    
    /**
     * Get transactionTotalTransaction
     *
     * @return string
     */
    public function getTransactionTotalTransaction()
    {
    	return $this->transactionTotalTransaction;
    }
    
    /**
     * Set transactionTotalPayment
     *
     * @param string $transactionTotalPayment
     *
     * @return Transaction
     */
    public function setTransactionTotalPayment($transactionTotalPayment)
    {
    	$this->transactionTotalPayment= $transactionTotalPayment;
    	
    	return $this;
    }
    
    /**
     * Get transactionTotalPayment
     *
     * @return string
     */
    public function getTransactionTotalPayment()
    {
    	return $this->transactionTotalPayment;
    }
    
    /**
     * Set transactionTotalChangeDue
     *
     * @param string $transactionTotalChangeDue
     *
     * @return Transaction
     */
    public function setTransactionTotalChangeDue($transactionTotalChangeDue)
    {
    	$this->transactionTotalChangeDue= $transactionTotalChangeDue;
    	
    	return $this;
    }
    
    /**
     * Get transactionTotalChangeDue
     *
     * @return string
     */
    public function getTransactionTotalChangeDue()
    {
    	return $this->transactionTotalChangeDue;
    }
}
