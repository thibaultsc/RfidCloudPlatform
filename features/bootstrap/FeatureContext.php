<?php

use AppBundle\Entity\Duraltag;
use AppBundle\Entity\ItemAssociation;
use AppBundle\Entity\Retailer;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;
use FOS\UserBundle\Model\UserManagerInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $manager;
    /**
     * @var UserManagerInterface
     */
    private $userManager;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct(ManagerRegistry $doctrine, UserManagerInterface $userManager)
    {
        $this->doctrine = $doctrine;
        $this->manager = $doctrine->getManager();
        $this->schemaTool = new SchemaTool($this->manager);
        $this->classes = $this->manager->getMetadataFactory()->getAllMetadata();
        $this->userManager = $userManager;
    }

    /**
     * @BeforeScenario @createSchema
     */
    public function createDatabase()
    {
        $this->schemaTool->createSchema($this->classes);
    }

    /**
     * @AfterScenario @dropSchema
     */
    public function dropDatabase()
    {
        $this->schemaTool->dropSchema($this->classes);
    }

    /**
     * @Given The database is populated with test data
     */
    public function theDatabaseIsPopulatedWithTestData()
    {
        $retailer = new Retailer();
        $retailer->setName('My test retailer.');

        $this->manager->persist($retailer);

        $duraltag2 = new Duraltag();
        $duraltag2->setQrCode('QRCODE2');
        $duraltag2->setRetailer($retailer);
        $duraltag2->setType(2);

        $duraltag = new Duraltag();
        $duraltag->setQrCode('QRCODE');
        $duraltag->setRfid('RFID');
        $duraltag->setRetailer($retailer);
        $duraltag->setType(2);

        $this->manager->persist($duraltag);

        $this->manager->persist($duraltag2);

        $itemAssociation = new ItemAssociation();
        $itemAssociation->setEan('EAN');
        $itemAssociation->setStatus(1);
        $itemAssociation->setDuraltag($duraltag);

        $this->manager->persist($itemAssociation);
        $this->manager->flush();
    }

    /**
     * @Given A user :username with password :password exists
     */
    public function aUserWithAPasswordExists($username, $password)
    {
        $this->createUser($username, $password);
    }

    /**
     * @Given I am authenticated
     */
    public function iAmAuthenticated()
    {
        $this->createUser('authenticateduser', 'p4ssw0rd', true);

        $session = $this->getSession();
        $client = $session->getDriver()->getClient();
        $client->request('POST', '/api/login_check', [
            'username' => 'authenticateduser',
            'password' => 'p4ssw0rd',
        ]);

        $token = json_decode($session->getPage()->getContent(), true)['token'];

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));
    }

    /**
     * Creates a user in database.
     *
     * @param string $username
     * @param string $password
     */
    private function createUser($username, $password, $admin = true)
    {
        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setPlainPassword($password);
        $user->setEmail(sprintf('%s@example.com', $username));
        $user->setEnabled(true);
        if ($admin) {
            $user->addRole('ROLE_ADMIN');
        }

        $this->userManager->updateUser($user);
    }
}
