<?php

// src/AppBundle/Controller/CustomController.php

namespace RfidBundle\Controller;

use Dunglas\ApiBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Dunglas\JsonLdApiBundle\Response\JsonLdResponse;
use Dunglas\ApiBundle\Api\ResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("/api")
 */
class StockController extends ResourceController
{
    // Customize the AppBundle:Custom:custom action
    /**
     * @Route("/stocks")
     * @param Request $request
     * @return type
     */
    public function stockGetAction(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $zoneTypes = $doctrine->getRepository('RfidBundle:ZoneType')->findByAvailable(1);
        $zones = $doctrine->getRepository('RfidBundle:Zone')->findByType($zoneTypes);
        $stock = $doctrine->getRepository('RfidBundle:RfidLog')->findBy(array("enabled" => 1, "zone" => $zones));
        
        
        
        $resource = $this->getResource($request);
        $uri = $request->getRequestUri();
        //return new Response($csv, 200, ['Content-Type' => 'text/csv']);
        return $this->getSuccessResponse($resource, $stock, 200, [], ['request_uri' => $request->getRequestUri()]);
        
    }
}