<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Description of AgentController
 */
class AgentController extends Controller
{
    /**
     * @Route("/agent/list", name="agents_list")
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function listAction(Request $request)
    {
//        if(!$this->get('security.authorization_checker')->isGranted('ROLE_MANAGER')) {
//            throw $this->createAccessDeniedException();
//        }
        
        $agents = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:UserDetailsAgent')
                    ->getAgents( $this->getUser() );
        
        return  $this->render('agent/list.html.twig', [
            'agents' => $agents
        ]);
    }
}
