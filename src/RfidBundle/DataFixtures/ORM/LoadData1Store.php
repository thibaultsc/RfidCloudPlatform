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

class LoadData1Store implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {

    $retailerRepo = $manager->getRepository('RfidBundle:Retailer');
    $storeRepo = $manager->getRepository('RfidBundle:Store');
    $storeTypeRepo = $manager->getRepository('RfidBundle:StoreType');
    $packageRepo = $manager->getRepository('RfidBundle:Package');

    // store  lists
    $storeArray = array(
      array("Devred","V2",'Store'),
      array("Promod", "Tourcoing",'Store'),
      array("Promod", "Lille",'Store')
    );

    foreach ($storeArray as $storeElement) {
      $store = new Store();
      $store->setName($storeElement[1]);

      $retailer = $retailerRepo->findOneByName($storeElement[0]);
      $store->setRetailer($retailer);
      
      $storeType = $storeTypeRepo->findOneByName($storeElement[2]);
      $store->setType($storeType);

      // On la persiste
      $manager->persist($store);
    }
    
     
    
    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}