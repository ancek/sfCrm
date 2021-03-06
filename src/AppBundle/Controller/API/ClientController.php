<?php
namespace AppBundle\Controller\API;
use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Form\UserDetailsClientType;
use AppBundle\Entity\UserDetailsClient;
use Symfony\Component\HttpFoundation\Request;
/**
 * ClientController
 */
class ClientController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @ApiDoc(
     *  section="Client",
     *  resource = true,
     *  description = "Gets all Client",
     *  output = "AppBundle\Entity\UserDetailsClient",
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      403 = "Not authorized"
     *  }
     * )
     * 
     * @return UserDetails
     */
    public function cgetAction()
    {
        $clients = $this->getDoctrine()
            ->getRepository('AppBundle:UserDetailsClient')
            ->findAll();
        $view = $this->view($clients, 200);
        return $this->handleView($view);
    }
    /**
     * @ApiDoc(
     *  section="Client",
     *  resource = true,
     *  description = "Get Client by given id",
     *  output = "AppBundle\Entity\UserDetailsClient",
     *  statusCodes = {
     *      200 = "Returned when successful",
     *      403 = "Not authorized",
     *      404 = "Not found"
     *  }
     * )
     * 
     * @return UserDetails
     */
    public function getAction($id)
    {
        $client = $this->getDoctrine()
            ->getRepository('AppBundle:UserDetailsClient')
            ->findOneBy([
            'id' => $id
        ]);
        if (!$client) {
            throw new NotFoundHttpException();
        }
        $view = $this->view($client, 200);
        return $this->handleView($view);
    }
    /**
     * @ApiDoc(
     *  section="Client",
     *  resource = true,
     *  description = "Add new Client",
     *  output = "AppBundle\Entity\UserDetailsClient",
     *  input = "AppBundle\Form\UserDetailsClientType",
     *  statusCodes = {
     *      201 = "Returned when successful",
     *      403 = "Not authorized",
     *      400 = "Form error"
     *  }
     * )
     *
     * @return UserDetails
     */
    public function postAction(Request $request)
    {
        $client = new UserDetailsClient();
        $form = $this->createForm(new UserDetailsClientType(), $client);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            $view = $this->view($client, 201);
            return $this->handleView($view);
        }
        throw new \Exception('form error', 400);
    }
    /**
     * @ApiDoc(
     *  section="Client",
     *  resource = true,
     *  description = "Update Client by given id",
     *  output = "AppBundle\Entity\UserDetailsClient",
     *  input = "AppBundle\Form\UserDetailsClientType",
     *  statusCodes = {
     *      201 = "Returned when successful",
     *      403 = "Not authorized",
     *      400 = "Form error",
     *      404 = "Not found"
     *  }
     * )
     *
     * @return UserDetails
     */
    public function putAction($id, Request $request)
    {
        $client = $this->getDoctrine()
            ->getRepository('AppBundle:UserDetailsClient')
            ->findOneBy([
            'id' => $id
        ]);
        if (!$client) {
            throw new NotFoundHttpException();
        }
        $form = $this->createForm(new UserDetailsClientType(), $client);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            $view = $this->view($client, 200);
            return $this->handleView($view);
        }
        throw new \Exception('form error', 400);
    }
    /**
     * @ApiDoc(
     *  section="Client",
     *  resource = true,
     *  description = "Delete Client by given id",
     *  statusCodes = {
     *      204 = "Returned when successful",
     *      403 = "Not authorized",
     *      404 = "Not found"
     *  }
     * )
     *  @param int $id User id
     * 
     * @return UserDetails
     */
    public function deleteAction($id)
    {
        $client = $this->getDoctrine()
            ->getRepository('AppBundle:UserDetailsClient')
            ->findOneBy([
                'id' => $id
            ]
        );
        if (!$client) {
            throw new NotFoundHttpException();
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($client);
        $em->flush();
        $view = $this->view('', 204);
        return $this->handleView($view);
    }
}