<?php

namespace App\Controller\Jeu;

use App\Entity\Characters;
use App\Entity\FriendRequests;
use App\Entity\Messages;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MessagesController extends AbstractController
{
    /**
     * @Route("/jeu/messagerie", name="jeu_messages")
     * @param Security $security
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response return rendering of the messaging
     */
    public function index(Security $security, PaginatorInterface $paginator, Request $request):Response
    {
        $user = $security->getUser();
        $userId = $user->getCharacters()->getId();

        $friendList = $this->getDoctrine()->getRepository(FriendRequests::class)->findByReceiverId($userId);

        $messageListWithLastMessageFirst = $paginator->paginate(
            $this->getDoctrine()->getRepository(Messages::class)->getMessageListWithLastMessageFirst($userId),
            $request->query->getInt('page',1),
            5
        );

        if(empty($messageListWithLastMessageFirst)){

            return $this->render('jeu/messages/index.html.twig', [
                'controller_name' => 'HomeGameController',
                'messageList' => $messageListWithLastMessageFirst,
                'friendList' => $friendList
            ]);
        }

        foreach($messageListWithLastMessageFirst as $message){            
            if($message->getsend()->getId() == $userId){
                $receiverCharacterEntity[] = $this->getDoctrine()->getRepository(Characters::class)->find($message->getReceiverId());
            }
        }

        if(empty($receiverCharacterEntity)){

            return $this->render('jeu/messages/index.html.twig', [
                'controller_name' => 'HomeGameController',
                'messageList' => $messageListWithLastMessageFirst,
                'friendList' => $friendList
            ]);
        }

        return $this->render('jeu/messages/index.html.twig', [
            'controller_name' => 'HomeGameController',
            'messageList' => $messageListWithLastMessageFirst,
            'receiverCharacter' => $receiverCharacterEntity,
            'friendList' => $friendList
        ]);
    }

    /**
     * @Route("/jeu/messagerie/discussion/with/{id}", name="jeu_messages_discussion")
     * @param Security $security
     */
    public function discussion(Security $security, $id)
    {
        $user = $security->getUser()->getCharacters();
        $userId = $user->getId();
        $sendId = $id;

        $em = $this->getDoctrine()->getManager();
    
        $lastMessageUpdateToReaded = $this->getDoctrine()->getRepository(Messages::class)->getLastMessageDiscussionForReaded((int) $userId, (int) $id);
        
        if(!empty($lastMessageUpdateToReaded)){
            foreach($lastMessageUpdateToReaded as $message){

                if($message->getReceiverId() == $userId){
                    $message->setStatus(2);
                    $em->persist($message);  
                }
    
            }
        }

        $sendCharacters = $this->getDoctrine()->getRepository(Characters::class)->find($id);
        $messageListForDiscussion = $this->getDoctrine()->getRepository(Messages::class)->getMessageForDiscussion($userId, $sendId);


        if($sendCharacters == null){
            return $this->redirectToRoute('jeu_messages');
        }


        $em->flush();

        return $this->render('jeu/messages/discussion.html.twig', [
            'controller_name' => 'HomeGameController',
            'discussion' => $messageListForDiscussion,
            'sendCharacter' => $sendCharacters,
            'sendId' => $sendId
        ]);
    }

    /**
     * @Route("/jeu/messagerie/new/message/to/{receiverId}/from/{sendId}", name="jeu_messages_new", methods={"POST"})
     */
    public function sendNewMessage($receiverId, Characters $sendId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // je vérifie si il reste des timbres chez l'envoyeur
        if($sendId->getStamps() > 0){

            $sendId->setStamps($sendId->getStamps() - 1); 

            $lastMessageToUpdate = $this->getDoctrine()->getRepository(Messages::class)->getLastMessageDiscussion((int) $receiverId, $sendId->getId());

            if( isset($lastMessageToUpdate[0]) ){
                $lastMessageToUpdate[0]->setLast(0);
                $em->persist($lastMessageToUpdate[0]);  
            } elseif(empty($lastMessageToUpdate)){
                $lastMessageToUpdate = $this->getDoctrine()->getRepository(Messages::class)->getLastMessageDiscussion($sendId->getId(), (int) $receiverId);

                if(!empty($lastMessageToUpdate)){
                    $lastMessageToUpdate[0]->setLast(0);
                    $em->persist($lastMessageToUpdate[0]);  
                }
            }else{

            }

            $newMessage = new Messages();

            $newMessage->setMessage($request->request->get('content'));
            $newMessage->setReceiverId($receiverId);
            $newMessage->setSend($sendId);
            $newMessage->setLast(1);

            $factorConnectedList = $this->getDoctrine()->getRepository(Characters::class)->findByFactor();

            if(count($factorConnectedList) == 0){
                $newMessage->setStatus(1);
            }else{
                $newMessage->setStatus(0);
            }

            $em->persist($sendId);
            $em->persist($newMessage);
            $em->flush();
        }else{
            $this->addFlash('error', 'Vous n\'avez pas assez de timbres pour envoyer ce message, vous devez vous fournir chez un postier');
            return $this->redirectToRoute('jeu_messages');
        }   

        $this->addFlash('success', 'Message privé envoyé');
        return $this->redirectToRoute('jeu_messages_discussion', ['id' => $receiverId]);

    }



    /**
     * @Route("/jeu/messagerie/message/delete/{id}", name="jeu_messages_delete")
     */
    public function deleteMessage(Messages $message, Security $security)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();

        if($message->getReceiverId() == $character->getId() || $message->getSendId() == $character->getId()){

            $message->setStatus(3);
            $em->persist($message);
            $em->flush();

            $this->addFlash('success', 'Message suppprimé');
            return $this->redirectToRoute('jeu_messages');
        }
    }


}
