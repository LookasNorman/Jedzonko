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
    
    //last plan details
        $query = $em->createQuery
        ('SELECT rp FROM AppBundle\Entity\RecipePlan rp  JOIN rp.plan p WHERE p.id=4 order by rp.mealOrder,rp.dayName');
        $rp = $query->getResult();
    
        $query2 = $em->createQuery
        ('SELECT  (rp.dayName), count(rp.dayName) FROM AppBundle\Entity\RecipePlan rp  JOIN rp.plan p
        WHERE p.id=4 group by rp.dayName');
    
        $res = $query2->getResult();
        
        return $this->render('dashboard/index.html.twig', [
            'noPlans' => $noPlans,
            'noRecipes' => $noRecipes,
            'lastPlanName' => $lastPlanName,
            'rp' => $rp,
            'res' =>$res
            ]);
    }
    
    
        
    }

