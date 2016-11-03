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
use TournamentBundle\Dto\ScoreFFAGameDto;
use TournamentBundle\Entity\Rule;
use TournamentBundle\Entity\Score;
use TournamentBundle\Entity\ScoreFFA;
use TournamentBundle\Entity\ScoreFFAGame;
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
            $user = $this->getDoctrine()
                ->getRepository('UserBundle:User')
                ->findOneBy(array('name' => $tournamentCreate->getCreator()));
            $tournament->setCreator($user);
            $tournament->setName(htmlspecialchars($tournamentCreate->getName()));
            $tournament->setPrivate($tournamentCreate->isPrivate());
            $tournament->setIsInTeam($tournamentCreate->isInTeam());
            $tournament->setRemoved(false);
            $tournament->setFinished(false);
            $data = $this->getDoctrine()
                ->getRepository('TournamentBundle:Type')
                ->findOneBy(array('name' => $tournamentCreate->getType()));
            if ($data == null) {
                return new Response('', Response::HTTP_BAD_REQUEST);
            }
            $tournament->setType($data->getName());
            if (!$tournament->getIsInTeam()) {
                $tournament->addPlayer($user);
                $user->addTournamentIn($tournament);
            }
            $tournament->setDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($tournament);
            $em->persist($user);
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
            ->findBy(array('removed'=> false), $orderBy, $limit, $offset);
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
                ->findBy(array('creator' => $data, 'removed'=> false), $orderBy, $limit, $offset);
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

        /*if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }*/

        $body = $request->getContent();
        $rulesDto = $this->serializer->deserialize($body, 'TournamentBundle\Dto\AddRules', 'json');
        if ($rulesDto != null) {
            $tournament = $this->getDoctrine()
                ->getRepository('TournamentBundle:Tournament')
                ->findOneBy(array('id' => $rulesDto->getTournamentId()));

            if ($tournament->getRules() != null) {
                $tournament->getRules()->setTournament(null);
                $tournament->setRules(null);
            }

            $em = $this->getDoctrine()->getManager();
            if ($tournament->getType() == "FFA") {

                $rules = new Rule();
                $rules->setTournament($tournament);

                foreach ($rulesDto->getRulesFFA() as $rule) {
                    $rules->addRulesFFA($rule);
                    $rule->setRule($rules);
                }
                $tournament->setRules($rules);
                $em->persist($rules);
            } else if ($tournament->getType() == "FFA_GAME") {

                $rules = new Rule();
                $rules->setTournament($tournament);

                foreach ($rulesDto->getRulesFFAGame() as $rule) {
                    $rules->addRulesFFAGame($rule);
                    $rule->setRule($rules);
                }
                $em->persist($rules);
                $tournament->setRules($rules);
            }

            $em->persist($tournament);
            $em->flush();

            $response = new \TournamentBundle\Dto\Tournament();
            $response->entityToDto($tournament);

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
            ->andWhere('t.removed = false')
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
     * @Route("/add/scores/FFA")
     * @Method({"POST"})
     */
    public function addTournamentTurnAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }
        $body = $request->getContent();
        $tabScoreDto = $this->serializer->deserialize($body, 'TournamentBundle\Dto\TabScoreDto', 'json');
        if ($tabScoreDto != null) {
            $tournament = $this->getDoctrine()
                ->getRepository('TournamentBundle:Tournament')
                ->findOneBy(array('id' => $tabScoreDto->getTournamentId()));

            if ($tournament != null) {
                $em = $this->getDoctrine()->getManager();
                foreach ($tabScoreDto->getScores() as $scoreDto) {
                    $score = new ScoreFFA();
                    $score->setDescription($scoreDto->getDescription());
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
                        ->getRepository('TournamentBundle:RuleFFA')
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

    /**
     * @Route("/add/scores/FFAGame")
     * @Method({"POST"})
     */
    public function addTournamentFFAGameAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }
        $body = $request->getContent();
        $scoreFFAGameDto = $this->serializer->deserialize($body, 'TournamentBundle\Dto\ScoreFFAGameDto', 'json');
        if ($scoreFFAGameDto != null) {
            $tournament = $this->getDoctrine()
                ->getRepository('TournamentBundle:Tournament')
                ->findOneBy(array('id' => $scoreFFAGameDto->getTournamentId()));

            if ($tournament != null) {
                $em = $this->getDoctrine()->getManager();
                $winner = $this->getDoctrine()
                    ->getRepository('UserBundle:User')
                    ->findOneBy(array('login' => $scoreFFAGameDto->getWinner()));
                if ($winner != null) {
                    $looser = $this->getDoctrine()
                        ->getRepository('UserBundle:User')
                        ->findOneBy(array('login' => $scoreFFAGameDto->getLooser()));
                    if ($looser != null) {
                        $scoreFFAGame = new ScoreFFAGame();
                        $scoreFFAGame->setDescription($scoreFFAGameDto->getDescription());
                        $scoreFFAGame->setLooser($looser);
                        $scoreFFAGame->setWinner($winner);
                        $scoreFFAGame->setTournament($tournament);
                        if ($scoreFFAGameDto->isNull) {
                            $rule = $this->getDoctrine()
                                ->getRepository('TournamentBundle:RuleFFAGame')
                                ->findOneBy(array('tournament' => $tournament, 'win' => false, 'loose' => false));
                            if ($rule == null) {
                                return new Response('', Response::HTTP_NOT_FOUND);
                            }
                            $scoreFFAGame->setNullValue($rule->getEarnedScore());
                            $scoreFFAGame->setValue(0);
                            $scoreFFAGame->setLooseValue(0);
                            $scoreFFAGame->setNull(true);
                        } else {
                            $winRule = $this->getDoctrine()
                                ->getRepository('TournamentBundle:RuleFFAGame')
                                ->findOneBy(array('tournament' => $tournament, 'win' => true, 'loose' => false));
                            if ($winRule == null) {
                                return new Response('', Response::HTTP_NOT_FOUND);
                            }
                            $looseRule = $this->getDoctrine()
                                ->getRepository('TournamentBundle:RuleFFAGame')
                                ->findOneBy(array('tournament' => $tournament, 'win' => false, 'loose' => true));
                            if ($looseRule == null) {
                                return new Response('', Response::HTTP_NOT_FOUND);
                            }
                            $scoreFFAGame->setNullValue(0);
                            $scoreFFAGame->setValue($winRule->getEarnedScore());
                            $scoreFFAGame->setLooseValue($looseRule->getEarnedScore());
                            $scoreFFAGame->setNull(false);
                        }
                        $tournament->addScore($scoreFFAGame);
                        $em->persist($scoreFFAGame);
                        $em->persist($tournament);
                        $em->flush();
                        $response = new \TournamentBundle\Dto\Tournament();
                        $response->entityToDto($tournament);
                        $json = $this->serializer->serialize($response, 'json');

                        return new Response($json);
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
     * @Route("/remove/tournament/{id}/id")
     * @Method({"GET"})
     */
    public function removeTournamentAction($id, Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $tournament = $this->getDoctrine()
            ->getRepository('TournamentBundle:Tournament')
            ->findOneBy(array('id' => $id));

        if ($tournament != null) {
            $em = $this->getDoctrine()->getManager();
            $tournament->setRemoved(true);
            $em->persist($tournament);
            $em->flush();
            $response = new \TournamentBundle\Dto\Tournament();
            $response->entityToDto($tournament);
            $json = $this->serializer->serialize($response, 'json');
            return new Response($json, Response::HTTP_OK);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }


    /**
     * @Route("/remove/team/{id}/id")
     * @Method({"GET"})
     */
    public function removeTeamAction($id, Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }


        $team = $this->getDoctrine()
            ->getRepository('TournamentBundle:Team')
            ->findOneBy(array('id' => $id));

        if ($team != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($team);
            $em->flush();
            return new Response('', Response::HTTP_OK);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }


    /**
     * @Route("/type")
     * @Method({"GET"})
     */
    public function getTypeAction(Request $request)
    {
        $token = $request->headers->get("Authorization");

        $data = $this->getDoctrine()
            ->getRepository('UserBundle:User')
            ->findOneBy(array('token' => $token));

        if ($data == null) {
            return new Response("", Response::HTTP_FORBIDDEN);
        }

        $type = $this->getDoctrine()
            ->getRepository('TournamentBundle:Type')
            ->findAll();

        if ($type != null) {
            $json = $this->serializer->serialize($type, 'json');
            return new Response($json, Response::HTTP_OK);
        }
        return new Response('', Response::HTTP_NOT_FOUND);
    }
}
