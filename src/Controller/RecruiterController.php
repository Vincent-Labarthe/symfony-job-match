<?php 

namespace App\Controller;

use App\Entity\Recruiter;
use App\Form\Type\UploadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class RecruiterController extends AbstractController{
/**
     * @Route("/recruiter", name="recruiter_page" )
     */
    public function recruiterPage()
    {

       

            
            return $this->redirectToRoute('recruiter_page');
        }

        
   

}