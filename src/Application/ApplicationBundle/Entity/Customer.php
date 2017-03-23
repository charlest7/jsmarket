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
    private $customerId;

    /**
     * @var string
     */
    private $customerName;

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

