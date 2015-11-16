<?php

namespace RfidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * RfidLog
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="RfidBundle\Entity\RfidLogRepository")
 */
class RfidLog
{
    use TimestampableEntity;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timeStamp", type="datetime")
     */
    private $timeStamp;

    /**
     * @var string
     *
     * @ORM\Column(name="epc", type="string", length=255)
     */
    private $epc;

    
    /**
     * @var integer
     * 100 = Logitics
     * 200 = Available
     * 300 = Reserved
     * 400 = Sold
     * @ORM\Column(name="status", type="integer", nullable=true)
     */
    private $status;

    /** 
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\RfidLogType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\Zone")
     * @ORM\JoinColumn(nullable=true)
     */
    private $zone;

    /**
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\Store")
     * @ORM\JoinColumn(nullable=true)
     */
    private $store;
    
    /**
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\RfidLogType")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\Device")
     * @ORM\JoinColumn(nullable=true)
     */
    private $device;

    /**
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\Product")
     * @ORM\JoinColumn(nullable=true)
     */
    private $product;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="damaged", type="boolean", nullable=true)
     */
    private $damaged;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled = true;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set timeStamp
     *
     * @param \DateTime $timeStamp
     *
     * @return RfidLog
     */
    public function setTimeStamp($timeStamp)
    {
        $this->timeStamp = $timeStamp;

        return $this;
    }

    /**
     * Get timeStamp
     *
     * @return \DateTime
     */
    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    /**
     * Set epc
     *
     * @param string $epc
     *
     * @return RfidLog
     */
    public function setEpc($epc)
    {
        $this->epc = $epc;

        return $this;
    }

    /**
     * Get epc
     *
     * @return string
     */
    public function getEpc()
    {
        return $this->epc;
    }


    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return RfidLog
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }


    /**
     * Set zone
     *
     * @param string $zone
     *
     * @return RfidLog
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return string
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set user
     *
     * @param string $user
     *
     * @return RfidLog
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set device
     *
     * @param string $device
     *
     * @return RfidLog
     */
    public function setDevice($device)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device
     *
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * Set product
     *
     * @param string $product
     *
     * @return RfidLog
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return string
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set type
     *
     * @param \RfidBundle\Entity\RfidLogType $type
     *
     * @return RfidLog
     */
    public function setType(\RfidBundle\Entity\RfidLogType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \RfidBundle\Entity\RfidLogType
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Set status
     *
     * @param integer $status
     *
     * @return RfidLog
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set damaged
     *
     * @param boolean $damaged
     *
     * @return RfidLog
     */
    public function setDamaged($damaged)
    {
        $this->damaged = $damaged;

        return $this;
    }

    /**
     * Get damaged
     *
     * @return boolean
     */
    public function getDamaged()
    {
        return $this->damaged;
    }

    /**
     * Set store
     *
     * @param \RfidBundle\Entity\Store $store
     *
     * @return RfidLog
     */
    public function setStore(\RfidBundle\Entity\Store $store)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Get store
     *
     * @return \RfidBundle\Entity\Store
     */
    public function getStore()
    {
        return $this->store;
    }
}
