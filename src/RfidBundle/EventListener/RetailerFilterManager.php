<?php
namespace RfidBundle\EventListener;
use RfidBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
/**
 * Enables the RetailerFilter when applicable.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class RetailerFilterManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }
    /**
     * Filters SQL queries.
     */
    public function onKernelRequest()
    {
        $token = $this->tokenStorage->getToken();
        $user = $token ? $token->getUser() : null;
        // Don't apply the filter on public pages nor for admins
        if (!$user || !($user instanceof User) || $this->authorizationChecker->isGranted('ROLE_SUPER_ADMIN')) {
            return;
        }
        $ids = [];
        foreach ($user->getRetailers() as $retailer) {
            $ids[] = $this->entityManager->getConnection()->quote($retailer->getId());
        }
        $filter = $this->entityManager->getFilters()->enable('retailer_filter');
        $filter->setRetailerIds(implode(',', $ids));
    }
}