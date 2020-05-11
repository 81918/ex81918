<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use App\Entity\Land;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PouleRepository")
 * @ORM\Table(name="app_poule")
 */
class Poule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $naam;

    /**
     * @ManyToOne(targetEntity="Land")
     * @JoinColumn(name="land1_id", referencedColumnName="id")
     */
    private $land1;

    /**
     * @ManyToOne(targetEntity="Land")
     * @JoinColumn(name="land2_id", referencedColumnName="id")
     */
    private $land2;

    /**
     * @ManyToOne(targetEntity="Land")
     * @JoinColumn(name="land3_id", referencedColumnName="id")
     */
    private $land3;

    /**
     * @ManyToOne(targetEntity="Land")
     * @JoinColumn(name="land4_id", referencedColumnName="id")
     */
    private $land4;

    /**
     * Many User have Many Phonenumbers.
     * @ManyToMany(targetEntity="Land")
     * @JoinTable(name="poule_land",
     *      joinColumns={@JoinColumn(name="poule_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="land_id", referencedColumnName="id", unique=true)}
     *      )
     */
    private $poule_land;

    public function __construct()
    {
        $this->poule_land = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLand1()
    {
        return $this->land1;
    }

    /**
     * @param mixed $land1
     */
    public function setLand1($land1): void
    {
        $this->land1 = $land1;
    }

    /**
     * @return mixed
     */
    public function getLand2()
    {
        return $this->land2;
    }

    /**
     * @param mixed $land2
     */
    public function setLand2($land2): void
    {
        $this->land2 = $land2;
    }

    /**
     * @return mixed
     */
    public function getLand3()
    {
        return $this->land3;
    }

    /**
     * @param mixed $land3
     */
    public function setLand3($land3): void
    {
        $this->land3 = $land3;
    }

    /**
     * @return mixed
     */
    public function getLand4()
    {
        return $this->land4;
    }

    /**
     * @param mixed $land4
     */
    public function setLand4($land4): void
    {
        $this->land4 = $land4;
    }


    public function getPouleLand(): ArrayCollection
    {
        return $this->poule_land;
    }
}
