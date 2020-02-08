<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UploadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UserController extends AbstractController
{


    /**
     * @Route("/user/{id}", name="user_page")
     */
    public function userPage(Request $request,User $user)
    {

        $form = $this->createForm(UploadType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form->get('profilPicture')->getData();
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $pictureFile->move(
                        $this->getParameter('pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setProfilPicture($newFilename);
                $manager = $this->getDoctrine()->getManager();
                $manager->flush();


            }
            return $this->redirectToRoute('user_page', ['id' => $user->getId()]);
        }

        return $this->render(
            'user/user_home_page.html.twig',
            [
                "formView" => $form->createView(),
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
