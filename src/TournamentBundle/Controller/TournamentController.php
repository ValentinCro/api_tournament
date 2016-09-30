<?php

namespace TournamentBundle\Controller;

use AppBundle\Services\ProductService;
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
use Utils\FilterDto;

class TournamentController extends Controller
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
     * @Route("/create/tournament")
     * @Method({"POST"})
     */
    public function postCreateTournamentAction(Request $request) {
        $body = $request->getContent();
        $tournamentCreate = $this->serializer->deserialize($body, 'TournamentBundle\Dto\TournamentCreate', 'json');
        if ($tournamentCreate != null) {
            $tournament = new Tournament();
            $data = $this->getDoctrine()
                ->getRepository('UserBundle:User')
                ->findOneBy(array('name' => $tournamentCreate->getCreator()));
            $tournament->setCreator($data);
            $tournament->setName(htmlspecialchars($tournamentCreate->getName()));
            $tournament->setPrivate($tournamentCreate->isPrivate());
            $tournament->setIsInTeam($tournamentCreate->isInTeam());
            if (!$tournament->getIsInTeam()) {
                $tournament->addPlayer($data);
                $data->addTournamentIn($tournament);
            }
            $pass = null;
            if ($tournament->getPrivate()) {
                $pass = sha1($tournamentCreate->getPassword());
            }
            $tournament->setPassword($pass);
            $tournament->setDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($tournament);
            $em->persist($data);
            $em->flush();

            $response = new \TournamentBundle\Dto\Tournament();
            $response->entityToDto($tournament);
            return new Response($this->serializer->serialize($response, 'json'), Response::HTTP_OK);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/tournaments")
     * @Method({"GET", "OPTIONS"})
     */
    public function getTournamentsAction()
    {
        $data = $this->getDoctrine()
            ->getRepository('TournamentBundle:Tournament')
            ->findAll();
        $tournamentsDto = array();
        foreach ($data as $tournament) {
            $dto = new \TournamentBundle\Dto\Tournament();
            $dto->EntityToDto($tournament);
            $tournamentsDto[] = $dto;
        }
        $json = $this->serializer->serialize($tournamentsDto, 'json');
        return new Response($json);
    }

    /**
     * @Route("/tournament/{id}/id")
     * @Method({"GET", "OPTIONS"})
     */
    public function getTournamentByIdAction($id)
    {
        $data = $this->getDoctrine()
            ->getRepository('TournamentBundle:Tournament')
            ->findOneBy(array('id' => $id));

        if ($data != null) {
            $dto = new \TournamentBundle\Dto\Tournament();
            $dto->EntityToDto($data);
            $json = $this->serializer->serialize($data, 'json');
            return new Response($json);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/tournament/{name}/name")
     * @Method({"GET", "OPTIONS"})
     */
    public function getTournamentByNameAction($name) {

        $data = $this->getDoctrine()
            ->getRepository('TournamentBundle:Tournament')
            ->findOneBy(array('name' => $name));

        if ($data != null) {
            $dto = new \TournamentBundle\Dto\Tournament();
            $dto->EntityToDto($data);
            $json = $this->serializer->serialize($data, 'json');
            return new Response($json);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/tournament/creator/{name}/name")
     * @Method({"GET", "OPTIONS"})
     */
    public function getTournamentByCreatorNameAction($name, Request $request)
    {
        $token = $request->headers->get("Authorization");
        $json = $this->serializer->serialize($request->headers, 'json');

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response($json, Response::HTTP_FORBIDDEN);
        }

        $page = $request->query->get('page', '1');
        $limit = $request->query->get('limit', 20);
        $orderBy = array('id' => $request->query->get('order', 'asc'));
        $offset = ($page - 1) * $limit;

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('name' => $name));

        if ($data != null) {
            $data = $this->getDoctrine()
                ->getRepository('TournamentBundle:Tournament')
                ->findBy(array('creator' => $data), $orderBy, $limit, $offset);
            $tournamentsDto = array();
            foreach ($data as $tournament) {
                $dto = new \TournamentBundle\Dto\Tournament();
                $dto->EntityToDto($tournament);
                $tournamentsDto[] = $dto;
            }
            $json = $this->serializer->serialize($tournamentsDto, 'json');
            return new Response($json);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }
}
