<?php

namespace RfidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * StoreType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class StoreType
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
     * @Groups({"store"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="RfidBundle\Entity\Retailer")
     * @ORM\JoinColumn(nullable=true)
     */
    private $private;

    /**
     * @var boolean
     *
     * @ORM\Column(name="front", type="boolean")
     */
    private $front;

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
     * @return StoreType
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
     * Set front
     *
     * @param boolean $front
     *
     * @return StoreType
     */
    public function setFront($front)
    {
        $this->front = $front;

        return $this;
    }

    /**
     * Get front
     *
     * @return boolean
     */
    public function getFront()
    {
        return $this->front;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return StoreType
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
     * @return StoreType
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
