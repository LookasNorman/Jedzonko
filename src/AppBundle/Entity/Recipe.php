<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ManyToMany;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Recipe
 *
 * @UniqueEntity(
 *     fields={"name"}, message="Recipe name alredy exist"
 * )
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeRepository")
 */
class Recipe
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="RecipePlan", mappedBy="recipe")
     */
    private $recipePlans;

//    /**
//     * @ORM\OneToMany(targetEntity="RecipesIngredients", mappedBy="recipe")
//     */
//    private $recipesIngredients;

    /**
     * @var string
     *
     * @ORM\Column(name="ingredients", type="text")
     */
    private $ingredients;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;


    /**
     * @ORM\Column(name ="preparation_method", type="text")
     */
    private $recipePreparationMethod;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetimetz")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetimetz", nullable=true)
     */
    private $updated;

    /**
     * @var int
     *
     * @ORM\Column(name="preparation_time", type="integer")
     */
    private $preparationTime;

    /**
     * @var int
     *
     * @ORM\Column(name="votes", type="integer", nullable=true)
     */
    private $votes;


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
     * Set name.
     *
     * @param string $name
     *
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Recipe
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set recipePreparationMethod.
     *
     * @param string $recipePreparationMethod
     *
     * @return Recipe
     */
    public function setRecipePreparationMethod($recipePreparationMethod)
    {
        $this->recipePreparationMethod = $recipePreparationMethod;

        return $this;
    }

    /**
     * Get recipePreparationMethod.
     *
     * @return string
     */
    public function getRecipePreparationMethod()
    {
        return $this->recipePreparationMethod;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Recipe
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime|null $updated
     *
     * @return Recipe
     */
    public function setUpdated($updated = null)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime|null
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set preparationTime.
     *
     * @param int $preparationTime
     *
     * @return Recipe
     */
    public function setPreparationTime($preparationTime)
    {
        $this->preparationTime = $preparationTime;

        return $this;
    }

    /**
     * Get preparationTime.
     *
     * @return int
     */
    public function getPreparationTime()
    {
        return $this->preparationTime;
    }

    /**
     * Set votes.
     *
     * @param int|null $votes
     *
     * @return Recipe
     */
    public function setVotes($votes = null)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * Get votes.
     *
     * @return int|null
     */
    public function getVotes()
    {
        return $this->votes;
    }

    /**
     * Add recipePlan.
     *
     * @param \AppBundle\Entity\RecipePlan $recipePlan
     *
     * @return Recipe
     */
    public function addRecipePlan(\AppBundle\Entity\RecipePlan $recipePlan)
    {
        $this->recipePlans[] = $recipePlan;

        return $this;
    }

    /**
     * Remove recipePlan.
     *
     * @param \AppBundle\Entity\RecipePlan $recipePlan
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeRecipePlan(\AppBundle\Entity\RecipePlan $recipePlan)
    {
        return $this->recipePlans->removeElement($recipePlan);
    }

    /**
     * Get recipePlans.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipePlans()
    {
        return $this->recipePlans;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipePlans = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created = new \DateTime();
    }

    /**
     * Set ingredients.
     *
     * @param string $ingredients
     *
     * @return Recipe
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * Get ingredients.
     *
     * @return string
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param mixed $recipePlans
     */
    public function addRecipePlans($recipePlans)
    {
        $this->recipePlans[] = $recipePlans;
    }
}
