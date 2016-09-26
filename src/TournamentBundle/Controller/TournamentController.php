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
                ->findOneBy(array('id' => $tournamentCreate->getCreatorId()));
            $tournament->setCreator($data);
            $tournament->setName(htmlspecialchars($tournamentCreate->getName()));
            $tournament->setPrivate($tournamentCreate->isPrivate());
            $tournament->setIsInTeam($tournamentCreate->isInTeam());
            if (!$tournament->getIsInTeam()) {
                $tournament->addPlayer($data);
            }
            $pass = null;
            if ($tournament->getPrivate()) {
                $pass = sha1($tournamentCreate->getPassword());
            }
            $tournament->setPassword($pass);
            $this->getDoctrine()->getManager()->persist($tournament);
            $this->getDoctrine()->getManager()->flush();
            $response = new \TournamentBundle\Dto\Tournament();
            $response->entityToDto($tournament);
            return new Response($this->serializer->serialize($response, 'json'), Response::HTTP_OK);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/tournaments")
     * @Method({"GET"})
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
            array_push($tournamentsDto, $dto);
        }
        $json = $this->serializer->serialize($tournamentsDto, 'json');
        return new Response($json);
    }

    /**
     * @Route("/tournament/{$id}/id")
     * @Method({"GET"})
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
     * @Route("/tournament/{$name}/name")
     * @Method({"GET"})
     */
    public function getTournamentByNameAction($name)
    {
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
}
