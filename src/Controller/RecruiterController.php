<?php

namespace App\Controller;

use App\Entity\Recruiter;
use App\Entity\JobApplication;
use App\Form\Type\JobApplicationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * IsGranted("ROLE_RECRUITER")
 * @Route("/recruiter")
 */
class RecruiterController extends AbstractController
{
    /**
     **@Route("/show/{id}", name="recruiter_page", requirements={"id":"\d+"})
     */
    public function recruiterPage(Recruiter $recruiter)
    {
        return $this->render(
            'recruiter/recruiter_home_page.html.twig',
            [
                'recruiter' => $recruiter
            ]
        );
    }

    /**
     * @Route("/logout", name="recruiter_logout", methods={"GET"})
     */
    public function recruiterLogout()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @Route("/add-job/{id}", name="add_job",  requirements={"id":"\d+"})
     */
    public function addJobApplication(Request $request, Recruiter $recruiter)
    {
        $newJobApplication = new JobApplication();
        $form = $this->createForm(JobApplicationType::class, $newJobApplication);
        $newJobApplication->setRecruiter($recruiter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newJobApplication);
            $manager->flush();

            $this->addFlash("success", "L'artiste a bien été ajouté");
            return $this->redirectToRoute('recruiter_page', ['id' => $recruiter->getId()]);
        }
        return $this->render(
            "recruiter/add_job.html.twig",
            [
                "formView" => $form->createView(),
            ]
        );
    }
}
