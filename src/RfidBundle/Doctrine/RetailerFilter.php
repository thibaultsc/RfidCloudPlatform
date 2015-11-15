<?php
namespace RfidBundle\Doctrine;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Doctrine\ORM\Mapping\ClassMetadata;
/**
 * Filters queries with retailers the authenticated user can access.
 *
 * @author Thibault Scalbert
 */
class RetailerFilter extends SQLFilter
{
    /**
     * @var string
     */
    private $retailerIds;
    /**
     * Sets properly quoted retailer ids.
     *
     * @param string $retailerIds
     */
    public function setRetailerIds($retailerIds)
    {
        $this->retailerIds = $retailerIds;
    }
    /**
     * {@inheritdoc}
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        switch ($targetEntity->getName()) {
            case 'RfidBundle\Entity\Retailer':
                return sprintf('%s.id IN (%s)', $targetTableAlias, $this->retailerIds);
        }
        return '';
    }
}