<?php

namespace Application\ApplicationBundle\Entity;

/**
 * Sales
 */
class Sales
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $transactionIdSales;

    /**
     * @var string
     */
    private $productIdSales;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $salePriceSales;

    /**
     * @var string
     */
    private $profitSales;
    
    
    /**
     * @var \DateTime
     */
    private $dateSales;


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
     * Set transactionIdSales
     *
     * @param string $transactionIdSales
     *
     * @return Sales
     */
    public function setTransactionIdSales($transactionIdSales)
    {
        $this->transactionIdSales = $transactionIdSales;

        return $this;
    }

    /**
     * Get transactionIdSales
     *
     * @return string
     */
    public function getTransactionIdSales()
    {
        return $this->transactionIdSales;
    }

    /**
     * Set productIdSales
     *
     * @param string $productIdSales
     *
     * @return Sales
     */
    public function setProductIdSales($productIdSales)
    {
        $this->productIdSales = $productIdSales;

        return $this;
    }

    /**
     * Get productIdSales
     *
     * @return string
     */
    public function getProductIdSales()
    {
        return $this->productIdSales;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Sales
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set salePriceSales
     *
     * @param string $salePriceSales
     *
     * @return Sales
     */
    public function setSalePriceSales($salePriceSales)
    {
        $this->salePriceSales = $salePriceSales;

        return $this;
    }

    /**
     * Get profitSales
     *
     * @return string
     */
    public function getProfitSales()
    {
        return $this->profitSales;
    }
    
    /**
     * Set profitSales
     *
     * @param string $profitSales
     *
     * @return Sales
     */
    public function setProfitSales($profitSales)
    {
    	$this->profitSales = $profitSales;
    
    	return $this;
    }
    
    /**
     * Get salePriceSales
     *
     * @return string
     */
    public function getSalePriceSales()
    {
    	return $this->salePriceSales;
    }

    /**
     * Set daeSales
     *
     * @param \DateTime $dateSales
     *
     * @return Sales
     */
    public function setDateSales($dateSales)
    {
        $this->dateSales = $dateSales;

        return $this;
    }

    /**
     * Get daeSales
     *
     * @return \DateTime
     */
    public function getDateSales()
    {
        return $this->dateSales;
    }
}
