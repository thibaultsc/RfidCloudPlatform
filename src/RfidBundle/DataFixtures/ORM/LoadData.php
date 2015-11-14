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

class LoadData implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {
    // Store stypes lists
    $storeTypeArray = array(
      array('Store',true),
      array('Corner',true),
      array('Franchise',true),
      array('Distribution center',false),
      array('Factory',false)
    );

    foreach ($storeTypeArray as $storeTypeElement) {
      $storeType = new StoreType();
      $storeType->setName($storeTypeElement[0]);
      $storeType->setFront($storeTypeElement[1]);
      // On la persiste
      $manager->persist($storeType);
    }
    
    // Zone stypes lists
    $zoneTypeArray = array(
      array('Sales Floor',true, true),
      array('Back room',false, true),
      array('Transit',false, false),
      array('Sold', false, false)
    );

    foreach ($zoneTypeArray as $zoneTypeElement) {
      $zoneType = new ZoneType();
      $zoneType->setName($zoneTypeElement[0]);
      $zoneType->setFront($zoneTypeElement[1]);
      $zoneType->setAvailable($zoneTypeElement[2]);
      // On la persiste
      $manager->persist($zoneType);
    }

    // Device stypes lists
    $deviceTypeArray = array(
      array('POS reader','Any'),
      array('Handheld device','Any'),
      array('Fitting room reader','Any'),
      array('Alarm gates','Any')
    );

    foreach ($deviceTypeArray as $deviceTypeElement) {
      $deviceType = new DeviceType();
      $deviceType->setName($deviceTypeElement[0]);
      $deviceType->setModel($deviceTypeElement[1]);
      // On la persiste
      $manager->persist($deviceType);
    }
    
    // Package lists
    $packageArray = array(
      array('Free'),
      array('Pro'),
      array('Unlimited')
    );

    foreach ($packageArray as $packageElement) {
      $package = new Package();
      $package->setName($packageElement[0]);
      // On la persiste
      $manager->persist($package);
    }
    
    // Package lists
    $rfidLogTypeArray = array(
      array('Free'),
      array('Pro'),
      array('Unlimited')
    );

    foreach ($rfidLogTypeArray as $rfidLogTypeElement) {
      $rfidLogType = new RfidLogType();
      $rfidLogType->setName($rfidLogTypeElement[0]);
      // On la persiste
      $manager->persist($rfidLogType);
    }
    
    
    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}