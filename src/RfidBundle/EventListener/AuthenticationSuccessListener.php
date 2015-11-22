<?php
namespace RfidBundle\EventListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
/**
 * Adds roles to the JWT payload.
 *
 * @author Kévin Dunglas
 */
class AuthenticationSuccessListener
{
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
        if (!$user instanceof UserInterface) {
            return;
        }
        $retailers = $user->getRetailers();
        $retailersString = [];
        foreach ($retailers as $retailer)
        {
            $retailersString[] = "/api/retailers/".$retailer->getId();    
        }
        $stores = $user->getStores();
        $storesString = [];
        foreach ($stores as $store)
        {
            $storesString[] = "/api/stores/".$store->getId();    
        }
        $data['data'] = array(
            'roles' => $user->getRoles(), 
            'retailers' => $retailersString,
            'stores' => $storesString,
        );
        $event->setData($data);
    }
}
