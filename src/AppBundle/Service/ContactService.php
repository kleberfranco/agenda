<?php

namespace AppBundle\Service;

use Symfony\Bridge\Monolog\Logger;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Database\Contact;

class ContactService
{
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * ContactService constructor.
     * @param EntityManager $entityManager
     * @param Logger $logger
     */
    public function __construct(EntityManager $entityManager, Logger $logger)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
    }

    /**
     * @param $contact
     *
     * @return mixed
     */
    public function insert($contact)
    {
        $contacts = new Contact();
        $contacts->setName($contact->name);
        $contacts->setPhone($contact->phone);
        $contacts->setEmail($contact->email);

        $this->entityManager->persist($contacts);
        $this->entityManager->flush();

        return $contacts->getContactid();
    }

    /**
     * @param $contact
     * @param $contactId
     * @return mixed
     */
    public function update($contact, $contactId)
    {
        $contacts = new Contact();
        $contacts->setName($contact->name);
        $contacts->setPhone($contact->phone);
        $contacts->setEmail($contact->email);

        $this->entityManager->persist($contacts);
        $this->entityManager->flush();

        return $contacts->getContactid();
    }
}
