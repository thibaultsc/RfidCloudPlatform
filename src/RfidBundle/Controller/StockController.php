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
        $queryBuilder = $doctrine->getRepository('RfidBundle:RfidLog')->rfidLogQueryBuilder2();
        $group = $request->query->get('groupBy');
        $groupName = $request->query->get('name');
        $where = $request->query->get('where');
        $equals = $request->query->get('equals');
        
        if ($group !== null && $groupName !== null) {
            $j = 0;
            foreach ($group as $groupElement) {
                $querybuilder = $queryBuilder->addGroupBy($groupElement)->addSelect($groupElement." as ".$groupName[$j]);
                $j++;
            }
        }
        
        if ($where !== null && $equals !== null) {
            $i = 0;
            foreach ($where as $whereElement) {
                $querybuilder = $queryBuilder->andWhere($whereElement.' = :value'.$i)->setParameter('value'.$i,$equals[$i]);
                $i++;
            }
        }       

        $stock = $queryBuilder->getQuery()->getResult();
        
        $resource = $this->getResource($request);
        $uri = $request->getRequestUri();
        //return new Response($csv, 200, ['Content-Type' => 'text/csv']);
        return $this->getSuccessResponse($resource, $stock, 200, [], ['request_uri' => $request->getRequestUri()]);
    }
}