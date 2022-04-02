<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('home.html.twig');
        // $number = random_int(0, 100);
        // return $this->render('home.html.twig', [
        //     'number' => $number,
        // ]);
    }
    /**
     * @Route("/about", name="about")
     */
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }
    /**
     * @Route("/report", name="report")
     */
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    /**
     * @Route("/debug", name="debug")
     */
    public function debug(): Response
    {
        // Här kan vi testa kod:

        $data = [
            'message' => 'Welcome to the lucky number API',
            'number' => random_int(0, 100)
        ];

        return $this->render('debug.html.twig', $data);
    }
}
