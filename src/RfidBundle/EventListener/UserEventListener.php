<?php
namespace RfidBundle\EventListener;
use RfidBundle\Entity\User;
use Dunglas\ApiBundle\Event\DataEvent;
use Doctrine\Common\Persistence\ManagerRegistry;
/**
 * Listens on users creation and send a mail with further informations.
 */
class UserEventListener
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
    public function onPreCreate(DataEvent $event)
    {
        $object = $event->getData();
        if ($object instanceof User) {
            
            
            $em =  $this->managerRegistry;
            $zoneRepository = $em->getRepository('RfidBundle:ZoneType');
            
            // Store stypes lists
            $zoneArray = array( 
                array('Sales Floor'),
                array('Back room'),
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