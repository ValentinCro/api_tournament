<?php

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tournament
 *
 * @ORM\Table(name="tournament")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\TournamentRepository")
 */
class Tournament
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=80)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="private", type="boolean")
     */
    private $private;

    /**
     * @var bool
     *
     * @ORM\Column(name="isInTeam", type="boolean")
     */
    private $isInTeam;

    /**
     * @ORM\OneToMany(targetEntity="TournamentBundle\Entity\Score", mappedBy="tournament", cascade={"persist"})
     */
    private $scores;

    /**
     *
     * @ORM\ManyToMany(targetEntity="TournamentBundle\Entity\Team", mappedBy="tournamentsIn", cascade={"persist"})
     */
    private $teams;

    /**
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", mappedBy="tournamentIn", cascade={"persist"})
     */
    private $players;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="createdTournaments")
     */
    private $creator;

    /**
     * @ORM\OneToMany(targetEntity="TournamentBundle\Entity\Rule", mappedBy="tournament", cascade={"persist"})
     */
    private $rules;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Tournament
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set private
     *
     * @param boolean $private
     *
     * @return Tournament
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return bool
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set isInTeam
     *
     * @param boolean $isInTeam
     *
     * @return Tournament
     */
    public function setIsInTeam($isInTeam)
    {
        $this->isInTeam = $isInTeam;

        return $this;
    }

    /**
     * Get isInTeam
     *
     * @return bool
     */
    public function getIsInTeam()
    {
        return $this->isInTeam;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rules = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add score
     *
     * @param \TournamentBundle\Entity\Score $score
     *
     * @return Tournament
     */
    public function addScore(\TournamentBundle\Entity\Score $score)
    {
        $this->scores[] = $score;

        return $this;
    }

    /**
     * Remove score
     *
     * @param \TournamentBundle\Entity\Score $score
     */
    public function removeScore(\TournamentBundle\Entity\Score $score)
    {
        $this->scores->removeElement($score);
    }

    /**
     * Get scores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getScores()
    {
        return $this->scores;
    }

    /**
     * Add team
     *
     * @param \TournamentBundle\Entity\Team $team
     *
     * @return Tournament
     */
    public function addTeam(\TournamentBundle\Entity\Team $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \TournamentBundle\Entity\Team $team
     */
    public function removeTeam(\TournamentBundle\Entity\Team $team)
    {
        $this->teams->removeElement($team);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Add player
     *
     * @param \UserBundle\Entity\User $player
     *
     * @return Tournament
     */
    public function addPlayer(\UserBundle\Entity\User $player)
    {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \UserBundle\Entity\User $player
     */
    public function removePlayer(\UserBundle\Entity\User $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set creator
     *
     * @param \UserBundle\Entity\User $creator
     *
     * @return Tournament
     */
    public function setCreator(\UserBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \UserBundle\Entity\User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Tournament
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add rule
     *
     * @param \TournamentBundle\Entity\Rule $rule
     *
     * @return Tournament
     */
    public function addRule(\TournamentBundle\Entity\Rule $rule)
    {
        $this->rules[] = $rule;

        return $this;
    }

    /**
     * Remove rule
     *
     * @param \TournamentBundle\Entity\Rule $rule
     */
    public function removeRule(\TournamentBundle\Entity\Rule $rule)
    {
        $this->rules->removeElement($rule);
    }

    /**
     * Get rules
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRules()
    {
        return $this->rules;
    }
}
