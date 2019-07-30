<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipePlan
 *
 * @ORM\Table(name="recipe_plan")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipePlanRepository")
 */
class RecipePlan
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
     * @ORM\Column(name="meal_name", type="string", length=255)
     */
    private $mealName;

    /**
     * @var int
     *
     * @ORM\Column(name="meal_order", type="integer")
     */
    private $mealOrder;


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
     * Set mealName
     *
     * @param string $mealName
     *
     * @return RecipePlan
     */
    public function setMealName($mealName)
    {
        $this->mealName = $mealName;

        return $this;
    }

    /**
     * Get mealName
     *
     * @return string
     */
    public function getMealName()
    {
        return $this->mealName;
    }

    /**
     * Set mealOrder
     *
     * @param integer $mealOrder
     *
     * @return RecipePlan
     */
    public function setMealOrder($mealOrder)
    {
        $this->mealOrder = $mealOrder;

        return $this;
    }

    /**
     * Get mealOrder
     *
     * @return int
     */
    public function getMealOrder()
    {
        return $this->mealOrder;
    }
}

