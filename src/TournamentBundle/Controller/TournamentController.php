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
use TournamentBundle\Entity\Score;
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
    public function postCreateTournamentAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

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
    public function getTournamentsAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $page = $request->query->get('page', '1');
        $limit = $request->query->get('limit', 20);
        $orderBy = array('id' => $request->query->get('order', 'asc'));
        $offset = ($page - 1) * $limit;

        $data = $this->getDoctrine()
            ->getRepository('TournamentBundle:Tournament')
            ->findBy(array(), $orderBy, $limit, $offset);
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
    public function getTournamentByIdAction($id, Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

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
    public function getTournamentByNameAction($name, Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

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

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
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

    /**
     * @Route("/set/rules")
     * @Method({"POST"})
     */
    public function postSetRulesAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $body = $request->getContent();
        $rules = $this->serializer->deserialize($body, 'TournamentBundle\Dto\AddRules', 'json');
        if ($rules != null) {
            $data = $this->getDoctrine()
                ->getRepository('TournamentBundle:Tournament')
                ->findOneBy(array('id' => $rules->getTournamentId()));

            $em = $this->getDoctrine()->getManager();
            foreach ($data->getRules() as $rule) {
                $data->removeRule($rule);
                $rule->setTournament(null);
            }

            foreach ($rules->getRules() as $rule) {
                $rule->setTournament($data);
                $data->addRule($rule);
            }

            $em->persist($data);
            $em->flush();

            $response = new \TournamentBundle\Dto\Tournament();
            $response->entityToDto($data);

            $data = $this->getDoctrine()
                ->getRepository('TournamentBundle:Rule')
                ->findBy(array('tournament' => null));

            foreach ($data as $rule) {
                $em->remove($rule);
            }
            $em->flush();

            return new Response($this->serializer->serialize($response, 'json'), Response::HTTP_OK);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route("/tournaments/search/{name}/name")
     * @Method({"GET", "OPTIONS"})
     */
    public function searchTournamentsAction($name, Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }
        $em = $this->getDoctrine();
        $result = $em->getRepository("TournamentBundle:Tournament")->createQueryBuilder('t')
            ->Where('t.name LIKE :name')
            ->setParameter('name', '%' . $name . '%')
            ->getQuery()
            ->getResult();
        $tournamentsDto = array();
        foreach ($result as $tournament) {
            $dto = new \TournamentBundle\Dto\Tournament();
            $dto->EntityToDto($tournament);
            $tournamentsDto[] = $dto;
        }
        $json = $this->serializer->serialize($tournamentsDto, 'json');
        return new Response($json);
    }


    /**
     * @Route("/add/player")
     * @Method({"POST"})
     */
    public function addPlayerAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }
        $body = $request->getContent();
        $player = $this->serializer->deserialize($body, 'TournamentBundle\Dto\PlayerDto', 'json');
        if ($player != null) {
            $user = $this->getDoctrine()
                ->getRepository('UserBundle:User')
                ->findOneBy(array('name' => $player->getName()));
            if ($user != null) {
                $tournament = $this->getDoctrine()
                    ->getRepository('TournamentBundle:Tournament')
                    ->findOneBy(array('id' => $player->getTournamentId()));

                if ($tournament != null) {
                    foreach ($tournament->getPlayers() as $p) {
                        if ($p->getName() == $player->getName()) {
                            return new Response("", Response::HTTP_FORBIDDEN);
                        }
                    }
                    $tournament->addPlayer($user);
                    $user->addTournamentIn($tournament);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($tournament);
                    $em->persist($user);
                    $em->flush();

                    $response = new \TournamentBundle\Dto\Tournament();
                    $response->entityToDto($tournament);
                    $json = $this->serializer->serialize($response, 'json');
                    return new Response($json);
                }
                return new Response($player->getTournamentId() . "doesn't exist", Response::HTTP_FORBIDDEN);
            }
            return new Response($player->getName() . "doesn't exist", Response::HTTP_FORBIDDEN);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }


    /**
     * @Route("/remove/player")
     * @Method({"POST"})
     */
    public function removePlayerAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }
        $body = $request->getContent();
        $player = $this->serializer->deserialize($body, 'TournamentBundle\Dto\PlayerDto', 'json');
        if ($player != null) {
            $user = $this->getDoctrine()
                ->getRepository('UserBundle:User')
                ->findOneBy(array('name' => $player->getName()));
            if ($user != null) {
                $tournament = $this->getDoctrine()
                    ->getRepository('TournamentBundle:Tournament')
                    ->findOneBy(array('id' => $player->getTournamentId()));

                if ($tournament != null) {
                    $tournament->removePlayer($user);
                    $user->removeTournamentIn($tournament);


                    $em = $this->getDoctrine()->getManager();
                    $em->persist($tournament);
                    $em->persist($user);
                    $em->flush();


                    $response = new \TournamentBundle\Dto\Tournament();
                    $response->entityToDto($tournament);
                    $json = $this->serializer->serialize($response, 'json');
                    return new Response($json);
                }
                return new Response("", Response::HTTP_FORBIDDEN);
            }
            return new Response("", Response::HTTP_FORBIDDEN);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("/add/scores")
     * @Method({"POST"})
     */
    public function addTournamentTurnAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        /*if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }*/
        $body = $request->getContent();
        $tabScoreDto = $this->serializer->deserialize($body, 'TournamentBundle\Dto\TabScoreDto', 'json');
        if ($tabScoreDto != null) {
            $tournament = $this->getDoctrine()
                ->getRepository('TournamentBundle:Tournament')
                ->findOneBy(array('id' => $tabScoreDto->getTournamentId()));

            if ($tournament != null) {
                $em = $this->getDoctrine()->getManager();
                foreach ($tabScoreDto->getScores() as $scoreDto) {
                    $score = new Score();
                    $score->setTurn($tabScoreDto->getTurn());
                    $user = $this->getDoctrine()
                        ->getRepository('UserBundle:User')
                        ->findOneBy(array('id' => $scoreDto->getPlayerId()));
                    $score->setPlayer($user);
                    $team = $this->getDoctrine()
                        ->getRepository('TournamentBundle:Team')
                        ->findOneBy(array('id' => $scoreDto->getTeamId()));
                    $score->setTeam($team);
                    $rule = $this->getDoctrine()
                        ->getRepository('TournamentBundle:Rule')
                        ->findOneBy(array('tournament' => $tournament, 'position' => $scoreDto->getPosition()));
                    if ($rule == null) {
                        return new Response('', Response::HTTP_NOT_FOUND);
                    }
                    $score->setValue($rule->getEarnedScore());
                    $score->setPosition($rule->getPosition());
                    $tournament->addScore($score);
                    $score->setTournament($tournament);
                    $em->persist($score);
                }
                $em->persist($tournament);
                $em->flush();
                $response = new \TournamentBundle\Dto\Tournament();
                $response->entityToDto($tournament);
                $json = $this->serializer->serialize($response, 'json');

                return new Response($json);
            }
            return new Response('', Response::HTTP_NOT_FOUND);
        }
        return new Response('', Response::HTTP_BAD_REQUEST);
    }
}
