<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Description of AgentController
 */
class AgentController extends Controller
{
    /*
     * @Route("/agent/list", name="agents_list")
     * @Security("ROLE_ADMIN, ROLE_MANAGER")
     */
    public function listAction(Request $request)
    {
        $agents = $this
                    ->getDoctrine()
                    ->getRepository('AppBundle:UserDetailsAgent')
                    ->getAgents( $this->getUser() );
    }
}
