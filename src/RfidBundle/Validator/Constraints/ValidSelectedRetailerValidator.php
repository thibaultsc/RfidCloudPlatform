<?php
namespace RfidBundle\Validator\Constraints;

use RfidBundle\Entity\Retailer;

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

        if ($value instanceof Retailer && $this->isRetailerAllowed($value)) {
            return;
        }

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
}