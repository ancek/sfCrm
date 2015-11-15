<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Description of AgreementLifeController
 * 
 * @Route('agreement/life')
 */
class AgreementLifeController extends Controller
{
    public function listAction()
    {
        //HOMEWORK
    }
    
    /**
     * @Route("/add", name="agreement_life_add")
     * @Security("has_role('ROLE_AGENT')")
     */
    public function addAction(Request $request) 
    {
        return $this->render('agreementLife\add.html.twig', [
            
        ]);
    }
}
