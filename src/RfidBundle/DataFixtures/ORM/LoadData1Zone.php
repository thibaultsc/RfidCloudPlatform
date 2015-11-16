<?php
// src/OC/PlatformBundle/DataFixtures/ORM/LoadCategory.php

namespace RfidBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RfidBundle\Entity\StoreType;
use RfidBundle\Entity\ZoneType;
use RfidBundle\Entity\Zone;
use RfidBundle\Entity\Package;
use RfidBundle\Entity\RfidLogType;
use RfidBundle\Entity\User;
use RfidBundle\Entity\Retailer;
use RfidBundle\Entity\Store;

class LoadData1Zone implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {

    $retailerRepo = $manager->getRepository('RfidBundle:Retailer');
    $storeRepo = $manager->getRepository('RfidBundle:Store');
    $zoneTypeRepo = $manager->getRepository('RfidBundle:ZoneType');
    $packageRepo = $manager->getRepository('RfidBundle:Package');
    
 
   
    // Zone lists
    $zoneArray = array(
      array("Sales Floor",'Lille','SalesFloor'),
      array('Sales Floor','Tourcoing','SalesFloor'),
      array('Sales Floor','V2','SalesFloor')
    );

    foreach ($zoneArray as $zoneElement) {
      $zone = new Zone();
      $zone->setName($zoneElement[0]);
      $zone->setType($zoneTypeRepo->findOneByName($zoneElement[2]));
      $zone->setStore($storeRepo->findOneByName($zoneElement[1]));
      
      // On la persiste
      $manager->persist($zone);
    }
    
    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}