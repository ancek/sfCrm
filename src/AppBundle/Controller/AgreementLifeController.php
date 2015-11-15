<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AgreementLife;
use AppBundle\Entity\Attachment;
use AppBundle\Form\AgreementLifeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Description of AgreementLifeController
 * 
 * @Route("agreement/life")
 */
class AgreementLifeController extends Controller
{
    public function listAction()
    {
        //HOMEWORK
    }
    
    /**
     * @Route("/add", name="agreement_life_add")
     * @Security("has_role('ROLE_MANAGER')")
     */
    public function addAction(Request $request) 
    {
        $agreement = new AgreementLife();
        $attachment = new Attachment();
        $agreement->addAttachment($attachment);
        
        $user = $this->getUser();
        
        $form = $this->createForm(new AgreementLifeType($this->getUser()), $agreement);
        
        $form->handleRequest($request);
        if($form->isValid()) {
            
            if(!$user->hasRole('ROLE_MANAGER')) {
                $agreement->setAgent($user->getDetails());
            }
            
            $agreement->setNumber('temp');
            
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($agreement);
            $em->flush();
            
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('agreementLife\add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
