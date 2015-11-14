<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of AgreementEstate
 *
 * @ORM\Entity
 */
class AgreementEstate extends Agreement
{
    /**
     * @var string
     *
     * @ORM\Column(name="estate", type="string", length=255)
     */
    private $estate;

    /**
     * Set estate
     *
     * @param string $estate
     *
     * @return AgreementEstate
     */
    public function setEstate($estate)
    {
        $this->estate = $estate;

        return $this;
    }

    /**
     * Get estate
     *
     * @return string
     */
    public function getEstate()
    {
        return $this->estate;
    }
}
