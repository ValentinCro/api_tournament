<?php

namespace TournamentBundle\Dto;

use JMS\Serializer\Annotation\Type;
use TournamentBundle\TournamentBundle;
use UserBundle\Dto\User;

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
     * @Type("UserBundle\Dto\User")
     */
    private $creator;

    /**
     * @var array
     * @Type("array<UserBundle\Dto\User>")
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
     * @Type("array<TournamentBundle\Dto\Score>")
     */
    private $scores;

    /**
     * @var array
     * @Type("array<TournamentBundle\Entity\Rule>")
     */
    private $rules;

    /**
     * @var \TournamentBundle\Entity\Type
     * @Type("TournamentBundle\Entity\Type")
     */
    private  $type;

    /**
     * @var \DateTime
     * @Type("datetime")
     */
    private $date;

    public function entityToDto(\TournamentBundle\Entity\Tournament $tournament) {
        $this->setId($tournament->getId());
        $this->setName($tournament->getName());
        $creator = new \UserBundle\Dto\User();
        $creator->entityToDto($tournament->getCreator());
        $this->setCreator($creator);
        $this->setPrivate($tournament->getPrivate());
        $this->setInTeam($tournament->getIsInTeam());
        $tmp = [];
        foreach ($tournament->getPlayers() as $player) {
            $userDto = new \UserBundle\Dto\User();
            $userDto->entityToDto($player);
            $tmp[] = $userDto;
        }
        $this->setPlayers($tmp);
        $this->setTeams($tournament->getTeams()->toArray());
        $tmp = [];
        foreach ($tournament->getScores() as $score) {
            $scoreDto = new \TournamentBundle\Dto\Score();
            $scoreDto->entityToDto($score);
            $tmp[] = $scoreDto;
        }
        $this->setScores($tmp);
        $this->setRules($tournament->getRules()->toArray());
        $this->setDate($tournament->getDate());
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

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Tournament
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return $this->rules;
    }

    /**
     * @param array $rules
     * @return Tournament
     */
    public function setRules($rules)
    {
        $this->rules = $rules;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Tournament
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

}

