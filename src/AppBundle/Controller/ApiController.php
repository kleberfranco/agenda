<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\JsonResponse;

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
	 * @Rest\Get("/contatos/")
	 *
	 * @return JsonResponse
	 */
	public function getContactAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

	/**
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Insert new contact ",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     400 = "Returned when the request has errors"
	 *   }
	 * )
	 *
	 * @Rest\Post("/contatos/")
	 *
	 * @return JsonResponse
	 */
	public function postContactAction($cteKey)
	{
		try {
			return new JsonResponse(array(
				'code' => 200,
				'status' => 'success',
				'message' => 'Error contact create.',
			), 500);
		} catch (\Exception $e) {
			return new JsonResponse(array(
				'code' => 500,
				'status' => 'error',
				'message' => 'Error contact create.',
			), 500);
		}
	}

	/**
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Updated contact",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     400 = "Returned when the request has errors"
	 *   }
	 * )
	 *
	 * @Rest\Put("/contatos/{contactId}")
	 * @param string $contactId
	 *
	 * @return JsonResponse
	 */
	public function putContactAction($contactId)
	{
		try {
			return new JsonResponse(array(
				'code' => 200,
				'status' => 'success',
				'message' => 'Error contact update.',
			), 500);
		} catch (\Exception $e) {
			return new JsonResponse(array(
				'code' => 500,
				'status' => 'error',
				'message' => 'Error contact update.',
			), 500);
		}
	}

	/**
	 * @ApiDoc(
	 *   resource = true,
	 *   description = "Delete contact",
	 *   statusCodes = {
	 *     200 = "Returned when successful",
	 *     400 = "Returned when the request has errors"
	 *   }
	 * )
	 *
	 * @Rest\Delete("/contatos/{contactId}")
	 * @param string $contactId
	 *
	 * @return JsonResponse
	 */
	public function deleteContactAction($contactId)
	{
		try {
			return new JsonResponse(array(
				'code' => 200,
				'status' => 'success',
				'message' => 'Error contact delete.',
			), 500);
		} catch (\Exception $e) {
			return new JsonResponse(array(
				'code' => 500,
				'status' => 'error',
				'message' => 'Error contact delete.',
			), 500);
		}
	}
}
