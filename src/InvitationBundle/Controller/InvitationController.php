<?php

namespace InvitationBundle\Controller;

use AppBundle\Services\ProductService;
use InvitationBundle\Entity\Invitation;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Serializer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TournamentBundle\Entity\Tournament;
use UserBundle\Entity\User;
use Utils\FilterDto;

class InvitationController extends Controller
{
    /**
     * @var Serializer
     */
    protected $serializer;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->serializer = $this->get('jms_serializer');
    }
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('InvitationBundle:Default:index.html.twig');
    }



    /**
     * @Route("/invitation/invite")
     * @Method({"POST", "OPTIONS"})
     */
    public function inviteAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $body = $request->getContent();
        $inviteDto = $this->serializer->deserialize($body, 'InvitationBundle\Dto\InviteDto', 'json');
        if ($inviteDto != null) {
            $sender = $this->getDoctrine()
                ->getRepository('UserBundle:User')
                ->findOneBy(array('name' => $inviteDto->getSenderName()));

            if ( $sender != null ) {
                $receiver = $this->getDoctrine()
                    ->getRepository('UserBundle:User')
                    ->findOneBy(array('name' => $inviteDto->getReceiverName()));
                if ($receiver != null) {
                    $tournament = $this->getDoctrine()
                        ->getRepository('TournamentBundle:Tournament')
                        ->findOneBy(array('id' => $inviteDto->getTournamentId()));

                    $invit = $this->getDoctrine()
                        ->getRepository('InvitationBundle:Invitation')
                        ->findOneBy(array('sender' => $sender, 'receiver' => $receiver, 'tournament' => $tournament));
                    if ($invit == null) {
                        if ($tournament != null) {
                            $invitation = new Invitation();
                            $invitation->setAccepted(false);
                            $invitation->setDeclined(false);
                            $invitation->setSender($sender);
                            $invitation->setReceiver($receiver);
                            $invitation->setTournament($tournament);
                            $invitation->setDate(new \DateTime());

                            $em = $this->getDoctrine()->getManager();
                            $em->persist($invitation);
                            $em->flush();

                            return new Response('', Response::HTTP_OK);
                        }
                        return new Response('', Response::HTTP_BAD_REQUEST);
                    }
                    return new Response('', Response::HTTP_NOT_FOUND);
                }
                return new Response('', Response::HTTP_NOT_FOUND);
            }
            return new Response('', Response::HTTP_NOT_FOUND);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/invitations/{name}/sender")
     * @Method({"GET", "OPTIONS"})
     */
    public function getAllTournamentInvitationSendedAction($name, Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $sender = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('name' => $name));

        if ($sender != null) {
            $page = $request->query->get('page', '1');
            $limit = $request->query->get('limit', 20);
            $orderBy = array('id' => $request->query->get('order', 'asc'));
            $offset = ($page - 1) * $limit;

            $data = $this->getDoctrine()
                ->getRepository('InvitationBundle:Invitation')
                ->findBy(array('sender' => $sender), $orderBy, $limit, $offset);
            $json = $this->serializer->serialize($data, 'json');
            return new Response($json);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/invitations/{name}/receiver")
     * @Method({"GET", "OPTIONS"})
     */
    public function getAllTournamentInvitationReceivedAction($name, Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $receiver = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('name' => $name));

        if ($receiver != null) {
            $page = $request->query->get('page', '1');
            $limit = $request->query->get('limit', 20);
            $orderBy = array('id' => $request->query->get('order', 'asc'));
            $offset = ($page - 1) * $limit;

            $data = $this->getDoctrine()
                ->getRepository('InvitationBundle:Invitation')
                ->findBy(array('receiver' => $receiver), $orderBy, $limit, $offset);
            $json = $this->serializer->serialize($data, 'json');
            return new Response($json);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/invitations/pending/{name}/receiver")
     * @Method({"GET", "OPTIONS"})
     */
    public function getAllTournamentPendingInvitationReceivedAction($name, Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $receiver = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('name' => $name));

        if ($receiver != null) {
            $page = $request->query->get('page', '1');
            $limit = $request->query->get('limit', 20);
            $orderBy = array('id' => $request->query->get('order', 'asc'));
            $offset = ($page - 1) * $limit;

            $data = $this->getDoctrine()
                ->getRepository('InvitationBundle:Invitation')
                ->findBy(array('receiver' => $receiver, 'accepted' => false, 'declined' => false), $orderBy, $limit, $offset);
            $json = $this->serializer->serialize($data, 'json');
            return new Response($json);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/invitations/pending/{name}/sender")
     * @Method({"GET", "OPTIONS"})
     */
    public function getAllTournamentPendingInvitationSendedAction($name, Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $sender = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('name' => $name));

        if ($sender != null) {
            $page = $request->query->get('page', '1');
            $limit = $request->query->get('limit', 20);
            $orderBy = array('id' => $request->query->get('order', 'asc'));
            $offset = ($page - 1) * $limit;

            $data = $this->getDoctrine()
                ->getRepository('InvitationBundle:Invitation')
                ->findBy(array('sender' => $sender, 'accepted' => false, 'declined' => false), $orderBy, $limit, $offset);
            $json = $this->serializer->serialize($data, 'json');
            return new Response($json);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/invitation/accept")
     * @Method({"POST", "OPTIONS"})
     */
    public function acceptTournamentInvitationAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $body = $request->getContent();
        $invitationDto = $this->serializer->deserialize($body, 'InvitationBundle\Dto\InvitationDto', 'json');
        if ($invitationDto != null) {
            $invitation = $this->getDoctrine()
                ->getRepository('InvitationBundle:Invitation')
                ->findOneBy(array('id' => $invitationDto->getId()));
            if ($invitation != null) {
                $invitation->setAccepted(true);
                $user = new User();
                if ($invitation->getTournament()->getCreator()->getName() == $invitation->getSender()->getName()) {
                    $user = $invitation->getreceiver();
                } else {
                    $user = $invitation->getSender();
                }

                $invitation->getTournament()->addPlayer($user);
                $user->addTournamentIn($invitation->getTournament());

                $em = $this->getDoctrine()->getManager();
                $em->persist($invitation->getTournament());
                $em->persist($user);
                $em->persist($invitation);
                $em->flush();

                return new Response($this->serializer->serialize($invitation, 'json'), Response::HTTP_OK);
            }
            return new Response('', Response::HTTP_NOT_FOUND);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/invitation/decline")
     * @Method({"POST", "OPTIONS"})
     */
    public function declineTournamentInvitationAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $body = $request->getContent();
        $invitationDto = $this->serializer->deserialize($body, 'InvitationBundle\Dto\InvitationDto', 'json');
        if ($invitationDto != null) {
            $invitation = $this->getDoctrine()
                ->getRepository('InvitationBundle:Invitation')
                ->findOneBy(array('id' => $invitationDto->getId()));
            if ($invitation != null) {
                $invitation->setDeclined(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($invitation);
                $em->flush();

                return new Response($this->serializer->serialize($invitation, 'json'), Response::HTTP_OK);
            }
            return new Response('', Response::HTTP_NOT_FOUND);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }
}
