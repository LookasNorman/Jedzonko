<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DayName
 *
 * @ORM\Table(name="day_name")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DayNameRepository")
 */
class DayName
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
     * @var string
     *
     * @ORM\Column(name="day_name", type="string", length=16)
     */
    private $dayName;


    /**
     * @ORM\OneToMany(targetEntity="RecipePlan", mappedBy="dayName")
     */
    private $recipePlans;


    /**
     * @var int
     *
     * @ORM\Column(name="day_order", type="integer")
     */
    private $dayOrder;


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
     * Set dayName
     *
     * @param string $dayName
     *
     * @return DayName
     */
    public function setDayName($dayName)
    {
        $this->dayName = $dayName;

        return $this;
    }

    /**
     * Get dayName
     *
     * @return string
     */
    public function getDayName()
    {
        return $this->dayName;
    }

    /**
     * Set dayOrder
     *
     * @param integer $dayOrder
     *
     * @return DayName
     */
    public function setDayOrder($dayOrder)
    {
        $this->dayOrder = $dayOrder;

        return $this;
    }

    /**
     * Get dayOrder
     *
     * @return int
     */
    public function getDayOrder()
    {
        return $this->dayOrder;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipePlans = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add recipePlan
     *
     * @param \AppBundle\Entity\RecipePlan $recipePlan
     *
     * @return DayName
     */
    public function addRecipePlan(\AppBundle\Entity\RecipePlan $recipePlan)
    {
        $this->recipePlans[] = $recipePlan;

        return $this;
    }

    /**
     * Remove recipePlan
     *
     * @param \AppBundle\Entity\RecipePlan $recipePlan
     */
    public function removeRecipePlan(\AppBundle\Entity\RecipePlan $recipePlan)
    {
        $this->recipePlans->removeElement($recipePlan);
    }

    /**
     * Get recipePlans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipePlans()
    {
        return $this->recipePlans;
    }

    /**
     * @param mixed $recipePlans
     */
    public function addRecipePlans($recipePlans)
    {
        $this->recipePlans[] = $recipePlans;
    }


}
