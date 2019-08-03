<?php

namespace AppBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * Ingredients
 *
 * @ORM\Table(name="ingredients")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IngredientsRepository")
 */
class Ingredients
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="ingredient", type="string", length=255)
     *
     */
    private $ingredient;


    /**
     * @ManyToMany(targetEntity="Recipe", mappedBy="ingredients")
     */
    private $recipes;


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


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add recipe.
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return Ingredients
     */
    public function addRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        $this->recipes[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe.
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        return $this->recipes->removeElement($recipe);
    }

    /**
     * Get recipes.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipes()
    {
        return $this->recipes;
    }
}
