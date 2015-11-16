<?php
// src/AppBundle/Entity/User.php

namespace RfidBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;    
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Table()
 * @ORM\Entity
 */
class User extends BaseUser
{
    use TimestampableEntity;
    /**
     * @var int
     *
     * @ORM\Column(type = "integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    protected $id;
    
    /**
     * @var Retailer[]
     *
     * @ORM\ManyToMany(targetEntity="Retailer")
     */
    private $retailers;
    
    /**
     * @var Store[]
     *
     * @ORM\ManyToMany(targetEntity="Store")
     */
    private $stores;
    
    public function __construct()
    {
        parent::__construct();
        $this->retailers = new ArrayCollection();
        $this->stores = new ArrayCollection();
    }
    
    /**
     * Gets id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Gets retailers.
     *
     * @return Retailer[]
     */
    public function getRetailers()
    {
        return $this->retailers;
    }
    /**
     * Sets retailers.
     *
     * @param Retailer[] $retailers
     */
    public function setRetailers($retailers)
    {
        $this->retailers = $retailers;
    }

 

    /**
     * Gets stores.
     *
     * @return Store[]
     */
    public function getStores()
    {
        return $this->stores;
    }
        
    /**
     * Sets stores.
     *
     * @param Store[] $stores
     */
    public function setStores($stores)
    {
        $this->stores = $stores;
    }
}
