<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ingredients
 *
 * @ORM\Table(name="ingredients")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IngredientsRepository")
 */
class Ingredients
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="ingredient", type="string", length=255)
     *
     */
    private $ingredient;


    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="ingredients")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     */
    private $recipe;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ingredient.
     *
     * @param string $ingredient
     *
     * @return Ingredients
     */
    public function setIngredient($ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient.
     *
     * @return string
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }
}
