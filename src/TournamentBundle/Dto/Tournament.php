<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use TournamentBundle\TournamentBundle;
use UserBundle\Entity\User;

class Tournament {
    /**
     * @var integer
     *
     * @Type("integer")
     */
    private $id;

    /**
     * @var string
     * @Type("string")
     */
    private $name;

    /**
     * @var User
     * @Type("UserBundle\Entity\User")
     */
    private $creator;

    /**
     * @var array
     * @Type("array<UserBundle\Entity\User>")
     */
    private $players;

    /**
     * @var boolean
     * @Type("boolean")
     */
    private $private;

    /**
     * @var array
     * @Type("array<UserBundle\Entity\User>")
     */
    private $teams;

    /**
     * @var boolean
     * @Type("boolean")
     */
    private $inTeam;

    /**
     * @var array
     * @Type("array<TournamentBundle\Entity\Score>")
     */
    private $scores;

    public function entityToDto(\TournamentBundle\Entity\Tournament $tournament) {
        $this->setId($tournament->getId());
        $this->setName($tournament->getName());
        $this->setCreator($tournament->getCreator());
        $this->setPrivate($tournament->getPrivate());
        $this->setInTeam($tournament->getIsInTeam());
        $this->setPlayers($tournament->getPlayers()->toArray());
        $this->setTeams($tournament->getTeams()->toArray());
        $this->setScores($tournament->getScores()->toArray());
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @param User $creator
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param array $players
     */
    public function setPlayers($players)
    {
        $this->players = $players;
    }

    /**
     * @return boolean
     */
    public function isPrivate()
    {
        return $this->private;
    }

    /**
     * @param boolean $private
     */
    public function setPrivate($private)
    {
        $this->private = $private;
    }

    /**
     * @return array
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * @param array $teams
     */
    public function setTeams($teams)
    {
        $this->teams = $teams;
    }

    /**
     * @return boolean
     */
    public function isInTeam()
    {
        return $this->inTeam;
    }

    /**
     * @param boolean $inTeam
     */
    public function setInTeam($inTeam)
    {
        $this->inTeam = $inTeam;
    }

    /**
     * @return array
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * @param array $scores
     */
    public function setScores($scores)
    {
        $this->scores = $scores;
    }

}

