<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Form\UserDetailsClientType;
use AppBundle\Entity\UserDetailsClient;

/**
 * Description of ClientController
 */
class ClientController extends Controller
{
    /**
     * @Route("/client", name="agents_list")
     * @Security("has_role('ROLE_AGENT')")
     */
    public function listAction()
    {
        $clients = $this->getDoctrine()
                ->getRepository('AppBundle:UserDetailsClient')
                ->findAll();
        
        return $this->render('client/list.html.twig', [
           'clients' => $clients, 
        ]);
    }
    
    /**
     * @Route("/client/add", name="client_add")
     * @Security("has_role('ROLE_AGENT')")
     */
    public function addAction(Request $request)
    {
        $client = new UserDetailsClient();
        
        $form = $this->createForm(new UserDetailsClientType(), $client);
        $form->handleRequest($request);
        
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
                    
            $em->persist($client);
            $em->flush();
            
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('client/add.html.twig', [
           'form' => $form->createView(), 
        ]);
    }
}
