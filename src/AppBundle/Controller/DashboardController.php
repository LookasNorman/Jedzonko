<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\ChoiceList\ORMQueryBuilderLoader;
use AppBundle\Entity\Plan;
use AppBundle\Entity\Recipe;

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
        $lastPlanId=$plans[0]->getId();
        $lastPlanName=$plans[0]->getName();
        
        
        return $this->render('dashboard/index.html.twig', [
            'noPlans' => $noPlans,
            'noRecipes'=>$noRecipes,
            'lastPlanName'=>$lastPlanName]);
    }
    
    /**
     * @Route("/lastPlan")
     */
    public function lastPlanAction():Response
    {
        $em=$this->getDoctrine()->getManager();
        //$query = $em->createQuery('SELECT u FROM MyProject\Model\User u WHERE u.age > 20');
        $query = $em->createQuery('SELECT p FROM AppBundle\Entity\Plan p ORDER BY p.created DESC');
        $plans = $query->getResult();
        $lastPlanId=$plans[0]->getId();
        $lastPlanName=$plans[0]->getName();
        
        var_dump($recentPlanName);
        
        return new Response();
    }
    
}
