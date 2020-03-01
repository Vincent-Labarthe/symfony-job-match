<?php

namespace App\Controller\UserController;

use App\Entity\User;
use App\Form\Type\UploadType;
use App\Entity\JobApplication;
use App\Form\Type\UserUpdateType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/home/{id}", name="user_page", requirements={"id":"\d+"})
     *@IsGranted("ROLE_USER")
     */
    public function userPage(Request $request, User $user, UserInterface $ConnectedUser)
    {

        // Conditation permettant de vérifier que l'utilisateur va bien sur sa hoem page personnel
        if ($user === $ConnectedUser) {
            $formUpdate = $this->createForm(UserUpdateType::class, $user);
            $formUpdate->handleRequest($request);
            if ($formUpdate->isSubmitted() && $formUpdate->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->flush();
                return $this->redirectToRoute('user_page', ['id' => $user->getId()]);
            }

            $form = $this->createForm(UploadType::class, $user);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $pictureFile = $form->get('profilPicture')->getData();
                if ($pictureFile) {
                    $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();

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
                    "formUpdate" => $formUpdate->createView(),
                    'user' => $user
                ]
            );
        }
        return $this->redirectToRoute('user_login');
    }

    /**
     * @Route("/logout", name="user_logout", methods={"GET"})
     */
    public function userLogout()
    {


        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    /**
     * @Route("/update/{id}", name="user_update",requirements={"id":"\d+"})
     */
    public function userUpdate(Request $request, User $user)
    {
        $form = $this->createForm(UserRepository::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            return $this->redirectToRoute('user_page', ['id' => $user->getId()]);
        }
        return $this->render(
            'user/udpate.html.twig',
            [
                "formView" => $form->createView(),
                'user' => $user
            ]
        );

    }

    /**
     * @Route("/job-list", name="job_list_user")
     */
    public function showAnnonce( PaginatorInterface $paginator ,Request $request){
        
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user= $repository->find($this->getUser()->getId());
  
        $repository = $this->getDoctrine()->getRepository(JobApplication::class);
        $jobList=$repository->findAll();

        $pagination = $paginator->paginate(
            $repository->findBy(array(), array('id'=>'desc')),
            $request->query->getInt('page', 1), /*page number*/
            10 );
            
        return $this->render(
            'user/jobList.html.twig',
            [
                "joblist" => $jobList,
               "user"=>$user,
               'pagination' => $pagination
            ]
        );

    }

     
}
