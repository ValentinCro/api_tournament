<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use UserBundle\Dto\User;

class ScoreFFA extends Score
{


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
    private $turn;

    public function entityToDto(\TournamentBundle\Entity\ScoreFFA $score) {
        $this->setId($score->getId());
        $this->setValue($score->getValue());
        $this->setDescription($score->getDescription());
        $player = new \UserBundle\Dto\User();
        $player->entityToDto($score->getPlayer());
        $this->setPlayer($player);
        $this->setPosition($score->getPosition());
        $this->setTeam($score->getTeam());
        $this->setTurn($score->getTurn());
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
}
