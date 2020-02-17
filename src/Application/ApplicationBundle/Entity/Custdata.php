<?php

namespace Application\ApplicationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Custdata
 *
 * @ORM\Table(name="custdata")
 * @ORM\Entity(repositoryClass="Application\ApplicationBundle\Repository\CustdataRepository")
 */
class Custdata
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="deviceId", type="string", length=255,  nullable=true)
     */
    private $deviceId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255,  nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="ipAddress", type="string", length=255,  nullable=true)
     */
    private $ipAddress;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=255,  nullable=true)
     */
    private $action;

    /**
     * @var string
     *
     * @ORM\Column(name="cookieId", type="string", length=255,  nullable=true)
     */
    private $cookieId;

    /**
     * @var string
     *
     * @ORM\Column(name="googleAnalyticsUserId", type="string", length=255,  nullable=true)
     */
    private $googleAnalyticsUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="salesforceUserId", type="string", length=255,  nullable=true)
     */
    private $salesforceUserId;

    /**
     * @var string
     *
     * @ORM\Column(name="salesforceUserId", type="string", length=255,  nullable=true)
     */
    private $ipEntity;


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
     * Set phone
     *
     * @param string $phone
     *
     * @return Custdata
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Custdata
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Custdata
     */
    public function setIpentity($ipEntity)
    {
        $this->ipEntity = $ipEntity;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getIpentity()
    {
        return $this->ipEntity;
    }


    /**
     * Set deviceId
     *
     * @param string $deviceId
     *
     * @return Custdata
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return Custdata
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set action
     *
     * @param string $action
     *
     * @return Custdata
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set cookieId
     *
     * @param string $cookieId
     *
     * @return Custdata
     */
    public function setCookieId($cookieId)
    {
        $this->cookieId = $cookieId;

        return $this;
    }

    /**
     * Get cookieId
     *
     * @return string
     */
    public function getCookieId()
    {
        return $this->cookieId;
    }

    /**
     * Set googleAnalyticsUserId
     *
     * @param string $googleAnalyticsUserId
     *
     * @return Custdata
     */
    public function setGoogleAnalyticsUserId($googleAnalyticsUserId)
    {
        $this->googleAnalyticsUserId = $googleAnalyticsUserId;

        return $this;
    }

    /**
     * Get googleAnalyticsUserId
     *
     * @return string
     */
    public function getGoogleAnalyticsUserId()
    {
        return $this->googleAnalyticsUserId;
    }

    /**
     * Set salesforceUserId
     *
     * @param string $salesforceUserId
     *
     * @return Custdata
     */
    public function setSalesforceUserId($salesforceUserId)
    {
        $this->salesforceUserId = $salesforceUserId;

        return $this;
    }

    /**
     * Get salesforceUserId
     *
     * @return string
     */
    public function getSalesforceUserId()
    {
        return $this->salesforceUserId;
    }
}

