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

class LoadData1User implements FixtureInterface
{
  // Dans l'argument de la méthode load, l'objet $manager est l'EntityManager
  public function load(ObjectManager $manager)
  {

    $retailerRepo = $manager->getRepository('RfidBundle:Retailer');
    $storeRepo = $manager->getRepository('RfidBundle:Store');
    $storeTypeRepo = $manager->getRepository('RfidBundle:StoreType');
    $packageRepo = $manager->getRepository('RfidBundle:Package');
    
 
   
    // User lists
    $userArray = array(
      array("tibo",'test','tibo',array("ROLE_SUPER_ADMIN")),
      array('promod','test','tibeo@email.com',array("ROLE_RETAILER_ADMIN"), array("Promod")),
      array('promodhq','test','tieebo@email.com',array("ROLE_RETAILER_HQ"), array("Promod")),
      array('promodt','test','tibeeeo@email.com',array("ROLE_USER"), array("Promod"), array("Tourcoing")),
    );

    foreach ($userArray as $userElement) {
      $user = new User();
      $user->setUsername($userElement[0]);
      $user->setPlainPassword($userElement[1]);
      $user->setEmail($userElement[2]);
      $user->setRoles($userElement[3]);
      $user->setEnabled(1);
      if (isset($userElement[4][0])) 
      {
          $user->setRetailers(array($retailerRepo->findOneByName($userElement[4][0])));
      }
      if (isset($userElement[5][0])) 
      {
          $user->setStores(array($storeRepo->findOneByName($userElement[5][0])));
      }
      // On la persiste
      $manager->persist($user);
    }
    
    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}