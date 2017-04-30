<?php

namespace Application\ApplicationBundle\Entity;

/**
 * Product
 */
class Product
{
    /**
     * @var int
     */
    private $id;
    
    
    /**
     * @var int
     */
    private $transactionId;
    
    /**
     * @var int
     */
    private $productId;
    
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;
    
    /**
     * @var int
     */
    private $capital;

    /**
     * @var int
     */
    private $price;
    
	
    /**
     * @var \DateTime
     */
    private $sellDate;
    
    /**
     * 
     */
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $details;

    /**
     * @var string
     */
    private $customerid;
    
    /**
     * @var string
     */
    private $status;


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
     * @param integer $transactionId
     *
     * @return Product
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;

        return $this;
    }
    
    /**
     * Get transactionId
     *
     * @return int
     */
    public function getTransactionId()
    {
    	return $this->transactionId;
    }
    
    /**
     * Set transactionId
     *
     * @param integer $productId
     *
     * @return Product
     */
    public function setProductId($productId)
    {
    	$this->productId = $productId;
    
    	return $this;
    }
    
    /**
     * Get $productId
     *
     * @return int
     */
    public function getProductId()
    {
    	return $this->productId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Product
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set price
     *
     * @param integer $capital
     *
     * @return Capital
     */
    public function setCapital($capital)
    {
    	$this->capital = $capital;
    
    	return $this;
    }
    
    /**
     * Get capital
     *
     * @return int
     */
    public function getCapital()
    {
    	return $this->capital;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    /**
     * Set sellDate
     *
     * @param \DateTime $sellDate
     *
     * @return Product
     */
    public function setSellDate($sellDate)
    {
    	$this->sellDate = $sellDate;
    
    	return $this;
    }
    
    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getSellDate()
    {
    	return $this->sellDate;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Product
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return Product
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set customerid
     *
     * @param string $customerid
     *
     * @return Product
     */
    public function setCustomerid($customerid)
    {
        $this->customerid = $customerid;

        return $this;
    }

    /**
     * Get customerid
     *
     * @return string
     */
    public function getCustomerid()
    {
        return $this->customerid;
    }
    
    /**
     * Set customerid
     *
     * @param string $status
     *
     * @return Product
     */
    public function setStatus($status)
    {
    	$this->status = $status;
    
    	return $this;
    }
    
    /**
     * Get customerid
     *
     * @return string
     */
    public function getStatus()
    {
    	return $this->status;
    }
}
