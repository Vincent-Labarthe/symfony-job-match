<?php

namespace App\Controller\SearchController;

use App\Entity\User;
use App\Entity\JobApplication;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/user")
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/annonce", name="search_annonce")
     */
    public function searchJobAnnonce(Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user= $repository->find($this->getUser()->getId());
        dump($user);

        $title = $request->get('search');
        $jobApplications = $this->getDoctrine()->getRepository(JobApplication::class)->findByTitle($title);
        dump($jobApplications);

        return $this->render(
            'user/jobSearch.html.twig',
            [
                "joblist" => $jobApplications,
                "user" => $user,
            ]
        );
    }
}
