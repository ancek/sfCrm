<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of AgreementVehicle
 *
 * @ORM\Entity
 */
class AgreementVehicle extends Agreement
{
    /**
     * @var string
     *
     * @ORM\Column(name="vehicle", type="string", length=255)
     */
    private $vehicle;

    /**
     * Set vehicle
     *
     * @param string $vehicle
     *
     * @return AgreementVehicle
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle
     *
     * @return string
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }
}
