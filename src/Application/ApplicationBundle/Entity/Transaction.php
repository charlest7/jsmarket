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
}

