<?php

namespace App\Controller;

use App\Entity\Characters;
use App\Entity\House;
use App\Entity\Profils;
use App\Entity\User;
use App\Service\getRandomPassword;
use Swift_Image;
use App\Service\ReCaptcha;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class SecurityController extends AbstractController
{


    /**
     * @Route("/utilisateur/isConnected", name="is_connected")
     * @param Security $security
     * @return RedirectResponse return redirection after set up user in the connected List
     */
    public function isConnected(Security $security):RedirectResponse
    {

        $user = $security->getUser();

        $user->setIsConnected(time());
        $user->setUpdatedAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $url = $this->generateUrl('jeu_house');
        //return $this->redirectToRoute('jeu_news', ["news"]);
        return $this->redirect($url);
        

    }

    /**
     * @Route("/utilisateur/inscription", name="user_register")
     * @param AuthenticationUtils $authenticationUtils
     */
    public function register(AuthenticationUtils $authenticationUtils):Response
    {

        // For login
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/register.html.twig', [
            'controller_name' => 'UserController',
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }


    /**
     * @Route("/utilisateur/inscription/signUp", name="user_register_signUp", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     * @param ValidatorInterface $validator
     * @param ReCaptcha $reCaptcha
     * @return RedirectResponse return redirection after sign up new user
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, ValidatorInterface $validator, ReCaptcha $reCaptcha):RedirectResponse
    {
        // get register informations from the request function

        if ($request->isMethod('post')) {
            $em = $this->getDoctrine()->getManager();

            // your secret key
            $secret = $_ENV['RECAPTCHA_SECRET_KEY'];

            // empty response
            $response = null;

            // check secret key
            $reCaptcha->ReCaptcha($secret);

            // if submitted check response
            if ($_POST["g-recaptcha-response"]) {
                $response = $reCaptcha->verifyResponse(
                    $_SERVER["REMOTE_ADDR"],
                    $_POST["g-recaptcha-response"]
                );
            }

            if ($response != null && $response->success) {
                  
                //the email is not in the database, now we check if the format is valid
            if (filter_var($request->request->get('email'), FILTER_VALIDATE_EMAIL)) {
                $email = $request->request->get('email');
            }else{
                $this->addFlash('error','Le format de l\'email est invalide');


                $formData = array(
                    'email'=> $request->request->get('email'),
                    'password'=> $request->request->get('password'),
                    'passwordConfirm'=> $request->request->get('passwordConfirm'),
                    'firstname'=> $request->request->get('firstname'),
                    'lastname'=> $request->request->get('lastname')
                );

                return $this->redirectToRoute('user_register', ['formData' => $formData] );
                
            }
            
            if(strlen($request->request->get('password')) >= 10){
                
                $password = $request->request->get('password');
                $passwordConfirm = $request->request->get('passwordConfirm');
                
                if($password == $passwordConfirm){

                    $newUser = new User();
                    $encodedPassword = $encoder->encodePassword($newUser, $password);

                    $newUser->setEmail($email);
                    $newUser->setPassword($encodedPassword);
                    $newUser->setRoles(['ROLE_USER']);
                    $newUser->setStatus(0);

                    $rulesAccepted =  $request->request->get('rules');

                    if($rulesAccepted == 'on'){
                        $newUser->setRulesAccepted(1);
                    }else{
                        $this->addFlash('error','Vous devez accepter les conditions d\'utilisation pour vous inscrire');
                        $formData = array(
                            'email'=> $request->request->get('email'),
                            'password'=> $request->request->get('password'),
                            'passwordConfirm'=> $request->request->get('passwordConfirm'),
                            'firstname'=> $request->request->get('firstname'),
                            'lastname'=> $request->request->get('lastname')
                        );

                        return $this->redirectToRoute('user_register', ['formData' => $formData] );
                    }

                    // new character.

                    $firstnameList = $this->getDoctrine()->getRepository(Characters::class)->getFirstnameList();

                    $lastnameList = $this->getDoctrine()->getRepository(Characters::class)->getLastnameList();

                    foreach($firstnameList as $firstnameArray){
                        foreach($firstnameArray as $value){
                            if($request->request->get('firstname') == $value){
                                $this->addFlash('error','Ce prénom n\'est pas disponible ou est déjà utilisé');
                                $formData = array(
                                    'email'=> $request->request->get('email'),
                                    'password'=> $request->request->get('password'),
                                    'passwordConfirm'=> $request->request->get('passwordConfirm'),
                                    'firstname'=> $request->request->get('firstname'),
                                    'lastname'=> $request->request->get('lastname')
                                );
        
                                return $this->redirectToRoute('user_register', ['formData' => $formData] );
                            }
                        }
                    }

                    foreach($lastnameList as $lastnameArray){
                        foreach($lastnameArray as $value){
                            if($request->request->get('lastname') == $value){
                                $this->addFlash('lastname','Ce nom n\'est pas disponible ou est déjà utilisé');
                                $formData = array(
                                    'email'=> $request->request->get('email'),
                                    'password'=> $request->request->get('password'),
                                    'passwordConfirm'=> $request->request->get('passwordConfirm'),
                                    'firstname'=> $request->request->get('firstname'),
                                    'lastname'=> $request->request->get('lastname')
                                );
        
                                return $this->redirectToRoute('user_register', ['formData' => $formData] );
                            }
                        }
                    }

                    $firstName = $request->request->get('firstname');
                    $lastName = $request->request->get('lastname');
                    $sexe = $request->request->get('sexe');

                    // Initialisation Nouveau personnage
                    $newCharacter = new Characters();

                    $newCharacter->setFirstname($firstName);
                    $newCharacter->setLastname(strtoupper($lastName));
                    $newCharacter->setSexe($sexe);

                    // inialisation de la maison de base

                    $basicHouse = $this->getDoctrine()->getRepository(House::class)->find(1);
                    $newCharacter->setHouse($basicHouse);
                    $newCharacter->setHouseProperty(0);

                    $em->persist($newCharacter);

                    // Initialisation Nouveau profil du personnage
                    $newCharacterProfil = new Profils();

                    $newCharacterProfil->setContent("");
                    $newCharacterProfil->setCharacters($newCharacter);

                    $em->persist($newCharacterProfil);

                    $newUser->setCharacters($newCharacter);

                    $em->persist($newUser);

                    // test if the email already exist
                    $emailViolation = $validator->validate($newUser);
        
                    if(count($emailViolation) > 0){
                        $this->addFlash('error','Cette email est déjà utilisée.');
                        $formData = array(
                            'email'=> $request->request->get('email'),
                            'password'=> $request->request->get('password'),
                            'passwordConfirm'=> $request->request->get('passwordConfirm'),
                            'firstname'=> $request->request->get('firstname'),
                            'lastname'=> $request->request->get('lastname')
                        );
        
                        return $this->redirectToRoute('user_register', ['formData' => $formData] );
                    }

                    $em->Flush();


                    // mail de bienvenue
                    $message = (new \Swift_Message('Citania - Bienvenue sur Citania'))
                    ->setFrom('j.cormont30@gmail.com')
                    ->setTo($email);
                    $image = $message->embed(Swift_Image::fromPath('assets/Images/citania logo.png'));
                    $message->setBody(
                        $this->renderView(
                            // templates/emails/registration.html.twig
                            'emails/welcome.html.twig',
                            [
                                'image' => $image
                            ]
                        ),
                        'text/html'
                    );
            
                    $mailer->send($message);


                    $this->addFlash('success','Votre compte a été créé avec succès');
                    return $this->redirectToRoute('user_register');

                }else{
                    $this->addFlash('error','Les deux mots de passe ne sont pas identiques');
                    $formData = array(
                        'email'=> $request->request->get('email'),
                        'password'=> "",
                        'passwordConfirm'=> "",
                        'firstname'=> $request->request->get('firstname'),
                        'lastname'=> $request->request->get('lastname')
                    );

                    return $this->redirectToRoute('user_register', ['formData' => $formData] );
                }

            }else{
                $this->addFlash('error','Votre mot de passe doit faire au minimum 10 caractères');
                $formData = array(
                    'email'=> $request->request->get('email'),
                    'password'=> "",
                    'passwordConfirm'=> "",
                    'firstname'=> $request->request->get('firstname'),
                    'lastname'=> $request->request->get('lastname')
                );

                return $this->redirectToRoute('user_register', ['formData' => $formData] );
            }


            }else{
                $this->addFlash('error','Vous devez valider le captcha !');
                return $this->redirectToRoute('user_register');
            }

        }

    }


    /**
     * @Route("/deconnexion", name="self_deconnexion")
     */
    public function deconnexion(Security $security)
    {

        // pre logout     

        $user = $security->getUser();

        if($user === null){
            return $this->redirectToRoute('home');
        }

        $userId = $user->getId();

        $userRepository = $this->getDoctrine()->getRepository(User::class)->find($userId);

        $userRepository->setIsConnected($userRepository->getIsConnected() - 21600);
        $em = $this->getDoctrine()->getManager();
        $em->persist($userRepository);
        $em->flush();

        return $this->redirectToRoute('app_logout');

    }

    /**
     * @Route("/logoutRouteURL", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }


    /**
     * @Route("/user/newPassword", name="user_newPassword")
     * @param Security $security
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return RedirectResponse return redirection after change password
     */
    public function newPassword(Security $security, Request $request, UserPasswordEncoderInterface $encoder):RedirectResponse
    {
        $user = $security->getUser();
        $userId = $user->getId();

        $currentPassword = $request->request->get('currentPassword');

        $newPassword = $request->request->get('newPassword');
        $newPasswordConfirm = $request->request->get('confirmNewPassword');

        $match = $encoder->isPasswordValid($user, $currentPassword);

        if($match){
            if($newPassword == $newPasswordConfirm ){
                if(strlen($newPassword) >= 10){

                    $UserToEdit = $this->getDoctrine()->getRepository(User::class)->find($userId);

                    $newEncodedPassword = $encoder->encodePassword($UserToEdit, $newPassword);
                    $UserToEdit->setPassword($newEncodedPassword);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($UserToEdit);
                    $em->flush();

                    $this->addFlash('success', 'Votre mot de passe a été modifié avec succès');
                    return $this->redirectToRoute('personnal_account');

                }else{
                    $this->addFlash('error', 'Votre nouveau mot de passe doit faire 10 caractères minimum');
                    return $this->redirectToRoute('personnal_account');
                }
            }else{
                $this->addFlash('error', 'Vos deux mots de passe ne correspondent pas');
                return $this->redirectToRoute('personnal_account');
            }
        }else{
            $this->addFlash('error', 'Votre mot de passe actuel ne correspond pas avec ce que vous avez renseigné');
            return $this->redirectToRoute('personnal_account');
        }
    }


    /**
     * @Route("/utilisateur/mot_de_passe", name="app_password")
     */
    public function password(AuthenticationUtils $authenticationUtils)
    {
        // For login
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('security/password.html.twig', [
            'controller_name' => 'UserController',
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }



    /**
     * @Route("/password/forgot", name="app_password_forgot", methods={"POST"})
     */
    public function forgotPassword(Request $request, getRandomPassword $randomPassword, \Swift_Mailer $mailer, UserPasswordEncoderInterface $encoder)
    {
        // Vérifier l'utilisateur en cherchant son email dans la base de données
        $email = $request->request->get('email');

        $emailList = $this->getDoctrine()->getRepository(User::class)->getEmailList();

        foreach($emailList as $emailArray){
            foreach($emailArray as $value){
                if($email == $value){
                    // Trouver l'id utilisateur en fonction de l'email trouvée en bdd
                    $userIdByEmail = $this->getDoctrine()->getRepository(User::class)->findUserIdByEmail($email); 
                    $userId =  $userIdByEmail[0]['id'];
                    $currentUser = $this->getDoctrine()->getRepository(User::class)->find($userId);
                    // Créer un nouveau mot de passe
                    $newPasswordGenerated = $randomPassword->generateRandomString();
                    
                    // L'envoyer via email de l'utilisateur 
                    
                    $message = (new \Swift_Message('Citania - Voici votre mot de passe de remplacement'))
                    ->setFrom('j.cormont30@gmail.com')
                    ->setTo($email);
                    $image = $message->embed(Swift_Image::fromPath('assets/Images/citania logo.png'));
                    $message->setBody(
                        $this->renderView(
                            // templates/emails/registration.html.twig
                            'emails/newpassword.html.twig',
                            [
                                'password' => $newPasswordGenerated,
                                'image' => $image
                            ]
                        ),
                        'text/html'
                    )
                    ;
            
                    $mailer->send($message);
                    // Encoder ce même mot de passe
                    $encodedPassword = $encoder->encodePassword($currentUser, $newPasswordGenerated);
                    $currentUser->setPassword($encodedPassword);
                    // le persister dans la base de données
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($currentUser);
                    $em->flush();
                   
                    $this->addFlash('success', 'Vous allez recevoir un nouveau mot de passe sur votre email');
                    return $this->redirectToRoute('app_password');

                }else{

                }
            }
            
        }
        $this->addFlash('error', 'Cette email est inconnue');
        return $this->redirectToRoute('app_password');
    }


    /**
     * @Route("/user/newEmail", name="user_newEmail")
     */
    public function newEmail(Security $security, Request $request)
    {
        $user = $security->getUser();
        $userId = $user->getId();

        $emailList = $this->getDoctrine()->getRepository(User::class)->getEmailList();

        $newEmail = $request->request->get('newEmail');

        foreach($emailList as $emailArray){
            foreach($emailArray as $value){
                if($request->request->get('newEmail') == $value){
                    $this->addFlash('error', 'Cette email est déja utilisée');
                    return $this->redirectToRoute('personnal_account');
                }
            }
        }

        if (filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $UserToEdit = $this->getDoctrine()->getRepository(User::class)->find($userId);

            $UserToEdit->setEmail($newEmail);

            $em = $this->getDoctrine()->getManager();
            $em->persist($UserToEdit);
            $em->flush();

            $this->addFlash('success', 'Votre email a été modifiée avec succès');
            return $this->redirectToRoute('personnal_account');

        }else{
            $this->addFlash('error','Le format de l\'email est invalide');
            return $this->redirectToRoute('personnal_account');
        }

    }

}
