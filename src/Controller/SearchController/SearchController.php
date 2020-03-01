<?php

namespace App\Controller\SearchController;

use App\Entity\JobApplication;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/search")
 */
class SearchController extends AbstractController
{
 /**
     * @Route("/annonce", name="search_annonce")
     */
    public function searchSong(Request $request)    
    {

        $jobApplication = new JobApplication();

        $title = $request->get('search');
        $jobApplications = $this->getDoctrine()->getRepository(JobApplication::class)->findByTitle($title);
        dump($jobApplications);
       foreach ($jobApplications as $jobApplication) {
dump($jobApplication);
}
exit();
            $jobApplicationId=$jobApplication->getId();
            dd( $jobApplicationId);
            return $this->redirectToRoute('job_application', ['id' => $jobApplicationId]);
        
    }
}