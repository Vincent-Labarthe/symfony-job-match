<?php
namespace App\Controller\UserController;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class SecurityController extends AbstractController{

     /**
     * @Route("/forgotten-pwd", name="app_forgotten_password", methods="GET|POST")
     */
    public function forgottenPassword(Request $request, UserPasswordEncoderInterface $encoder, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        //on vérifie si on a reçu le form 
        if ($request->isMethod('POST')){
            //on récupère l'email
            $email=$request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();
            //on compare avec les email de la bdd
            $user = $entityManager->getRepository(User::class)->findOneBy(array("email"=>$email));
           // si email inconnue on renvoi vers le form avec un flash message
            if (!$user){
                $this->addFlash('warning', 'Cet email est inconnu');
                return $this->render('security/forgottenPwd.html.twig');  
            }
            // si email connu on génère un token de sécutité 
            $token = $tokenGenerator->generateToken();
            try{
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('home');
            }
            // on génère un lien en le lien avec le token de sécurité
            $url = $this->generateUrl('reset_pwd', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            //on génère l'email
            $message = (new TemplatedEmail())
            ->from('admin@job-match.com')
            ->to($user->getEmail())
            //->cc('cc@example.com')
            ->subject('reset password')
            ->text('Pour définir un nouvau mot de passe cliquez sur le lien ci dessous')
            ->htmlTemplate('security/resetPwdMail.html.twig')
            ->context([
                'user'=>$user,
                'url'=>$url
              
            ]);
            $mailer->send($message);

        }
        return $this->render('security/forgottenPwd.html.twig');
    }

    /**
     * @Route("/reset-pwd/{token}", name="reset_pwd")
     */
    public function resetPwd(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder){
if($request->isMethod('POST')){
    $entityManager = $this->getDoctrine()->getManager();
 
    $user = $entityManager->getRepository(User::class)->findOneBy(['resetToken'=>$token]);
    if ($user === null) {
        $this->addFlash('danger', 'Mot de passe non reconnu');
        return $this->redirectToRoute('home');
    }
    $user->setResetToken("");
    $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
    $entityManager->flush();
    $this->addFlash('notice', 'Mot de passe mis à jour !');
 
    return $this->redirectToRoute('user_sign');
}else {

    return $this->render('security/resetPwd.html.twig', ['token' => $token]);
}
    }

}