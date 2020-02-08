<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController{


    /**
     * @Route("/user/{id}", name="user_page")
     */
    public function userPage (User $user){

        return $this->render('user/user_home_page.html.twig',
    [
        'user'=>$user
    ]);
        

    }
}