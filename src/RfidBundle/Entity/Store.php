<?php

namespace RfidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use RfidBundle\Validator\Constraints\ValidSelectedRetailer;
use Symfony\Component\Serializer\Annotation\Groups;
/**
 * store
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ValidSelectedRetailer
 */
class Store
{
    use TimestampableEntity;
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"store"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"store"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     * @Groups({"loc"})
     */
    private $reference;
    
    /**
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\Location")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"loc"})
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\StoreType")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"store"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\Retailer")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"store"})
     */
    private $retailer;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     * @Groups({"store"})
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
     * Set name
     *
     * @param string $name
     *
     * @return Store
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
     * Set reference
     *
     * @param string $reference
     *
     * @return Store
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Store
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
     * Set location
     *
     * @param \RfidBundle\Entity\Location $location
     *
     * @return Store
     */
    public function setLocation(\RfidBundle\Entity\Location $location = null)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return \RfidBundle\Entity\Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set type
     *
     * @param \RfidBundle\Entity\StoreType $type
     *
     * @return Store
     */
    public function setType(\RfidBundle\Entity\StoreType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \RfidBundle\Entity\StoreType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set retailer
     *
     * @param \RfidBundle\Entity\Retailer $retailer
     *
     * @return Store
     */
    public function setRetailer(\RfidBundle\Entity\Retailer $retailer)
    {
        $this->retailer = $retailer;

        return $this;
    }

    /**
     * Get retailer
     *
     * @return \RfidBundle\Entity\Retailer
     */
    public function getRetailer()
    {
        return $this->retailer;
    }
}
