<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MetricsController extends AbstractController
{

    /**
     * @Route("/metrics", name="metrics"), methods={"GET","HEAD"})
     */
    public function index(): Response
    {
        return $this->render('metrics/index.html.twig');
    }

}
