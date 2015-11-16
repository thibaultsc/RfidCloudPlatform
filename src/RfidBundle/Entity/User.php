<?php
// src/AppBundle/Entity/User.php

namespace RfidBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;    
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table()
 * @ORM\Entity
 * 
 * @UniqueEntity("email")
 * @UniqueEntity("username")
 */
class User extends BaseUser
{
    use TimestampableEntity;
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string The username of the author.
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $username;

    /**
     * @var string The email of the user.
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $email;

    /**
     * @var string Plain password. Used for model validation. Must not be persisted.
     *
     * @Groups({"user_write"})
     */
    protected $plainPassword;

    /**
     * @var boolean Shows that the user is enabled
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $enabled;

    /**
     * @var array Array, role(s) of the user
     *
     * @Groups({"user_read", "user_write"})
     */
    protected $roles;
    
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
