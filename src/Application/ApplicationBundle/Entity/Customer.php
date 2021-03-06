<?php

namespace Application\ApplicationBundle\Entity;

/**
 * Customer
 */
class Customer
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    public $customerId;

    /**
     * @var string
     */
    public $customerName;

    /**
     * @var string
     */
    public $customerPoints;

     /**
     * @var string
     */
    public $customerEmail;

     /**
     * @var string
     */
    public $customerPassword;

    /**
     * @var \DateTime
     */
    private $customerBirthdate;

    /**
     * @var \DateTime
     */
    private $customerJoinDate;



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
     * Set customerId
     *
     * @param string $customerId
     *
     * @return Customer
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

   

    /**
     * Set customerEmail
     *
     * @param string $customerEmail
     *
     * @return Customer
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * Get customerEmail
     *
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

     /**
     * Set customerEmail
     *
     * @param string $customerPassword
     *
     * @return Customer
     */
    public function setCustomerPassword($customerPassword)
    {
        $this->customerPassword = $customerPassword;

        return $this;
    }

    /**
     * Get customerPassword
     *
     * @return string
     */
    public function getCustomerPassword()
    {
        return $this->customerPassword;
    }


    /**
     * Set customerName
     *
     * @param string $customerName
     *
     * @return Customer
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * Set customerPoints
     *
     * @param string $customerPoints
     *
     * @return Customer
     */
    public function setCustomerPoints($customerPoints)
    {
        $this->customerPoints = $customerPoints;

        return $this;
    }

    /**
     * Get customerName
     *
     * @return string
     */
    public function getCustomerPoints()
    {
        return $this->customerPoints;
    }

    /**
     * Set customerBirthdate
     *
     * @param \DateTime $customerBirthdate
     *
     * @return Customer
     */
    public function setCustomerBirthdate($customerBirthdate)
    {
        $this->customerBirthdate = $customerBirthdate;

        return $this;
    }

    /**
     * Get customerBirthdate
     *
     * @return \DateTime
     */
    public function getCustomerBirthdate()
    {
        return $this->customerBirthdate;
    }

    /**
     * Set customerJoinDate
     *
     * @param \DateTime $customerJoinDate
     *
     * @return Customer
     */
    public function setCustomerJoinDate($customerJoinDate)
    {
        $this->customerJoinDate = $customerJoinDate;

        return $this;
    }

    /**
     * Get customerJoinDate
     *
     * @return \DateTime
     */
    public function getCustomerJoinDate()
    {
        return $this->customerJoinDate;
    }
}
