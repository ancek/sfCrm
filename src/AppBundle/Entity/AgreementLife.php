<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of AgreementLife
 *
 * @ORM\Entity
 */
class AgreementLife extends Agreement
{
    /**
     * @var string
     *
     * @ORM\Column(name="person", type="string", length=100)
     */
    private $person;

    /**
     * Set person
     *
     * @param string $person
     *
     * @return AgreementLife
     */
    public function setPerson($person)
    {
        $this->person = $person;

        return $this;
    }

    /**
     * Get person
     *
     * @return string
     */
    public function getPerson()
    {
        return $this->person;
    }
}
