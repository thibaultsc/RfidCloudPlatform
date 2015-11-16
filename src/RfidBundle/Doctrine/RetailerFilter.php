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
                
            case 'RfidBundle\Entity\StoreType':
                return sprintf('%s.private_id IN (%s) OR %s.private_id IS NULL', $targetTableAlias, $this->retailerIds, $targetTableAlias);    
            case 'RfidBundle\Entity\ZoneType':
                return sprintf('%s.private_id IN (%s) OR %s.private_id IS NULL', $targetTableAlias, $this->retailerIds, $targetTableAlias);    
            case 'RfidBundle\Entity\RfidLogType':
                return sprintf('%s.private_id IN (%s) OR %s.private_id IS NULL', $targetTableAlias, $this->retailerIds, $targetTableAlias);    
            case 'RfidBundle\Entity\DeviceType':
                return sprintf('%s.private_id IN (%s) OR %s.private_id IS NULL', $targetTableAlias, $this->retailerIds, $targetTableAlias);    
                
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
            case 'RfidBundle\Entity\RfidLog':
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
            case 'RfidBundle\Entity\Device':
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
            case 'RfidBundle\Entity\Location':
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
            case 'RfidBundle\Entity\User':
                return sprintf(<<<'SQL'
%1$s.roles NOT LIKE '%%ROLE_SUPER_ADMIN%%' AND %1$s.roles NOT LIKE '%%ROLE_SUPER_ADMIN%%'
AND (SELECT COUNT(filterUserRetailer.user_id) FROM user_retailer filterUserRetailer WHERE filterUserRetailer.user_id = %1$s.id AND filterUserRetailer.retailer_id IN (%2$s)) = 1
SQL
                    , $targetTableAlias, $this->retailerIds);
        
        }
        return '';
    }
    
}