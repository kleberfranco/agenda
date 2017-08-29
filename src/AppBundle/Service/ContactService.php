<?php

namespace AppBundle\Service;

use Symfony\Bridge\Monolog\Logger;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Database\Contact;
use AppBundle\Entity\Validate\ContactValidate;

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
	 * @param ContactValidate $contact
	 *
	 * @return mixed
	 * @throws \Exception
	 */
    public function insertContacts(ContactValidate $contact)
    {
    	try {
		    $checkPhone = $this->entityManager
			    ->getRepository(Contact::class)->findOneBy( array('phone' => $contact->getPhone()));

		    if (!empty($checkPhone)) {
			    throw new \Exception('Phone duplicated.');
		    }
		    $contacts = new Contact();
		    $contacts->setName($contact->getName());
		    $contacts->setPhone($contact->getPhone());
		    $contacts->setEmail($contact->getEmail());

		    $this->entityManager->persist($contacts);
		    $this->entityManager->flush();

		    return $contacts->getContactid();
	    } catch (\Exception $e) {
    		throw $e;
	    }
    }

	/**
	 * @param ContactValidate $contact
	 * @param $contactId
	 *
	 * @return mixed
	 * @throws \Exception
	 */
    public function updateContacts(ContactValidate $contact, $contactId)
    {
	    try {
		    $contacts = $this->entityManager
			    ->getRepository(Contact::class)->find($contactId);

		    if (empty($contacts)) {
		        throw new \Exception('No find contact');
		    }
		    $contacts->setName($contact->getName());
		    $contacts->setPhone($contact->getPhone());
		    $contacts->setEmail($contact->getEmail());
		    if (!empty($contact->getStatus())) {
			    $contacts->setStatus($contact->getStatus());
		    }

		    $this->entityManager->persist($contacts);
		    $this->entityManager->flush();

	        return $contacts->getContactid();
	    } catch (\Exception $e) {
		    throw $e;
	    }
    }

	/**
	 * @return array
	 */
    public function getContacts() {
	    return $this->entityManager->getRepository(Contact::class)
	                     ->findAll();
	}

	/**
	 * @param $contactId
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function disabledContact($contactId)
	{
		try {
			$contacts = $this->entityManager
				->getRepository(Contact::class)->find($contactId);

			if (empty($contacts)) {
				throw new \Exception('No find contact');
			}
			$contacts->setStatus('I');
			$this->entityManager->persist($contacts);
			$this->entityManager->flush();

			return $contacts->getContactid();
		} catch (\Exception $e) {
			throw $e;
		}
	}
}
