<?php
namespace RfidBundle\EventListener;
use RfidBundle\Entity\RfidLog;
use Dunglas\ApiBundle\Event\DataEvent;
use Doctrine\Common\Persistence\ManagerRegistry;
/**
 * Listens on users creation and send a mail with further informations.
 */
class RfidLogEventListener
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
        if ($object instanceof RfidLog) {
            //get an older log with same EPC enabled if any
            $olderEnabled = $this->managerRegistry->getRepository('RfidBundle:RfidLog')->getOlderEnabledByEpc($object);
            // if any, set it to false
            if ($olderEnabled) {
                $olderEnabled->setEnabled(false);
                
                if (null ===$object->getStatus()){$object->setStatus($olderEnabled->getStatus());}
                if (null ===$object->getZone()){$object->setZone($olderEnabled->getZone());}
                if (null === $object->getDamaged()){$object->setDamaged($olderEnabled->getDamaged());}
                if (null ===$object->getProduct()){$object->setProduct($olderEnabled->getProduct());}
            }
            // if none, check if there is an newer one
            else
            {
                $logEnabled = $this->managerRegistry->getRepository('RfidBundle:RfidLog')->getEnabledByEpc($object);
                if ($logEnabled) {
                    $object->setEnabled(false);
                }
            }
            $object->setStore($object->getZone()->getStore());
        }
    }
}