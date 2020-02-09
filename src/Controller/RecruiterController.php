<?php

namespace App\Controller;

use App\Entity\Recruiter;
use App\Form\Type\UploadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class RecruiterController extends AbstractController
{
    /**
     **@Route("/recruiter/{id}", name="recruiter_page", requirements={"id":"\d+"})
     */
    public function recruiterPage(Request $request, Recruiter $recruiter)
    {
        return $this->render(
            'recruiter/recruiter_home_page.html.twig'
        );
    }
}
