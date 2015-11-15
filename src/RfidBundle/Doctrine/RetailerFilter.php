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
     * @var string
     */
    private $storeIds;
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
     * Sets properly quoted store ids.
     *
     * @param string $storeIds
     */
    public function setStoreIds($storeIds)
    {
        $this->storeIds = $storeIds;
    }
    /**
     * {@inheritdoc}
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        switch ($targetEntity->getName()) {
            case 'RfidBundle\Entity\Retailer':
                return sprintf('%s.id IN (%s)', $targetTableAlias, $this->retailerIds);
            case 'RfidBundle\Entity\Store':
                if (isset($this->storeIds))
                {return sprintf('%s.id IN (%s)', $targetTableAlias, $this->storeIds);}
                else
                {return sprintf('%s.retailer_id IN (%s)', $targetTableAlias, $this->retailerIds);}  
            case 'RfidBundle\Entity\Zone':
                if (isset($this->storeIds))
                {
                return sprintf(<<<SQL
(SELECT COUNT(filterStore.id) FROM Store filterStore WHERE filterStore.id = %s.store_id AND filterStore.id IN (%s)) = 1
SQL
                , $targetTableAlias, $this->storeIds);
                }
                else
                {
                return sprintf(<<<SQL
(SELECT COUNT(filterStore.id) FROM Store filterStore WHERE filterStore.id = %s.store_id AND filterStore.retailer_id IN (%s)) = 1
SQL
                , $targetTableAlias, $this->retailerIds);
                } 

        }
        return '';
    }
}