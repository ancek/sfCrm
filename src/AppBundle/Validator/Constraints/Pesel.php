<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Description of Pesel
 */
class Pesel extends Constraint
{
    public $message = 'peselerror';
    
    public function validateBy()
    {
        return 'validator_pesel';
    }
}
