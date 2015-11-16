<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace RfidBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RfidBundle\Entity\StoreType;
use RfidBundle\Entity\ZoneType;
use RfidBundle\Entity\DeviceType;
use RfidBundle\Entity\Package;
use RfidBundle\Entity\RfidLogType;
use RfidBundle\Entity\User;
use RfidBundle\Entity\Retailer;
use RfidBundle\Entity\Store;

class LoadData1Retailer implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {

    $retailerRepo = $manager->getRepository('RfidBundle:Retailer');
    $storeRepo = $manager->getRepository('RfidBundle:Store');
    $storeTypeRepo = $manager->getRepository('RfidBundle:StoreType');
    $packageRepo = $manager->getRepository('RfidBundle:Package');
    
 
    
    // retailer  lists
    $retailerArray = array(
      array('Devred','Free'),
      array('Promod','Free'),
      array('KO','Free')
    );

    foreach ($retailerArray as $retailerElement) {
      $retailer = new Retailer();
      $retailer->setName($retailerElement[0]);
      $package = $packageRepo->findOneByName($retailerElement[1]);
      $retailer->setPackage($package);
      // On la persiste
      $manager->persist($retailer);
    }
    
    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}