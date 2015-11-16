<?php

namespace RfidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Location
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Location
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
     * @ORM\Column(name="streetAddress", type="string", length=255, nullable=true)
     */
    private $streetAddress;
    
        /**
     * @var string
     *
     * @ORM\Column(name="$streetAddressAdditional", type="string", length=255, nullable=true)
     */
    private $streetAddressAdditional;
    
    /**
     * @var string
     *
     * @ORM\Column(name="postalCode", type="string", length=255, nullable=true)
     */
    private $postalCode;
    
    /**
     * @var string
     *
     * @ORM\Column(name="postOfficeBoxNumber", type="string", length=255, nullable=true)
     */
    private $postOfficeBoxNumber;
    
    /**
     * @var string
     *
     * @ORM\Column(name="addressRegion", type="string", length=255, nullable=true)
     */
    private $addressRegion;
    
    /**
     * @var string
     *
     * @ORM\Column(name="addressLocality", type="string", length=255, nullable=true)
     */
    private $addressLocality;
    
    /**
     * @var string
     *
     * @ORM\Column(name="addressCountry", type="string", length=255, nullable=true)
     */
    private $addressCountry;
    
    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     */
    private $latitude;
    
    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;
    
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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Location
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
     * Set streetAddress
     *
     * @param string $streetAddress
     *
     * @return Location
     */
    public function setStreetAddress($streetAddress)
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    /**
     * Get streetAddress
     *
     * @return string
     */
    public function getStreetAddress()
    {
        return $this->streetAddress;
    }

    /**
     * Set streetAddressAdditional
     *
     * @param string $streetAddressAdditional
     *
     * @return Location
     */
    public function setStreetAddressAdditional($streetAddressAdditional)
    {
        $this->streetAddressAdditional = $streetAddressAdditional;

        return $this;
    }

    /**
     * Get streetAddressAdditional
     *
     * @return string
     */
    public function getStreetAddressAdditional()
    {
        return $this->streetAddressAdditional;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Location
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set postOfficeBoxNumber
     *
     * @param string $postOfficeBoxNumber
     *
     * @return Location
     */
    public function setPostOfficeBoxNumber($postOfficeBoxNumber)
    {
        $this->postOfficeBoxNumber = $postOfficeBoxNumber;

        return $this;
    }

    /**
     * Get postOfficeBoxNumber
     *
     * @return string
     */
    public function getPostOfficeBoxNumber()
    {
        return $this->postOfficeBoxNumber;
    }

    /**
     * Set addressRegion
     *
     * @param string $addressRegion
     *
     * @return Location
     */
    public function setAddressRegion($addressRegion)
    {
        $this->addressRegion = $addressRegion;

        return $this;
    }

    /**
     * Get addressRegion
     *
     * @return string
     */
    public function getAddressRegion()
    {
        return $this->addressRegion;
    }

    /**
     * Set addressLocality
     *
     * @param string $addressLocality
     *
     * @return Location
     */
    public function setAddressLocality($addressLocality)
    {
        $this->addressLocality = $addressLocality;

        return $this;
    }

    /**
     * Get addressLocality
     *
     * @return string
     */
    public function getAddressLocality()
    {
        return $this->addressLocality;
    }

    /**
     * Set addressCountry
     *
     * @param string $addressCountry
     *
     * @return Location
     */
    public function setAddressCountry($addressCountry)
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * Get addressCountry
     *
     * @return string
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Location
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Location
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
