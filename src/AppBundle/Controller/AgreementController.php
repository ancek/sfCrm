<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Agreement;

/**
 * Description of AgreementController
 */
class AgreementController extends Controller
{
    public function showAction(Agreement $agreement)
    {
        return $this->render('agreement/show.html.twig', [
            'agreement' => $agreement
        ]);
    }
    
}
