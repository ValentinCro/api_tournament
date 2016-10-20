<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use UserBundle\Dto\User;

class Score
{
    /**
     * @var integer
     * @type("integer")
     */
    private $id;


    /**
     * @var User
     * @Type("UserBundle\Dto\User")
     */
    private $player;

    /**
     * @var array
     * @Type("array<UserBundle\Entity\User>")
     */
    private $team;

    /**
     * @var int
     * @type("integer")
     */
    private $value;

    /**
     * @var int
     * @type("integer")
     */
    private $position;

    /**
     * @var int
     * @type("integer")
     */
    private $turn;

    public function entityToDto(\TournamentBundle\Entity\Score $score) {
        $this->setId($score->getId());
        $player = new \UserBundle\Dto\User();
        $player->entityToDto($score->getPlayer());
        $this->setPlayer($player);
        $this->setPosition($score->getPosition());
        $this->setTeam($score->getTeam());
        $this->setTurn($score->getTurn());
        $this->setValue($score->getValue());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param User $player
     */
    public function setPlayer($player)
    {
        $this->player = $player;
    }

    /**
     * @return array
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * @param array $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param mixed $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * @param mixed $turn
     */
    public function setTurn($turn)
    {
        $this->turn = $turn;
    }

    /**
     * @return Tournament
     */
    public function getTournament()
    {
        return $this->tournament;
    }

    /**
     * @param Tournament $tournament
     */
    public function setTournament($tournament)
    {
        $this->tournament = $tournament;
    }
}
