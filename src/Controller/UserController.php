<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{


    /**
     * @Route("/user/{id}", name="user_page")
     */
    public function userPage(User $user)
    {
        return $this->render(
            'user/user_home_page.html.twig',
            [
                'user' => $user
            ]
        );
    }

   /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function userLogOut()
    {
       
       
        throw new \Exception('Don\'t forget to activate logout in security.yaml');

        return $this->redirectToRoute('home_page');
    }
}
