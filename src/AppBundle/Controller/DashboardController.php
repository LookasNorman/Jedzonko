<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\ChoiceList\ORMQueryBuilderLoader;
use AppBundle\Entity\Plan;
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
        $plan=$repository->findAll();
        $noPlans=count($plan);
        
        return $this->render('dashboard/index.html.twig', ['noPlans'=>$noPlans]);
    }
}
