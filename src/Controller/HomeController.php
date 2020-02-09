<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home_page")
     * Route chargeant le template de la home page
     */
    public function homepage()
    {
        return $this->render('home/home.html.twig');
    }
}
