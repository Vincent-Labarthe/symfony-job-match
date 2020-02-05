<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UserController extends AbstractController
{
    /**
     * @Route("/applicant/login", name="applicant_login")
     */
    public function candidateLogin(){
        return $this->render('user/login.html.twig');
    }
   
}
