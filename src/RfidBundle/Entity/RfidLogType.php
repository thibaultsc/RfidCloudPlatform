<?php

namespace RfidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * RfidLogType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RfidLogType
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
     * @var boolean
     *
     * @ORM\Column(name="inStock", type="boolean")
     */
    private $inStock;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\Retailer")
     * @ORM\JoinColumn(nullable=true)
     */
    private $private = true;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

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
     * @return RfidLogType
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
     * Set inStock
     *
     * @param boolean $inStock
     *
     * @return RfidLogType
     */
    public function setInStock($inStock)
    {
        $this->inStock = $inStock;

        return $this;
    }

    /**
     * Get inStock
     *
     * @return boolean
     */
    public function getInStock()
    {
        return $this->inStock;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return RfidLogType
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
     * Set private
     *
     * @param \RfidBundle\Entity\Retailer $private
     *
     * @return RfidLogType
     */
    public function setPrivate(\RfidBundle\Entity\Retailer $private = null)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return \RfidBundle\Entity\Retailer
     */
    public function getPrivate()
    {
        return $this->private;
    }
}
