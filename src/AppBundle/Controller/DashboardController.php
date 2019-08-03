<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\ChoiceList\ORMQueryBuilderLoader;
use AppBundle\Entity\Plan;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipePlan;

/**
 * @Route("/main")
 */
class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard_index")
     */
    public function indexAction(): Response
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $repository = $em->getRepository('AppBundle:Plan');
        $plan = $repository->findAll();
        $noPlans = count($plan);
        
        $repository2 = $em->getRepository('AppBundle:Recipe');
        $recipe = $repository2->findAll();
        $noRecipes = count($recipe);
        
        //last Plan Name
        $query = $em->createQuery('SELECT p FROM AppBundle\Entity\Plan p ORDER BY p.created DESC');
        $plans = $query->getResult();
        $lastPlanId = $plans[0]->getId();
        $lastPlanName = $plans[0]->getName();
        
        
        return $this->render('dashboard/index.html.twig', [
            'noPlans' => $noPlans,
            'noRecipes' => $noRecipes,
            'lastPlanName' => $lastPlanName]);
    }
    
    /**
     * @Route("/lastPlan")
     */
    public function lastPlanAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT p FROM AppBundle\Entity\Plan p ORDER BY p.created DESC');
        $plans = $query->getResult();
        $lastPlanId = $plans[0]->getId();
        $lastPlanName = $plans[0]->getName();
        
        $recipeplan = $plans[0]->getRecipePlans();
        
        $query = $em->createQuery
        ('SELECT rp FROM AppBundle\Entity\RecipePlan rp  JOIN rp.plan p WHERE p.id=4');
        //('SELECT rp FROM AppBundle\Entity\RecipePlan rp  JOIN rp.plan p WHERE p.id=4');
        $rp = $query->getResult();
        
        $query2 = $em->createQuery
        ('SELECT  (rp.dayName), count(rp.dayName) FROM AppBundle\Entity\RecipePlan rp  JOIN rp.plan p WHERE p.id=4 group by rp.dayName');
        
        
        $res = $query2->getResult();
        var_dump($res);
        //var_dump($res[0]);
        //id day name        // count of id day name
        // echo $res[0][1].'->'.$res[1][1];echo'<br>';
        // echo $res[0][2].'->'.$res[1][2];
        //var_dump($rp);
        //var_dump($rp[5]->getDayName()->getId());
        
        
        // echo$rp[$b]->getDayName()->getDayName();echo'<br>';
        
        for ($a = 0; $a < count($res); $a++) // petla pocalym result
        {
           
            
            $id_day = $res[$a][1];
            $licznik = $res[$a][2];
            echo 'id_day=' . $id_day . 'licznik='.$licznik.' <br>'; //to jest id_day
    
            for($x=0;$x<count($rp);$x++) {
                if ($id_day == $rp[$x]->getDayName()->getId()) {
                    echo $rp[$x]->getDayName()->getDayName();break;
                }
            }
            //wypisujemy naglowek
           
           
            for ($b = 0; $b < count($rp); $b++)
            {
                if ($id_day == $rp[$b]->getDayName()->getId()) {
                    //echo $rp[$b]->getDayName()->getDayName();
                    echo '<br>';
                    echo $rp[$b]->getMealName();
                    echo ' - ';
                    echo $rp[$b]->getRecipe()->getName();
                    echo '<br>';
                }
                
                
            }
        }
        
        
        
        
        return $this->render('dashboard/test.html.twig', ['lastplan' => $plans[0],
                'rp' => $rp,
                'res' =>$res]
        );
        
        
    }
}
