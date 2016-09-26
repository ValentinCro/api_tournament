<?php

namespace UserBundle\Dto;

class User
{
    private $id;

    private $name;

    private $date;

    private $createdTournaments;

    private $tournamentIn;

    private $teamsFounded;

    private $teamsIn;

    public function entityToDto(\UserBundle\Entity\User $user) {
        $this->id = $user->getId();
        $this->name = $user->getName();
        $this->date = $user->getDate();
        $this->createdTournaments = $user->getCreatedTournaments();
        $this->tournamentIn = $user->getTournamentIn();
        $this->teamsFounded = $user->getTeamsFounded();
        $this->teamsIn = $user->getTeamsIn();
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
