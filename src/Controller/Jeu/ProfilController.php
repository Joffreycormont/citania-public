<?php

namespace App\Controller\Jeu;

use App\Entity\Actions;
use App\Entity\Characters;
use App\Entity\Comments;
use App\Entity\FriendRequests as AppFriendRequests;
use App\Entity\Humor;
use App\Entity\Profils;
use App\Entity\RelationStatus;
use App\Entity\WasteToTake;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Knp\Component\Pager\PaginatorInterface;
use Proxies\__CG__\App\Entity\FriendRequests;

class ProfilController extends AbstractController
{
    /**
     * @Route("/jeu/mon_profil", name="jeu_profil")
     */
    public function monProfil(Security $security, PaginatorInterface $paginator, Request $request)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters()->getId();

        $humorList = $this->getDoctrine()->getRepository(Humor::class)->findAll();
        $relationStatusList = $this->getDoctrine()->getRepository(RelationStatus::class)->findAll();

        $commentsList = $paginator->paginate(
            $this->getDoctrine()->getRepository(Comments::class)->findByDesc($userId),
            $request->query->getInt('page',1),
            5
        );

        $waitingComments = $this->getDoctrine()->getRepository(Comments::class)->findWaitingComments($userId);

        $friendList = $this->getDoctrine()->getRepository(FriendRequests::class)->findByReceiverId($userId);

        return $this->render('jeu/profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'humorList' => $humorList,
            'relationStatusList' => $relationStatusList,
            'commentsList' => $commentsList,
            'character' => $user->getCharacters(),
            'waitingComments' => $waitingComments,
            'friendList' => $friendList
        ]);
    }

    /**
     * @Route("/jeu/profil/{id}/visite", name="profil_visit")
     */
    public function profilVisit(Security $security, Characters $characters, PaginatorInterface $paginator, Request $request)
    {
        $userVisitor = $security->getUser();

        $humorList = $this->getDoctrine()->getRepository(Humor::class)->findAll();
        $relationStatusList = $this->getDoctrine()->getRepository(RelationStatus::class)->findAll();
        $actionList = $this->getDoctrine()->getRepository(Actions::class)->findAll(); 

        $commentsList = $paginator->paginate(
            $this->getDoctrine()->getRepository(Comments::class)->findByDesc($characters),
            $request->query->getInt('page',1),
            5
        );

        if($userVisitor->getCharacters()->getId() != $characters->getId()){
            $currentVisitorCount = $characters->getVisitor();
            $characters->setVisitor($currentVisitorCount + 1);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($characters);
        $em->flush();


        $friendList = $this->getDoctrine()->getRepository(FriendRequests::class)->findByReceiverId($characters->getId());

        return $this->render('jeu/profil/profilVisit.html.twig', [
            'controller_name' => 'ProfilController',
            'humorList' => $humorList,
            'relationStatusList' => $relationStatusList,
            'commentsList' => $commentsList,
            'character' => $characters,
            'userVisitor' => $userVisitor,
            'friendList' => $friendList,
            'actionList' => $actionList
        ]);
    }

    /**
     * @Route("/jeu/profil/newComment/{id}", name="profil_newComment", methods={"POST"})
     */
    public function profilnewComment(Security $security, Request $request, Characters $characters)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters()->getId();

        $newComment = new Comments();
        $newComment->setContent($request->request->get('content'));
        $newComment->setSendId($userId);
        $newComment->setSendName($user->getCharacters()->getFirstname().' '.$user->getCharacters()->getLastname());
        $newComment->setStatus(0);
        $newComment->setCharacters($characters);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($newComment);
        $em->flush();

        $this->addFlash('success', 'Commentaire envoyé');
        return $this->redirectToRoute('profil_visit', ['id' => $characters->getId()]);
    }

    /**
     * @Route("/jeu/profil/edit", name="jeu_profil_edit", methods={"POST"})
     */
    public function editProfilContent(Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters()->getId();

        $newContentProfil = trim($request->request->get('content'));

        $userToEdit = $this->getDoctrine()->getRepository(Characters::class)->find($userId);

        $userToEdit->getProfils()->setContent($newContentProfil);

        $em = $this->getDoctrine()->getManager();

        $em->persist($userToEdit);
        $em->flush();

        $this->addFlash('success', 'Votre profil a été modifié avec succès');

        return $this->redirectToRoute('jeu_profil');

    }

    /**
     * @Route("/jeu/profil/acceptComment/{id}", name="jeu_profil_acceptComment", methods={"POST"})
     */
    public function acceptComment(Comments $comment)
    {
        $comment->setStatus(1);

        $em = $this->getDoctrine()->getManager();

        $em->persist($comment);
        $em->flush();

        $this->addFlash('success', 'Commentaire accepté');

        return $this->redirectToRoute('jeu_profil');

    }

    /**
     * @Route("/jeu/profil/denyComment/{id}", name="jeu_profil_denyComment", methods={"POST"})
     */
    public function denyComment(Comments $comment)
    {
        $comment->setStatus(2);

        $em = $this->getDoctrine()->getManager();

        $em->persist($comment);
        $em->flush();

        $this->addFlash('success', 'Commentaire refusé');

        return $this->redirectToRoute('jeu_profil');

    }

    /**
     * @Route("/jeu/profil/deleteComment/{id}", name="jeu_profil_deleteComment", methods={"POST"})
     */
    public function deleteComment(Comments $comment)
    {

        $em = $this->getDoctrine()->getManager();

        $em->remove($comment);
        $em->flush();

        $this->addFlash('success', 'Commentaire supprimé');

        return $this->redirectToRoute('jeu_profil');

    }

    /**
     * @Route("/jeu/profil/closeWindow", name="jeu_profil_closeWindow", methods={"POST"})
     */
    public function closeWindow(Security $security)
    {
        $user = $security->getUser();
        $userCharacter = $user->getCharacters();

        $userCharacter->setIsWindowOpen(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($userCharacter);

        $em->flush();

        $this->addFlash('success', 'Fenêtre fermée avec succès');
        return $this->redirectToRoute('jeu_profil');
    }

    /**
     * @Route("/jeu/profil/{userId}/acceptFriend/{id}", name="jeu_profil_acceptFriend")
     */
    public function acceptFriend(AppFriendRequests $friendRequests, Security $security, $userId)
    {
        $user = $security->getUser();
        $userCharacter = $user->getCharacters()->getId();

        if($userId == $userCharacter){
            $friendRequests->setStatus(1);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($friendRequests);

        $em->flush();

        $this->addFlash('success', 'Requête d\'amis acceptée');
        return $this->redirectToRoute('jeu_profil');
    }

    /**
     * @Route("/jeu/profil/{userId}/denyFriend/{id}", name="jeu_profil_denyFriend")
     */
    public function denyFriend(AppFriendRequests $friendRequests, Security $security, $userId)
    {
        $user = $security->getUser();
        $userCharacter = $user->getCharacters()->getId();
        
        $em = $this->getDoctrine()->getManager();

        if($userId == $userCharacter){
            $em->remove($friendRequests); 
        }

        $em->flush();

        $this->addFlash('success', 'Requête d\'amis refusée');
        return $this->redirectToRoute('jeu_profil');
    }

    /**
     * @Route("/jeu/profil/newFriendRequest/{receiverId}", name="jeu_profil_newFriendRequest")
     */
    public function newFriendRequest(Security $security, $receiverId)
    {
        $user = $security->getUser();
        $userCharacter = $user->getCharacters();

        $friendRequestList = $this->getDoctrine()->getRepository(AppFriendRequests::class)->checkIfRequestExist($userCharacter->getId(), $receiverId);

        if(!empty($friendRequestList)){
            $this->addFlash('error', 'Tu as déjà envoyé une demande');
            return $this->redirectToRoute('profil_visit', ['id' => $receiverId]);
        }

        $receiverCharacter = $this->getDoctrine()->getRepository(Characters::class)->find($receiverId);

        $newFriendRequest = new AppFriendRequests();

        $newFriendRequest->setReceiver($receiverCharacter);
        $newFriendRequest->setSend($userCharacter);
        $newFriendRequest->setStatus(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newFriendRequest);
        $em->flush();

        $this->addFlash('success', 'Demande d\'ajout envoyée');
        return $this->redirectToRoute('profil_visit', ['id' => $receiverId]);
    }

    /**
     * @Route("/jeu/profil/editMusic", name="jeu_profil_editMusic", methods={"POST"})
     */
    public function editMusic(Security $security, Request $request)
    {
        $character = $security->getUser()->getCharacters();
         $firstClean = str_replace( "https://www.youtube.com/watch?v=", "" , $request->request->get('musicProfilLink'));

        $character->setMusicProfilLink(explode("&",$firstClean)[0]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($character);
        $em->flush();        

        $this->addFlash('success', 'Musique de profil modifiée');
        return $this->redirectToRoute('jeu_profil');
    }


}
