<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializerBuilder;
use AppBundle\Service\ContactService;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

/**
 * Class ApiController
 *
 * @package AppBundle\Controller
 */
class ApiController extends FOSRestController
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Get Contact",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the request has errors"
     *   }
     * )
     *
     * @Rest\Get("/contatos")
     *
     * @return JsonResponse
     */
    public function getContactAction()
    {
	    try {
		    /* @var $contactService ContactService */
		    $contactService= $this->get(ContactService::class);

		    $contacts = $contactService->getContacts();
		    $encoders = array(new JsonEncoder());
		    $normalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());
		    $serializer = new Serializer($normalizers, $encoders);
		    $contacts = $serializer->serialize($contacts, 'json');

		    return new JsonResponse(array(
			    'code' => 200,
			    'status' => 'success',
			    'message' => 'Get contacts success.',
			    'data' => json_decode($contacts),
		    ), 200);
	    } catch (\Exception $e) {
		    return new JsonResponse(array(
			    'code' => 500,
			    'status' => 'error',
			    'message' => $e->getMessage(),
		    ), 500);
	    }
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Insert new contact.",
     *   input = {
     *     "class" = "AppBundle\Entity\Validate\ContactValidate",
     *     "parsers" = {
     *       "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
     *     }
     *   },
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     400 = "Returned when the request has errors"
     *   }
     * )
     *
     * @Rest\Post("/contatos")
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function postContactAction(Request $request)
    {
        try {
            // Deserialize the request data
            $serializer = SerializerBuilder::create()->build();
            $contact = $serializer
                ->deserialize($request->getContent(), 'AppBundle\Entity\Validate\ContactValidate', 'json');

            // Validate the request data
            $validator = $this->get('validator');
            $errors = $validator->validate($contact);
	        if (count($errors) > 0) {
		        $errorsValidate = [];
		        foreach ($errors as $error) {
			        $errorsValidate[] = $error->getMessage();
		        }
	            throw new \Exception(implode(';', $errorsValidate));
	        }

            /* @var $contactService ContactService */
            $contactService= $this->get(ContactService::class);

	        $contactId = $contactService->insertContacts($contact);

            return new JsonResponse(array(
	            'code' => 200,
	            'status' => 'success',
	            'message' => 'Success contact create.',
	            'data' => $contactId,
            ), 200);
        } catch (\Exception $e) {
            return new JsonResponse(array(
                'code' => 500,
                'status' => 'error',
                'message' => $e->getMessage(),
            ), 500);
        }
    }

	/**
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Update contact.",
	 *   input = {
	 *     "class" = "AppBundle\Entity\Validate\Update\UpdateContactValidate",
	 *     "parsers" = {
	 *       "Nelmio\ApiDocBundle\Parser\JmsMetadataParser"
	 *     }
	 *   },
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     400 = "Returned when the request has errors"
	 *   }
	 * )
	 *
	 * @Rest\Put("/contatos/{contactId}", requirements={"contactId"="\d+"}, defaults={"contactId" = 0})
     * @param integer $contactId
     *
     * @return JsonResponse
     */
    public function putContactAction($contactId, Request $request )
    {
        try {
	        // Deserialize the request data
	        $serializer = SerializerBuilder::create()->build();
	        $contact = $serializer
		        ->deserialize($request->getContent(), 'AppBundle\Entity\Validate\ContactValidate', 'json');

	        // Validate the request data
	        $validator = $this->get('validator');
	        $errors = $validator->validate($contact);
	        if (count($errors) > 0) {
		        $errorsValidate = [];
		        foreach ($errors as $error) {
			        $errorsValidate[] = $error->getMessage();
		        }
		        throw new \Exception(implode(';', $errorsValidate));
	        }

	        /* @var $contactService ContactService */
	        $contactService= $this->get(ContactService::class);

	        $contactService->updateContacts($contact, $contactId);

	        return new JsonResponse(array(
		        'code' => 200,
		        'status' => 'success',
		        'message' => 'Success contact update.',
		        'data' => $contactId,
	        ), 200);
        } catch (\Exception $e) {
	        return new JsonResponse(array(
		        'code' => 500,
		        'status' => 'error',
		        'message' => $e->getMessage(),
	        ), 500);
        }
    }

	/**
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Delete contact.",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     400 = "Returned when the request has errors"
	 *   }
	 * )
	 *
	 * @Rest\Delete("/contatos/{contactId}", requirements={"contactId"="\d+"}, defaults={"contactId" = 0})
	 * @param integer $contactId
	 *
	 * @return JsonResponse
	 */
	public function deleteContactAction($contactId)
	{
		try {
			/* @var $contactService ContactService */
			$contactService= $this->get(ContactService::class);

			$contactService->disabledContact($contactId);

			return new JsonResponse(array(
				'code' => 200,
				'status' => 'success',
				'message' => 'Success contact update.',
				'data' => $contactId,
			), 200);
		} catch (\Exception $e) {
			return new JsonResponse(array(
				'code' => 500,
				'status' => 'error',
				'message' => $e->getMessage(),
			), 500);
		}
	}
}
