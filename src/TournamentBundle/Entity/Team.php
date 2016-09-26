<?php

namespace TournamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Team
 *
 * @ORM\Table(name="team")
 * @ORM\Entity(repositoryClass="TournamentBundle\Repository\TeamRepository")
 */
class Team
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=80)
     */
    private $name;

    /**
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\User", mappedBy="teamsIn")
     */
    private $players;

    /**
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="teamsFounded")
     */
    private $leader;


    /**
     *
     * @ORM\ManyToMany(targetEntity="TournamentBundle\Entity\Tournament", inversedBy="teams")
     */
    private $tournamentsIn;

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
     * Constructor
     */
    public function __construct()
    {
        $this->players = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tournamentsIn = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Team
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
     * Add player
     *
     * @param \UserBundle\Entity\User $player
     *
     * @return Team
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
     * Set leader
     *
     * @param \UserBundle\Entity\User $leader
     *
     * @return Team
     */
    public function setLeader(\UserBundle\Entity\User $leader = null)
    {
        $this->leader = $leader;

        return $this;
    }

    /**
     * Get leader
     *
     * @return \UserBundle\Entity\User
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * Add tournamentsIn
     *
     * @param \TournamentBundle\Entity\Tournament $tournamentsIn
     *
     * @return Team
     */
    public function addTournamentsIn(\TournamentBundle\Entity\Tournament $tournamentsIn)
    {
        $this->tournamentsIn[] = $tournamentsIn;

        return $this;
    }

    /**
     * Remove tournamentsIn
     *
     * @param \TournamentBundle\Entity\Tournament $tournamentsIn
     */
    public function removeTournamentsIn(\TournamentBundle\Entity\Tournament $tournamentsIn)
    {
        $this->tournamentsIn->removeElement($tournamentsIn);
    }

    /**
     * Get tournamentsIn
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTournamentsIn()
    {
        return $this->tournamentsIn;
    }
}
