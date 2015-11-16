<?php

namespace RfidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use RfidBundle\Validator\Constraints\ValidSelectedRetailer;

/**
 * Retailer
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ValidSelectedRetailer
 */
class Retailer
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\Package")
     * @ORM\JoinColumn(nullable=false)
     */
    private $package;
    
    
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
     * Set name
     *
     * @param string $name
     *
     * @return Retailer
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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Retailer
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
     * Set package
     *
     * @param \RfidBundle\Entity\Package $package
     *
     * @return Retailer
     */
    public function setPackage(\RfidBundle\Entity\Package $package)
    {
        $this->package = $package;

        return $this;
    }

    /**
     * Get package
     *
     * @return \RfidBundle\Entity\Package
     */
    public function getPackage()
    {
        return $this->package;
    }
}
