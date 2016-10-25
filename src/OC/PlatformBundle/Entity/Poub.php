<?php

namespace OC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Poub
 *
 * @ORM\Table(name="poub")
 * @ORM\Entity(repositoryClass="OC\PlatformBundle\Repository\PoubRepository")
 */
class Poub
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="mem", type="integer")
     */
    private $mem;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mem
     *
     * @param integer $mem
     *
     * @return Poub
     */
    public function setMem($mem)
    {
        $this->mem = $mem;

        return $this;
    }

    /**
     * Get mem
     *
     * @return int
     */
    public function getMem()
    {
        return $this->mem;
    }
    
      /**
     * 
     *
     * @ORM\Column(type="integer")
         */
    private $poub1;

    /**
     * Set poub1
     *
     * @param integer $poub1
     *
     * @return Poub
     */
    public function setPoub1($poub1)
    {
        $this->poub1 = $poub1;

        return $this;
    }

    /**
     * Get poub1
     *
     * @return integer
     */
    public function getPoub1()
    {
        return $this->poub1;
    }
}
