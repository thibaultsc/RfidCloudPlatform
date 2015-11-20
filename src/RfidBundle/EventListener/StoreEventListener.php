<?php
namespace RfidBundle\EventListener;
use RfidBundle\Entity\Store;
use RfidBundle\Entity\Zone;
use Dunglas\ApiBundle\Event\DataEvent;
use Doctrine\Common\Persistence\ManagerRegistry;
/**
 * Listens on users creation and send a mail with further informations.
 */
class StoreEventListener
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;
    /**
     * Consctructs manager registry.
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }
    
    /**
     * Calls function create a zone in a new store
     *
     * @param DataEvent $event
     */
    public function onPostCreate(DataEvent $event)
    {
        $object = $event->getData();
        if ($object instanceof Store) {
            $em =  $this->managerRegistry;
            $zoneRepository = $em->getRepository('RfidBundle:ZoneType');
            
            // Store stypes lists
            $zoneArray = array( 
                array('SalesFloor'),
                array('BackRoom'),
                array('Transit'),
                array('Sold')
            );
            $entityManager = $em->getManagerForClass(get_class(new Zone()));
            
            foreach ($zoneArray as $zoneElement) {
                $zoneType = $zoneRepository->findOneByName($zoneElement[0]);
                $zone = new Zone();
                $zone->setName("Initial ".$zoneElement[0]);
                $zone->setType($zoneType);
                $zone->setStore($object);
                $entityManager->persist($zone);
            }
            $entityManager->flush();
        }
    }
}