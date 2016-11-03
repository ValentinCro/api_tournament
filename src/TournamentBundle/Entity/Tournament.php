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
     * @var string
     *
     * @ORM\Column(name="type", type="string")
     */
    private $type;

    /**
     * @var bool
     *
     * @ORM\Column(name="isInTeam", type="boolean")
     */
    private $isInTeam;

    /**
     * @var bool
     *
     * @ORM\Column(name="removed", type="boolean")
     */
    private $removed;

    /**
     * @var bool
     *
     * @ORM\Column(name="finished", type="boolean")
     */
    private $finished;

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
     * @ORM\OneToOne(targetEntity="TournamentBundle\Entity\Rule", cascade={"persist"})
     * @ORM\JoinColumn(name="rule_id", referencedColumnName="id")
     */
    private $rules;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * @return boolean
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Tournament
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
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
     * @return boolean
     */
    public function getIsInTeam()
    {
        return $this->isInTeam;
    }

    /**
     * Set removed
     *
     * @param boolean $removed
     *
     * @return Tournament
     */
    public function setRemoved($removed)
    {
        $this->removed = $removed;

        return $this;
    }

    /**
     * Get removed
     *
     * @return boolean
     */
    public function getRemoved()
    {
        return $this->removed;
    }

    /**
     * Set finished
     *
     * @param boolean $finished
     *
     * @return Tournament
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get finished
     *
     * @return boolean
     */
    public function getFinished()
    {
        return $this->finished;
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
     * Set rules
     *
     * @param \TournamentBundle\Entity\Rule $rules
     *
     * @return Tournament
     */
    public function setRules(\TournamentBundle\Entity\Rule $rules = null)
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Get rules
     *
     * @return \TournamentBundle\Entity\Rule
     */
    public function getRules()
    {
        return $this->rules;
    }
}
