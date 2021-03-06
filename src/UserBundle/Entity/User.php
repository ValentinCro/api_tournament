<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 */
class User
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
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="tokenValidityDate", type="datetime")
     */
    private $tokenValidityDate;

    /**
     * @ORM\OneToMany(targetEntity="TournamentBundle\Entity\Tournament", mappedBy="creator")
     */
    private $createdTournaments;

    /**
     * @ORM\ManyToMany(targetEntity="TournamentBundle\Entity\Tournament", inversedBy="players")
     * @ORM\JoinTable(name="user_tournament")
     */
    private $tournamentIn;

    /**
     * @var int
     *
     * @ORM\OneToMany(targetEntity="TournamentBundle\Entity\Team", mappedBy="leader")
     */
    private $teamsFounded;

    /**
     * @var int
     *
     * @ORM\ManyToMany(targetEntity="TournamentBundle\Entity\Team", inversedBy="players")
     */
    private $teamsIn;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdTournaments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tournamentIn = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teamsFounded = new \Doctrine\Common\Collections\ArrayCollection();
        $this->teamsIn = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return User
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
     * Set tokenValidityDate
     *
     * @param \DateTime $tokenValidityDate
     *
     * @return User
     */
    public function setTokenValidityDate($tokenValidityDate)
    {
        $this->tokenValidityDate = $tokenValidityDate;

        return $this;
    }

    /**
     * Get tokenValidityDate
     *
     * @return \DateTime
     */
    public function getTokenValidityDate()
    {
        return $this->tokenValidityDate;
    }

    /**
     * Add createdTournament
     *
     * @param \TournamentBundle\Entity\Tournament $createdTournament
     *
     * @return User
     */
    public function addCreatedTournament(\TournamentBundle\Entity\Tournament $createdTournament)
    {
        $this->createdTournaments[] = $createdTournament;

        return $this;
    }

    /**
     * Remove createdTournament
     *
     * @param \TournamentBundle\Entity\Tournament $createdTournament
     */
    public function removeCreatedTournament(\TournamentBundle\Entity\Tournament $createdTournament)
    {
        $this->createdTournaments->removeElement($createdTournament);
    }

    /**
     * Get createdTournaments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCreatedTournaments()
    {
        return $this->createdTournaments;
    }

    /**
     * Add tournamentIn
     *
     * @param \TournamentBundle\Entity\Tournament $tournamentIn
     *
     * @return User
     */
    public function addTournamentIn(\TournamentBundle\Entity\Tournament $tournamentIn)
    {
        $this->tournamentIn[] = $tournamentIn;

        return $this;
    }

    /**
     * Remove tournamentIn
     *
     * @param \TournamentBundle\Entity\Tournament $tournamentIn
     */
    public function removeTournamentIn(\TournamentBundle\Entity\Tournament $tournamentIn)
    {
        $this->tournamentIn->removeElement($tournamentIn);
    }

    /**
     * Get tournamentIn
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTournamentIn()
    {
        return $this->tournamentIn;
    }

    /**
     * Add teamsFounded
     *
     * @param \TournamentBundle\Entity\Team $teamsFounded
     *
     * @return User
     */
    public function addTeamsFounded(\TournamentBundle\Entity\Team $teamsFounded)
    {
        $this->teamsFounded[] = $teamsFounded;

        return $this;
    }

    /**
     * Remove teamsFounded
     *
     * @param \TournamentBundle\Entity\Team $teamsFounded
     */
    public function removeTeamsFounded(\TournamentBundle\Entity\Team $teamsFounded)
    {
        $this->teamsFounded->removeElement($teamsFounded);
    }

    /**
     * Get teamsFounded
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamsFounded()
    {
        return $this->teamsFounded;
    }

    /**
     * Add teamsIn
     *
     * @param \TournamentBundle\Entity\Team $teamsIn
     *
     * @return User
     */
    public function addTeamsIn(\TournamentBundle\Entity\Team $teamsIn)
    {
        $this->teamsIn[] = $teamsIn;

        return $this;
    }

    /**
     * Remove teamsIn
     *
     * @param \TournamentBundle\Entity\Team $teamsIn
     */
    public function removeTeamsIn(\TournamentBundle\Entity\Team $teamsIn)
    {
        $this->teamsIn->removeElement($teamsIn);
    }

    /**
     * Get teamsIn
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamsIn()
    {
        return $this->teamsIn;
    }
}
