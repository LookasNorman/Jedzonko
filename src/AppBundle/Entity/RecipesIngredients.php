<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipesIngredients
 *
 * @ORM\Table(name="recipes_ingredients")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipesIngredientsRepository")
 */
class RecipesIngredients
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
//
//    /**
//     *  @ORM\ManyToOne(targetEntity="Recipe", inversedBy="recipesIngredients")
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $recipe;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="Ingredients", inversedBy="recipesIngredients")
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $ingredient;
//
//    /**
//     * @var string
//     *
//     * @ORM\Column(name="quantity", type="string", length=255)
//     */
//    private $quantity;
//
//
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
//
//    /**
//     * Set recipe.
//     *
//     * @param int $recipe
//     *
//     * @return RecipesIngredients
//     */
//    public function setRecipe($recipe)
//    {
//        $this->recipe = $recipe;
//
//        return $this;
//    }
//
//    /**
//     * Get recipe.
//     *
//     * @return int
//     */
//    public function getRecipe()
//    {
//        return $this->recipe;
//    }
//
//    /**
//     * Set ingredient.
//     *
//     * @param int $ingredient
//     *
//     * @return RecipesIngredients
//     */
//    public function setIngredient($ingredient)
//    {
//        $this->ingredient = $ingredient;
//
//        return $this;
//    }
//
//    /**
//     * Get ingredient.
//     *
//     * @return int
//     */
//    public function getIngredient()
//    {
//        return $this->ingredient;
//    }
//
//    /**
//     * Set quantity.
//     *
//     * @param string $quantity
//     *
//     * @return RecipesIngredients
//     */
//    public function setQuantity($quantity)
//    {
//        $this->quantity = $quantity;
//
//        return $this;
//    }
//
//    /**
//     * Get quantity.
//     *
//     * @return string
//     */
//    public function getQuantity()
//    {
//        return $this->quantity;
//    }
}
