<?php
namespace RfidBundle\Validator\Constraints;

use RfidBundle\Entity\Retailer;
use RfidBundle\Entity\Store;
use RfidBundle\Entity\Zone;
use RfidBundle\Entity\RfidLog;
use RfidBundle\Entity\Device;
use RfidBundle\Entity\StoreType;
use RfidBundle\Entity\ZoneType;
use RfidBundle\Entity\RfidLogType;
use RfidBundle\Entity\DeviceType;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
/**
 * Validates selected retailer.
 *
 * @author Kévin Dunglas <kevin@les-tilleuls.coop>
 */
class ValidSelectedRetailerValidator extends  ConstraintValidator
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;
    public function __construct(TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }
    /**
     * {@inheritdoc}
     *
     * @param \RfidBundle\Entity\RedirectRule $value
     */
    public function validate($value, Constraint $constraint)
    {
        // Admins can to everything
        if ($this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
            return;
        }
        //If the user is allowed for the retailer, it can see it
        if ($value instanceof Retailer && $this->isRetailerAllowed($value)) {
            return;
        }
        
        //types (2 level)
        if ($value instanceof DeviceType || $value instanceof RfidLogType || $value instanceof StoreType || $value instanceof ZoneType ) {
            if (null === $value->getPrivate() || $this->isRetailerAllowed($value->getPrivate())) {
                return;
            }
        }
        
        //2 levels
        if ($value instanceof Store && ($this->isStoreAllowed($value) || $this->authorizationChecker->isGranted('ROLE_RETAILER_HQ'))) {
            if ($this->isRetailerAllowed($value->getRetailer())) {
                return;
            }
        }
        if ($value instanceof Product && $this->authorizationChecker->isGranted('ROLE_RETAILER_HQ')) {
            if ($this->isRetailerAllowed($value->getRetailer())) {
                return;
            }
        }
        
        // 3 levels going through stores
        if ($value instanceof Zone && ($this->isStoreAllowed($value->getStore()) || $this->authorizationChecker->isGranted('ROLE_RETAILER_HQ'))) {
            if ($this->isRetailerAllowed($value->getStore()->getRetailer())) {
                return;
            }
        }
        if ($value instanceof RfidLog && ($this->isStoreAllowed($value->getStore()) || $this->authorizationChecker->isGranted('ROLE_RETAILER_HQ'))) {
            if ($this->isRetailerAllowed($value->getStore()->getRetailer())) {
                return;
            }
        }
        if ($value instanceof Device && ($this->isStoreAllowed($value->getStore()) || $this->authorizationChecker->isGranted('ROLE_RETAILER_HQ'))) {
            if ($this->isRetailerAllowed($value->getStore()->getRetailer())) {
                return;
            }
        }
        if ($value instanceof Location && ($this->isStoreAllowed($value->getStore()) || $this->authorizationChecker->isGranted('ROLE_RETAILER_HQ'))) {
            if ($this->isRetailerAllowed($value->getStore()->getRetailer())) {
                return;
            }
        }
        //users
        if ($value instanceof User) {
            foreach ($value->getRetailers() as $retailer) {
                if ($this->isRetailerAllowed($retailer)) {
                    return;
                }
            }
        }
        $this
            ->context
            ->buildViolation($constraint->message)
            ->addViolation()
        ;
    }
    /**
     * Checks if the user is allowed for the given retailer.
     *
     * @param Retailer $retailer
     *
     * @return bool
     */
    private function isRetailerAllowed(Retailer $retailer)
    {
        foreach ($this->tokenStorage->getToken()->getUser()->getRetailers() as $userRetailer) {
            if ($retailer->getId() === $userRetailer->getId()) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Checks if the user is allowed for the given retailer.
     *
     * @param Store $store
     *
     * @return bool
     */
    private function isStoreAllowed(Store $store)
    {
        foreach ($this->tokenStorage->getToken()->getUser()->getStores() as $userStore) {
            if ($store->getId() === $userStore->getId()) {
                return true;
            }
        }
        return false;
    }
}